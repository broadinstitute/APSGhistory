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

class LogHandler(xml.sax.handler.ContentHandler):
    def __init__(self):
        self.in_gap = False
        self.start_ok = False
        self.must_stop = True
        self.last_conv_path = ''
        self.next_check = 15 * 60
    
    def startElement(self,name,attributes):
        if name == 'CONVERSION':
            self.last_conv_path = attributes.get('Path')
            if '\\D' in self.last_conv_path:
                self.in_gap = True
                self.start_ok = True
            else:
                self.in_gap = False
        if name == 'PUMP_TO_FLOWCELL':
            self.in_gap = True
            if '\\D' in self.last_conv_path:
                solution = int(attributes.get('Solution'))
                if solution in [1, 5]:
                    self.start_ok = False
                elif solution in [3, 4]:
                    self.in_gap = False
        if self.in_gap:
            self.next_check = 5 * 60
        elif name == 'INCOMPLETE':
            # run was stopped
            self.start_ok = True
            self.must_stop = False
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
    return (handler.start_ok, handler.must_stop, handler.next_check)

def check_deck(deck,basedir):
    logpath = os.path.join(basedir,deck,logdir)
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
                        # XXX add run to database
                        break
                xmllog.close()
                if foundconv:
                    mtime = os.path.getmtime(path)
                    if mtime > newest['time']:
                        newest['time'] = mtime
                        newest['path'] = path
    logmsg('parsing logfile %s, mtime %s' % (newest['path'],
                                             time.ctime(newest['time'])))
    (can_start,must_stop,next_check) = run_status(newest['path'])
    run_dir = os.path.dirname(newest['path'])
    if run_dir.startswith(logpath):
        run_dir = run_dir[len(logpath):]
    else:
        sys.exit('run_dir not in logpath: this should not happen')
    # XXX update deck state in database
    return (run_dir,can_start,must_stop,next_check,newest['time'])

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

def main():
    pid = 0
    last_start = 0
    last_rundir = ''
    if len(sys.argv) > 1:
        deck = sys.argv[1].upper()
    else:
        sys.exit('must provide deck on command line')
    # XXX check deck host/pid to see if we match
    myname = socket.getfqdn()
    mypid = os.getpid()
    # XXX if we don't, check state_check_last for stale info
    # XXX get basedir from database
    mirrpath = os.path.join(basedir,deck,mirrdir)
    if not os.path.exists(mirrpath):
        os.makedirs(mirrpath)
    while True:
        (rundir,start_ok,stop_now,
         next_check,log_mtime) = check_deck(deck, basedir)
        pidcheck = check_pid(pid)
        logmsg('run %s, start %s, stop %s, next %s, pid %s, chk %s' % 
               (rundir, start_ok, stop_now,next_check,pid,pidcheck))
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
                    # XXX update database
                    sys.exit(0)
            if start_ok:
                pid = os.spawnlp(os.P_NOWAIT,'rsync',
                                 'rsync','-a','-v',
                                 '%s::runs/%s' % ( deck, rundir ),
                                 mirrpath)
                last_start = time.time()
                last_rundir = rundir
                logmsg('started rsync of %s: pid %s at %s' %
                       (rundir,pid,last_start))
            else:
                pid = 0
        if next_check < 300:
            next_check = 300
        time.sleep(next_check)

if __name__ == '__main__':
    main()
