#!/usr/local/bin/python

import os

os.environ['ORACLE_HOME'] = '/oracle/apps/oracle/product/101'
os.environ['LD_LIBRARY_PATH'] = '/oracle/apps/oracle/product/101/lib'
os.environ['PATH'] = '/usr/local/bin:%s' % os.environ['PATH']

import cx_Oracle,errno,re,signal,socket,stat,sys,time
from datetime import datetime,timedelta
from subprocess import *

solexa_sw_dir = '/broad/tools/solexa/pipeline'

analysis_dest = '/slxa'
analysis_suffix = 'analyzed'

compat_symlink_dest = '/broad/solexaproc'
compat_symlink_suffix = 'analyzed'

flag_file = '.imageDir'

make_args = ['-j5']

cycle_regex = re.compile('/C1-(\d+)_Firecrest')

sequence_gid = 52
umask_val = 002

# oracle connection string
oraconn = 'slxasync/c0piiRn2pr@seqprod'

orcl = cx_Oracle.connect(oraconn)
curs = orcl.cursor()

# modified http://mail.python.org/pipermail/python-list/2002-May/144522.html
def pid_exists(pid):
    try:
        os.kill(pid, 0)
        return True
    except OSError, err:
        return err.errno == errno.EPERM

def get_deckinfo(deck):
    curs.execute("""SELECT transfer_basedir,state
    FROM decks
    WHERE deck_name = :dname""",dname=deck)
    result = curs.fetchone()
    if not result:
        sys.exit('FATAL: deck %s not found in database' % deck)
    else:
        return(result)

def get_runlist(deck):
    curs.execute("""SELECT run_name,state,analysis_dir
    FROM runs
    WHERE deck_name = :dname AND state != 'ignore' AND
    (analysis_dir IS NOT NULL OR state = 'syncing')""",dname=deck)
    runlist = curs.fetchall()
    if not len(runlist):
        sys.exit('no eligible runs found')
    else:
        return runlist

def get_runinfo(run):
    curs.execute("""SELECT analysis_dir,state,last_cycle_copied
    FROM runs
    WHERE run_name = :rname""",rname=run)
    result = curs.fetchone()
    if not result:
        sys.exit('FATAL: run %s not found in database' % run)
    else:
        return result

def lock_eligible_run(runlist):
    myname = socket.getfqdn()
    mypid = os.getpid()

    lock_avail = False
    for runinfo in runlist:
        (run,run_state,analysis_dir) = runinfo
        curs.execute("""SELECT analysis_host,analysis_pid
        FROM runs
        WHERE run_name = :rname""",rname=run)
        result = curs.fetchone()
        if not result:
            sys.exit('FATAL: run %s not found in database' % run)
        else:
            (a_host,a_pid) = result
        if not a_host or not a_pid:
            lock_avail = True
            break
        elif (a_host == myname) and not pid_exists(a_pid):
            lock_avail = True
            break
    if lock_avail:
        # grab the lock
        curs.execute("""UPDATE runs SET analysis_host = :myname,
        analysis_pid = :mypid WHERE runs.run_name = :rname""",
                     myname=myname,mypid=mypid,rname=run)
        orcl.commit()
        return(run)
    else:
        # nothing?
        sys.exit('all eligible runs already locked')

def unlock_run(run):
    curs.execute("""UPDATE runs SET analysis_host = NULL,
        analysis_pid = NULL WHERE runs.run_name = :rname""",
                 rname=run)
    orcl.commit()

def update_rundir(run,rundir):
    curs.execute("""UPDATE runs SET analysis_dir = :a_dir
    WHERE runs.run_name = :rname""",
                 rname=run,a_dir=rundir)
    orcl.commit()

def write_flagfile(dstdir,data):
    flagfile_path = os.path.join(dstdir,flag_file)
    fp = open(flagfile_path,"w")
    if data:
        fp.write(data)
        fp.write("\n")
    fp.close()

def setup_dirs(src,dst,symlinkfrom=None):
    src_flagfile = os.path.join(src,flag_file)
    if not os.path.exists(src_flagfile):
        write_flagfile(src,None)
    if not os.path.exists(dst):
        os.makedirs(dst)
    os.spawnlp(os.P_WAIT,'rsync','rsync','-av',
               '--exclude=/Data', '--exclude=/Images/',
               '--exclude=/Focus/', '--exclude=/Focus0/',
               '--exclude=/logs',
               src + '/', dst + '/')
    src_data = os.path.join(src,"Data")
    src_focus = os.path.join(src,"Focus")
    src_images = os.path.join(src,"Images")
    src_logs = os.path.join(src,"logs")
    dst_data = os.path.join(dst,"Data")
    dst_focus = os.path.join(dst,"Focus")
    dst_images = os.path.join(dst,"Images")
    dst_logs = os.path.join(dst,"logs")
    if not os.path.exists(dst_data):
        os.makedirs(dst_data)
    dst_data_stat = os.stat(dst_data)
    os.chmod(dst_data,dst_data_stat.st_mode | stat.S_ISGID)
    os.chown(dst_data,-1,sequence_gid)
    if not os.path.exists(src_data):
        os.symlink(dst_data,src_data)
    if not os.path.exists(dst_logs):
        os.makedirs(dst_logs)
    if not os.path.exists(src_logs):
        os.symlink(dst_logs,src_logs)
    if not os.path.exists(dst_focus) and os.path.exists(src_focus):
        os.symlink(src_focus,dst_focus)
    if not os.path.exists(dst_images):
        os.symlink(src_images,dst_images)
    if symlinkfrom and not os.path.exists(symlinkfrom):
        os.symlink(dst,symlinkfrom)

def find_newest(basedir):
    newest_dir = ''
    newest_time = 0
    for item in os.listdir(basedir):
        item_path = os.path.join(basedir,item)
        if os.path.isdir(item_path) and item.startswith("C1"):
            item_mtime = os.path.getmtime(item_path)
            if item_mtime > newest_time:
                newest_time = item_mtime
                newest_dir = item_path
    return newest_dir

def build_makefiles(basedir,cycle,old_dir):
    if old_dir:
        retval = os.spawnl(os.P_WAIT,
                  os.path.join(solexa_sw_dir,"Goat/goat_pipeline.py"),
                  'goat_pipeline.py',basedir,'--make',
                  '--cycles=1-'+str(cycle),'--directory='+old_dir)
    else:
        retval = os.spawnl(os.P_WAIT,
                  os.path.join(solexa_sw_dir,"Goat/goat_pipeline.py"),
                  'goat_pipeline.py',basedir,'--make',
                  '--cycles=1-'+str(cycle),'--nobasecall')
    if retval == 0:
        return True
    return False

def dtstring():
    return datetime.now().strftime("%Y%m%d%H%M%S")

def run_the_make(rundir,logdir):
    cycpart = os.path.basename(rundir).split('_')[0]
    logfile = os.path.join(logdir, "firecrestAnalysis%s.%s.out" %
                           (dtstring(), cycpart))
    logfp = open(logfile,"w")
    retval = call(['make'] + make_args,stdout=logfp,stderr=STDOUT,cwd=rundir)
    logfp.close()
    if retval == 0:
        return True
    return False

def main():
    prev_cycle = 0
    if len(sys.argv) > 1:
        deck = sys.argv[1].upper()
    else:
        sys.exit('must provide deck on command line')
    os.umask(umask_val)
    (xferbase, deckstate) = get_deckinfo(deck)
    run = lock_eligible_run(get_runlist(deck))
    (analysis_dir,run_state,last_copied) = get_runinfo(run)
    sync_dir = os.path.join(xferbase,"mirror",run)
    results_dir = os.path.join(analysis_dest,deck,analysis_suffix,run)
    compat_link = os.path.join(compat_symlink_dest,deck,compat_symlink_suffix,run)
    setup_dirs(sync_dir,results_dir,symlinkfrom=compat_link)
    datadir = os.path.join(results_dir,"Data")
    newest_dir = find_newest(datadir)
    print 'newest',newest_dir,'data',datadir
    print 'runinfo',analysis_dir,run_state,last_copied
    if newest_dir:
        # NB: we check analysis_dir for the last cycle DONE
        # even though the newest_dir may be for a newer cycle
        if analysis_dir:
            match = cycle_regex.search(analysis_dir)
            if match:
                prev_cycle = int(match.group(1))
    print 'prev',prev_cycle
    if prev_cycle < last_copied:
        # okay, we have a winner
        if build_makefiles(results_dir,last_copied,newest_dir):
            new_dir = find_newest(datadir)
            log_dir = os.path.join(results_dir,"logs")
            if run_the_make(new_dir,log_dir):
                if run_state == 'complete':
                    write_flagfile(sync_dir,
                                   new_dir[len(results_dir)-len(run):])
                    update_rundir(run,None)
                else:
                    update_rundir(run,new_dir)
    elif run_state == 'complete':
        # we don't need to run anything, but may need to clean up complete run
        new_dir = find_newest(datadir)
        write_flagfile(sync_dir, new_dir[len(results_dir)-len(run):])
        update_rundir(run,None)
    unlock_run(run)

if __name__ == '__main__':
    main()
