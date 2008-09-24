#!/util/bin/python

import sys,os,time,signal
import xml.sax.handler

basedir = '/zpool1'
stampfile = 'SyncComplete'

class LogHandler(xml.sax.handler.ContentHandler):
    # empirically determined gap size, 75 minutes
    # log uses 1/1000s time units
    gapsize = 75 * 60 * 1000
    # empirically determined rsync startup time, 20 minutes
    # plus we want at least 5 minutes of copying
    startcost = 25 * 60 * 1000

    def __init__(self):
        self.in_gap = False
        self.last_conv = 0
        self.last_seen = 0
        self.next_check = 15 * 60
        self.start_ok = False
        self.must_stop = True
    
    def startElement(self,name,attributes):
        if (name == 'READ_FLOWCELL_TMPR' or
            name == 'READ_AMBIENT_TMPR' or
            name == 'READ_STORAGE_TMPR'):
            return
        else:
            self.last_seen = int(attributes.get('start') or 0) \
                             or self.last_seen
        if name == 'CONVERSION':
            if '\\D' in attributes.get('Path'):
                self.in_gap = True
            else:
                self.last_conv = int(attributes.get('start') or 0) \
                                 or self.last_conv
                self.in_gap = False
        if name == 'PUMP_TO_FLOWCELL':
            self.in_gap = True
        if self.in_gap:
            # time remaining in gap
            timeleft = self.gapsize - (self.last_seen - self.last_conv)
            if timeleft > self.startcost or self.last_conv == 0:
                self.start_ok = True
                self.must_stop = False
                self.next_check = min(int(timeleft / 1000) + 5*60,15*60)
            else:
                self.start_ok = False
                self.must_stop = False
                self.next_check = min(int((self.startcost-timeleft)/1000) + 60, 5*60)
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

def check_host(host):
    logdir = os.path.join(basedir,host,'logs/')
    if not os.path.exists(logdir):
        os.makedirs(logdir)
    if os.spawnlp(os.P_WAIT,'rsync',
                  'rsync','-av',
                  '--exclude=Focus*/','--exclude=Images*/',
                  '--exclude=Data*/','--exclude=data/',
                  '%s::runs/' % host, logdir) != 0:
        sys.exit('rsync of logs failed')
    newest = {'time': 0, 'path': ''}
    for (dirname,dirs,files) in os.walk(logdir):
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
                    mtime = os.path.getmtime(path)
                    if mtime > newest['time']:
                        newest['time'] = mtime
                        newest['path'] = path
    logmsg('parsing logfile %s, mtime %s' % (newest['path'],
                                             time.ctime(newest['time'])))
    (can_start,must_stop,next_check) = run_status(newest['path'])
    run_dir = os.path.dirname(newest['path'])
    if run_dir.startswith(logdir):
        run_dir = run_dir[len(logdir):]
    else:
        sys.exit('run_dir not in logdir: should not happen')
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
        host = sys.argv[1].upper()
    else:
        sys.exit('must provide host on command line')
    mirrdir = os.path.join(basedir,host,'mirror/')
    if not os.path.exists(mirrdir):
        os.makedirs(mirrdir)
    while True:
        (rundir,start_ok,stop_now,next_check,log_mtime) = check_host(host)
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
                    # XXX drop a timestamp file in the dir
                    stamp = open(os.path.join(mirrdir,
                                              os.path.basename(last_rundir),
                                              stampfile),'w')
                    stamp.write('''Run completed at %s
                    rsync of %s started at %s
                    last logfile change at %s
                    ''' % (time.ctime(),
                           last_rundir,time.ctime(last_start),
                           time.ctime(log_mtime)))
                    stamp.close()
                    sys.exit(0)
            if start_ok:
                pid = os.spawnlp(os.P_NOWAIT,'rsync',
                                 'rsync','-a','-v',
                                 '%s::runs/%s' % ( host, rundir ),
                                 mirrdir)
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
