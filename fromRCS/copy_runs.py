#!/util/bin/python

import cx_Oracle,glob,os,signal,socket,sys,time
import xml.sax.handler
import checkrun
from datetime import datetime,timedelta

# these must end with slash
mirrdir = 'mirror/'
logdir = 'logs/'

stampfile = 'SyncComplete'
excludefile = '.rsync_exclude'

# oracle connection string
oraconn = 'slxasync/c0piiRn2pr@seqprod'

# design notes:
# all datetime objects are to be handled as UTC, except possibly on output
# (avoids DST problems)

# logs older than this? assume we're in a gap
log_stale_age = timedelta(minutes=30)

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

# modified http://mail.python.org/pipermail/python-list/2002-May/144522.html
def pid_exists(pid):
    try:
        os.kill(pid, 0)
        return True
    except OSError, err:
        return err.errno == errno.EPERM

# signal handler to do nothing
def handler_noop(signum,frame):
    pass

signal.signal(signal.SIGALRM,handler_noop)
signal.signal(signal.SIGCHLD,handler_noop)

orcl = cx_Oracle.connect(oraconn)
curs = orcl.cursor()

class LogHandler(xml.sax.handler.ContentHandler):
    def __init__(self):
        self.in_gap = False
        self.start_ok = False
        self.must_stop = True
        self.deck_state = 'unknown'
        self.last_conv_path = ''
        self.next_check = 10 * 60
    
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
        else:
            self.start_ok = False
            self.must_stop = True
            self.next_check = 10*60
        if (name == 'INCOMPLETE') or (name == 'PARTIAL_SAFE_STATE'):
            # run stopped; override everything else
            self.in_gap = True
            self.start_ok = True
            self.must_stop = False
            self.deck_state = 'idle'
            # FIXME check file timestamp and use that as base
            self.next_check = 15*60

def logmsg(msg):
    print time.ctime(),msg
    sys.stdout.flush()

def run_status(logfile):
    parser = xml.sax.make_parser()

    handler = LogHandler()
    parser.setContentHandler(handler)

    if not logfile:
        sys.exit("no logfiles found")

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
        curs.execute("""UPDATE runs SET state = 'pending'
                        WHERE runs.run_name = :rname AND state = 'complete'""",
                     rname=run_name);

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
    if not newest['path'] or newest['time']+log_stale_age < datetime.utcnow():
        if newest['path']:
            logmsg('stale logfile %s, mtime %s' % (newest['path'],
                                                   newest['time'].ctime()))
        else:
            logmsg('no logfiles found')
        (can_start, must_stop,
         next_check_secs, deck_state) = (True, False, 600, 'idle')
    else:
        logmsg('parsing logfile %s, mtime %s' % (newest['path'],
                                                 newest['time'].ctime()))
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
        # ignore the deck
        return (None,'deck %s marked as offline' % deck)
    elif not t_host or not t_pid:
        # no valid lock
        return (basedir,None)
    elif t_host == myname and not pid_exists(t_pid):
        # lock was on this host, but process is dead
        return (basedir,None)
    else:
        return (None,'deck %s locked by %s:%s' % (deck,t_host,t_pid))

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

def update_cycle_count(rundir_path):
    run = os.path.basename(rundir_path)
    curs.execute("SELECT last_cycle_copied,last_d_cycle_copied FROM runs WHERE run_name = :rname",
                 rname=run)
    result = curs.fetchone()
    if result:
        cycles_done = result
    else:
        sys.exit("couldn't find run %s in database updating cycle count" % run)
    
    recipes = glob.glob(os.path.join(rundir_path,"Recipe*.xml"))
    if len(recipes) != 1:
        logmsg("no recipe or multiple recipes for run %s" % run)
        cycles_needed = (sys.maxint,sys.maxint)
    else:
        cycles_needed = checkrun.check_recipe(recipes[0])
    (C_cycles, D_cycles, run_is_complete) = \
                checkrun.check_cycles(rundir_path, cycles_done, cycles_needed)
    curs.execute("UPDATE runs SET last_cycle_copied = :lc, last_d_cycle_copied = :ld WHERE run_name = :rname",lc=C_cycles,ld=D_cycles,rname=run)
    if run_is_complete:
        curs.execute("UPDATE runs SET state = 'complete' WHERE run_name = :rname",rname=run)
    orcl.commit()
    return (C_cycles,D_cycles,run_is_complete)

def write_exclude_file(rundir_path):
    run = os.path.basename(rundir_path)
    if not os.path.exists(rundir_path):
        os.makedirs(rundir_path)
    (C_cycles, D_cycles, is_complete) = update_cycle_count(rundir_path)
    excludepath = os.path.join(rundir_path,excludefile)
    excl = open(excludepath,'w')
    for cycle in range(1,C_cycles+1):
        excl.write('C%d.1/\n' % cycle)
    for cycle in range(1,D_cycles+1):
        excl.write('D%d.1/\n' % cycle)
    excl.close()
    return excludepath

def start_rsync(deck,run_srcpath,mirrpath):
    run_name = os.path.basename(run_srcpath)
    excludepath = write_exclude_file(os.path.join(mirrpath, run_name))
    pid = pg_spawnvp('rsync',
                     ['rsync','-a','-v',
                      '--exclude-from=%s' % excludepath,
                      '%s::runs/%s' % ( deck, run_srcpath ),
                      mirrpath])
    last_start = datetime.utcnow()
    logmsg('started rsync of %s: pid %s at %s' %
           (rundir,pid,last_start.ctime()))
    set_run_status(last_run,'syncing',last_sync=last_start)
    return (pid,last_start)

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
        already_started = False
        (start_ok,stop_now,
         next_check,log_mtime) = check_deck(deck,basedir)
        pidcheck = check_pid(pid)
        logmsg('deck %s, start %s, stop %s, next %s, pid %s, chk %s' % 
               (deck, start_ok, stop_now,next_check,pid,pidcheck))
        if pidcheck == True:
            update_cycle_count(os.path.join(mirrpath,last_run))
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
                (C_cycles, D_cycles, is_complete) = \
                           update_cycle_count(os.path.join(mirrpath,last_run))
                if is_complete:
                    logtime = get_log_mtime(last_run)
                    if last_start < logtime:
                        curs.execute("""SELECT run_sourcepath FROM runs
                        WHERE run_name = :rname""",rname=last_run)
                        retval = curs.fetchone()
                        if retval:
                            run_srcpath = retval[0]
                        else:
                            logmsg("couldn't find run %s in database preparing final rsync - SHOULD NOT HAPPEN" % run)
                            break
                        (pid,last_start) = start_rsync(deck,run_srcpath,mirrpath)
                        already_started = True
                    else:
                        stamp = open(os.path.join(mirrpath, last_run, stampfile),
                                     'w')
                        stamp.write('\n'.join(['Run completed at %s (local)',
                                               'rsync of %s started at %s UTC',
                                               'last logfile change at %s UTC',
                                               ''])
                                    % (time.ctime(),
                                       last_run,last_start.ctime(),
                                       logtime.ctime()))
                        stamp.close()
                elif exit_status != 0:
                    # failed; set run back to pending and unsynced
                    logmsg("run %s failed with status %s" %
                           (last_run, str(exit_status)))
                    set_run_status(last_run,'pending',
                                   last_sync=datetime.utcfromtimestamp(0))
            if start_ok and not already_started:
                rundir = find_eligible_run(deck)
                if not rundir:
                    break
                last_run = os.path.basename(rundir)
                (pid,last_start) = start_rsync(deck,rundir,mirrpath)
            elif not already_started:
                pid = 0
        if next_check < 300:
            next_check = 300
        # signal handler for CHLD/ALRM can be a no-op but must not be sig_ign
        signal.alarm(next_check)
        signal.pause()
        # reset the alarm; if sigchld woke us, we don't want it to go off later
        signal.alarm(0)
    # reached by break
    # before we exit, clean up database
    curs.execute('''UPDATE decks SET state='idle', transfer_host = NULL,
    transfer_pid = NULL WHERE decks.deck_name = :dname''',
                 dname=deck)
    orcl.commit()

if __name__ == '__main__':
    main()
