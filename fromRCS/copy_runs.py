#!/util/bin/python

import sys

sys.path.append('/broad/tools/lib/python2.4/site-packages/')

import cx_Oracle,os,signal,socket,time
import xml.sax.handler
from datetime import datetime,timedelta


# these must end with slash
mirrdir = 'mirror/'
logdir = 'logs/'

stampfile = 'SyncComplete'
excludefile = '.rsync_exclude'

# oracle connection string
oraconn = 'slxasync/c0piiRn2@seqdel1'

cycle_times = {}

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

# os.spawn replacement that does setpgrp() to allow killpg()
def pg_spawnvp(prog,argv):
    'spawnvp replacement using setpgrp() and exec(), allowing parent to killpg()'
    pid = os.fork()
    if pid == 0:
        os.setpgrp()
        os.execvp(prog,argv)
    return pid

orcl = cx_Oracle.connect(oraconn)
curs = orcl.cursor()

class LogHandler(xml.sax.handler.ContentHandler):
    def __init__(self):
        self.in_gap = False
        self.start_ok = False
        self.must_stop = True
        self.deck_state = 'unknown'
        self.last_conv_path = ''
        self.last_cycle = 0
        self.next_check = 15 * 60
    
    def startElement(self,name,attributes):
        if name == 'CONVERSION':
            self.deck_state = 'running'
            self.last_conv_path = attributes.get('Path')
            lcitems = self.last_conv_path.split('\\')
            cycle_dir = lcitems[-2]
            if cycle_dir.startswith('D'):
                self.in_gap = True
                self.start_ok = True
            else:
                self.in_gap = False
            # int(float()) to turn "23.1" into 23.1 into 23
            # N.B. we return *current* (prob incomplete) cycle
            self.last_cycle = int(float(cycle_dir[1:]))
        elif name == 'PUMP_TO_FLOWCELL':
            self.in_gap = True
            self.deck_state = 'running'
            if '\\D' in self.last_conv_path:
                solution = int(attributes.get('Solution'))
                if solution in [4]:
                    self.start_ok = False
                elif solution in [3]:
                    self.in_gap = False
            else:
                self.start_ok = True
        if self.in_gap:
            self.must_stop = False
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
            handler.next_check, handler.deck_state, handler.last_cycle)

def update_run_info(deck,rundir,logfile,log_change):
    run_name = os.path.basename(rundir)
    curs.execute("""SELECT log_last_changed FROM runs
    WHERE run_name = :rname AND deck_name = :dname""",
                 rname=run_name,dname=deck)
    result = curs.fetchone()
    if result:
        lastlogdate = result[0]
    else:
        lastlogdate = datetime.utcfromtimestamp(0)
    if lastlogdate < log_change:
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
    newest = {'time': datetime.utcfromtimestamp(0), 'path': ''}
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
                    mtime = datetime.utcfromtimestamp(os.path.getmtime(path))
                    update_run_info(deck,rundir,path,mtime)
                    if mtime > newest['time']:
                        newest['time'] = mtime
                        newest['path'] = path
                        newest['name'] = os.path.basename(rundir)
    # commit all the run status updates
    orcl.commit()
    logmsg('parsing logfile %s, mtime %s' % (newest['path'],
                                             newest['time'].ctime()))
    (can_start, must_stop,
     next_check_secs, deck_state, last_cycle) = run_status(newest['path'])
    if not newest['name'] in cycle_times:
        cycle_times[newest['name']] = {}
    # xrange will give 1-(last-1), so we won't get the partial cycle
    for cyc in xrange(1,last_cycle):
        cycle_times[newest['name']].setdefault(cyc, newest['time'])
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

def set_run_status(run,state,last_sync=None):
    curs.execute('UPDATE runs SET state = :rstate WHERE run_name = :rname',
                 rstate=state,rname=run)
    if last_sync:
        curs.execute('''UPDATE runs SET last_sync_start = :lsync
        WHERE run_name = :rname''',
                 lsync=last_sync,rname=run)
    orcl.commit()

def find_eligible_run(deck):
    curs.execute("""SELECT run_sourcepath FROM runs
    WHERE deck_name = :dname AND (state = 'syncing' OR state = 'pending')
    ORDER BY log_last_changed ASC""",dname=deck)
    retval = curs.fetchone()
    if retval:
        return retval[0]
    else:
        return None

def get_log_mtime(run):
    curs.execute("SELECT log_last_changed FROM runs WHERE run_name = :rname",
                 rname=run)
    retval = curs.fetchone()
    if retval:
        if retval[0]:
            return retval[0]
    return datetime.utcfromtimestamp(0)

def write_exclude_file(destpath,rundir):
    run = os.path.basename(rundir)
    curs.execute("SELECT last_sync_start FROM runs WHERE run_name = :rname",
                 rname=run)
    result = curs.fetchone()
    if result:
        lastsync = result[0]
    else:
        lastsync = None
    destdir = os.path.join(destpath,run)
    if not os.path.exists(destdir):
        os.makedirs(destdir)
    excludepath = os.path.join(destdir,excludefile)
    excl = open(excludepath,'w')
    if lastsync:
        for cycle in cycle_times.get(run,[]):
            if cycle_times[run][cycle] < lastsync:
                excl.write('C%d.1/\nD%d.1/\n' % (cycle,cycle))
    excl.close()
    return excludepath

def main():
    pid = 0
    last_start = datetime.utcfromtimestamp(0)
    last_run = ''
    if len(sys.argv) > 1:
        deck = sys.argv[1].upper()
    else:
        sys.exit('must provide deck on command line')
    (basedir,message) = get_basedir(deck)
    if not basedir:
        sys.exit(message)
    mirrpath = os.path.join(basedir,mirrdir)
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
                os.killpg(pid,signal.SIGSTOP)
                logmsg('stopped pid %d' % pid)
            elif start_ok:
                os.killpg(pid,signal.SIGCONT)
                logmsg('continued pid %d' % pid)
        else:
            # not running: no proc, or proc completed
            if pidcheck != False:
                (oldpid,exit_status) = pidcheck
                log_mtime = get_log_mtime(last_run)
                if exit_status == 0 and last_start > log_mtime:
                    logmsg('rsync completed and no log change since start')
                    set_run_status(last_run,'complete')
                    stamp = open(os.path.join(mirrpath,
                                              os.path.basename(rundir),
                                              stampfile),'w')
                    stamp.write('\n'.join(['Run completed at %s (local)',
                                           'rsync of %s started at %s UTC',
                                           'last logfile change at %s UTC',
                                           ''])
                                % (time.ctime(),
                                   rundir,last_start.ctime(),
                                   log_mtime.ctime()))
                    stamp.close()
            if start_ok:
                rundir = find_eligible_run(deck)
                if not rundir:
                    break
                excludepath = write_exclude_file(mirrpath,rundir)
                pid = pg_spawnvp('rsync',
                      ['rsync','-a','-v',
                       '--exclude-from=%s' % excludepath,
                       '%s::runs/%s' % ( deck, rundir ),
                       mirrpath])
                last_run = os.path.basename(rundir)
                last_start = datetime.utcnow()
                logmsg('started rsync of %s: pid %s at %s' %
                       (rundir,pid,last_start.ctime()))
                set_run_status(last_run,'syncing',last_sync=last_start)
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
