#!/util/bin/python

import cx_Oracle,os,signal,socket,sys,time
import xml.sax.handler
from datetime import datetime,timedelta


# these must end with slash
mirrdir = 'mirror/'
logdir = 'logs/'

# oracle connection string
oraconn = 'slxasync/c0piiRn2@seqdel1'

# design notes:
# all datetime objects are to be handled as UTC, except possibly on output
# (avoids DST problems)

# from http://aspn.activestate.com/ASPN/Cookbook/Python/Recipe/137270
def ResultIter(cursor, arraysize=1000):
    'An iterator that uses fetchmany to keep memory usage down'
    while True:
        results = cursor.fetchmany(arraysize)
        if not results:
            break
        for result in results:
            yield result

orcl = cx_Oracle.connect(oraconn)
curs = orcl.cursor()

class LogHandler(xml.sax.handler.ContentHandler):
    def __init__(self):
        self.in_gap = False
        self.start_ok = False
        self.must_stop = True
        self.deck_state = 'unknown'
        self.last_conv_path = ''
        self.next_check = 15 * 60
    
    def startElement(self,name,attributes):
        if name == 'CONVERSION':
            self.last_conv_path = attributes.get('Path')
            self.deck_state = 'running'
            if '\\D' in self.last_conv_path:
                self.in_gap = True
                self.start_ok = True
            else:
                self.in_gap = False
        elif name == 'PUMP_TO_FLOWCELL':
            self.in_gap = True
            self.deck_state = 'running'
            if '\\D' in self.last_conv_path:
                solution = int(attributes.get('Solution'))
                if solution in [1, 5]:
                    self.start_ok = False
                elif solution in [3, 4]:
                    self.in_gap = False
        if self.in_gap:
            self.next_check = 5 * 60
        elif name == 'INCOMPLETE' or name == 'PARTIAL_SAFE_STATE':
            # run stopped
            self.start_ok = True
            self.must_stop = False
            self.deck_state = 'idle'
            # FIXME check file timestamp and use that as base
            self.next_check = 15*60
        else:
            self.start_ok = False
            self.must_stop = True
            self.next_check = 15*60

def logmsg(msg):
    print time.ctime(),msg
    sys.stdout.flush()

def run_status(logfile):
    parser = xml.sax.make_parser()

    handler = LogHandler()
    parser.setContentHandler(handler)

    # catch exception: xml.sax._exceptions.SAXParseException
    # if we catch that, finish up; file is incomplete
    logfobj = open(logfile)
    try:
        parser.parse(logfobj)
    except xml.sax._exceptions.SAXParseException:
        pass
    logfobj.close()
    return (handler.start_ok, handler.must_stop,
            handler.next_check, handler.deck_state)

def update_run_info(deck,rundir,logfile,log_mtime):
    run_name = os.path.basename(rundir)
    log_change = datetime.utcfromtimestamp(log_mtime)
    curs.execute("""SELECT log_last_changed FROM runs
    WHERE run_name = :rname AND deck_name = :dname""",
                 rname=run_name,dname=deck)
    result = curs.fetchone()
    if result:
        lastlogdate = result[0]
    else:
        lastlogdate = None
    # the "if not" is to cover None return, which would break comparison
    if not lastlogdate or lastlogdate > log_change:
        curs.execute("""MERGE INTO runs r USING dual ON (r.run_name = :rname)
        WHEN matched THEN
        UPDATE SET log_last_changed = :mtime, log_currfile = :logcurr
        WHEN NOT matched THEN
        INSERT (run_name, deck_name, run_sourcepath, log_currfile,
                log_last_changed, state)
        VALUES (:rname,:dname,:rpath,:logcurr, :mtime,:state)""",
                     rname=run_name,dname=deck,rpath=rundir, logcurr=logfile,
                     mtime=log_change,state='pending')

def check_deck(deck,basedir):
    logpath = os.path.join(basedir,logdir)
    if not os.path.exists(logpath):
        os.makedirs(logpath)
    if os.spawnlp(os.P_WAIT,'rsync',
                  'rsync','-a','--delete',
                  '--exclude=Focus*/','--exclude=Images*/',
                  '--exclude=Data*/',
                  '%s::runs/' % deck, logpath) != 0:
        sys.exit('rsync of logs failed')
    newest = {'time': 0, 'path': ''}
    for (dirname,dirs,files) in os.walk(logpath):
        for file in files:
            if (file.startswith('Log.xml_') or file.startswith('RunLog_')) \
                   and file.endswith('.xml'):
                path = os.path.join(dirname,file)
                xmllog = open(path)
                foundconv = 0
                for line in xmllog:
                    if 'CONVERSION' in line:
                        foundconv = 1
                        break
                xmllog.close()
                if foundconv:
                    rundir = dirname[len(logpath):]
                    mtime = os.path.getmtime(path)
                    update_run_info(deck,rundir,path,mtime)
                    if mtime > newest['time']:
                        newest['time'] = mtime
                        newest['path'] = path
    # commit all the run status updates
    orcl.commit()
    logmsg('parsing logfile %s, mtime %s' % (newest['path'],
                                             time.ctime(newest['time'])))
    (can_start, must_stop,
     next_check_secs, deck_state) = run_status(newest['path'])
    # update deck state in database
    this_check = datetime.utcnow()
    next_check = this_check + timedelta(seconds=next_check_secs)
    curs.execute("""UPDATE decks SET state = :dstate,
    state_check_last = :this, state_check_next = :next
    WHERE decks.deck_name = :dname""",
                 dstate=deck_state,this=this_check,next=next_check,dname=deck)
    orcl.commit()
    return (can_start,must_stop,next_check_secs,newest['time'])

def check_pid(pid):
    # False: no pid
    # True: pid is still running
    # other: pid finished, return is exit tuple
    if not pid:
        return False
    else:
        retval = os.waitpid(pid, os.WNOHANG)
        if retval == (0,0):
            return True
        return retval

def get_basedir(deck):
    myname = socket.getfqdn()
    mypid = os.getpid()
    
    curs.execute("""SELECT transfer_basedir,transfer_host,transfer_pid,
    state,state_check_last,state_check_next
    FROM decks
    WHERE deck_name = :dname""",dname=deck)
    result = curs.fetchone()
    if not result:
        sys.exit('FATAL: deck %s not found in database' % deck)
    else:
        (basedir,t_host,t_pid,deck_state,state_last,state_next) = result
    if deck_state == 'offline':
        return (None,'deck %s marked as offline' % deck)
    elif not (t_host == myname and t_pid == mypid):
        # maybe someone else has it?
        right_now = datetime.utcnow()
        # has it been twice as long as it should have been since last check?
        if not state_next or not state_last or not t_host or not t_pid or \
               (state_next - state_last) < (right_now - state_next):
            # stale data/dead process. plant our flag on it.
            curs.execute("""UPDATE decks SET transfer_host = :myname,
            transfer_pid = :mypid WHERE decks.deck_name = :dname""",
                         myname=myname,mypid=mypid,dname=deck)
            orcl.commit()
        else:
            return (None,'deck %s locked by %s:%s' % (deck,t_host,t_pid))
    return (basedir,None)

def set_run_status(run,state):
    curs.execute('UPDATE runs SET state = :rstate WHERE run_name = :rname',
                 rstate=state,rname=run)
    orcl.commit()

def find_eligible_run(deck):
    curs.execute("""SELECT run_sourcepath FROM runs
    WHERE deck_name = :dname AND (state = 'syncing' OR state = 'pending')
    ORDER BY log_last_changed ASC""",dname=deck)
    return curs.fetchone()

def main():
    pid = 0
    last_start = 0
    last_rundir = ''
    if len(sys.argv) > 1:
        deck = sys.argv[1].upper()
    else:
        sys.exit('must provide deck on command line')
    (basedir,message) = get_basedir(deck)
    if not basedir:
        sys.exit(message)
    mirrpath = os.path.join(basedir,deck,mirrdir)
    if not os.path.exists(mirrpath):
        os.makedirs(mirrpath)
    while True:
        (start_ok,stop_now,
         next_check,log_mtime) = check_deck(deck,basedir)
        pidcheck = check_pid(pid)
        logmsg('deck %s, start %s, stop %s, next %s, pid %s, chk %s' % 
               (deck, start_ok, stop_now,next_check,pid,pidcheck))
        if pidcheck == True:
            if stop_now:
                os.kill(pid,signal.SIGSTOP)
                logmsg('stopped pid %d' % pid)
            elif start_ok:
                os.kill(pid,signal.SIGCONT)
                logmsg('continued pid %d' % pid)
        else:
            # not running: no proc, or proc completed
            if pidcheck != False:
                (oldpid,exit_status) = pidcheck
                if exit_status == 0 and last_start > log_mtime:
                    logmsg('rsync completed and no log change since start')
                    set_run_status(rundir,'complete')
            if start_ok:
                rundir = find_eligible_run(deck)
                if not rundir:
                    break
                pid = os.spawnlp(os.P_NOWAIT,'rsync',
                                 'rsync','-a','-v',
                                 '%s::runs/%s' % ( deck, rundir ),
                                 mirrpath)
                last_start = time.time()
                set_run_status(os.path.basename(rundir),'syncing')
                logmsg('started rsync of %s: pid %s at %s' %
                       (rundir,pid,last_start))
            else:
                pid = 0
        if next_check < 300:
            next_check = 300
        time.sleep(next_check)
    # reached by break
    # before we exit, clean up database
    curs.execute('''UPDATE decks SET transfer_host = NULL,
    transfer_pid = NULL WHERE decks.deck_name = :dname''',
                 dname=deck)
    orcl.commit()

if __name__ == '__main__':
    main()
