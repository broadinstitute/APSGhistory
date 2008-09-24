#!/util/bin/python

import sys

sys.path.append('/broad/tools/lib/python2.4/site-packages/')

import cx_Oracle,glob,os,re
#from datetime import datetime

# oracle connection string
oraconn = 'slxasync/c0piiRn2pr@seqprod'

pathre = re.compile('<CONVERSION.*Path="([^"]+?)"')

def check_cycles(basedir,run,logfiles):
    lastseen = {}
    scandirs = {}
    missing = False
    missingcycle = sys.maxint
    cycle = 1
    # read the list of files to look for into memory
    # (why not check for os.path.exists as we go?
    #  two reasons:
    #   1. efficiency (avoid vnode lookups for dirs, etc)
    #   2. helps us avoid getting clobbered by the rsync updating the logs)
    for logfile in logfiles:
        lfp=open(logfile)
        for line in lfp:
            match = pathre.search(line)
            if match:
                path = match.group(1)
                # convert filename to unix path relative to rundir
                pathitems = path.split('\\')
                pathitems = pathitems[pathitems.index(run)+1:]
                fname = pathitems[-1]
                cycle_dir = pathitems[-2]
                if cycle_dir[0] in 'CD' and cycle_dir[1] in "0123456789":
                    cycle = int(float(cycle_dir[1:]))
                    lastseen[cycle] = fname
                imagedir = os.path.join(basedir,'mirror',run,*pathitems[:-1])
                scandirs.setdefault(imagedir,{})[fname] = 1
        lfp.close()
    # now that we have the list in memory, do an efficient listdir
    # across each of the directories and remove files that we find exist.
    # after that, if anything is left we are missing a file.
    # XXX FIXME check for OSError on the chdir... if that fails, add
    # the appropriate cycle number to the "missing" list and move on
    for scandir in scandirs:
        cycle_dir = os.path.basename(scandir)
        if cycle_dir[0] in 'CD' and cycle_dir[1] in "0123456789":
            cycle = int(float(cycle_dir[1:]))
        else:
            # this should not happen
            sys.exit("tried scanning dir %s which is not a cycle dir"
                     % scandir)
        try:
            os.chdir(scandir)
        except OSError:
            print 'could not chdir to %s' % scandir
            missing = True
            if cycle < missingcycle:
                missingcycle = cycle
        else:
            for fname in os.listdir(scandir):
                scandirs[scandir].pop(fname,None)
            if len(scandirs[scandir]):
                # we're missing something in this directory!
                missing = True
                # we only care about the cycle number, not the actual filename
                if cycle < missingcycle:
                    missingcycle = cycle
    if missing:
        return missingcycle - 1
    # if all files exist, check if last cycle is actually complete
    # we do this by saving the last file of each cycle,
    # then checking if last cycle's last file matches the pattern
    # and that it's not the only cycle
    if cycle > 1 and lastseen[cycle] == lastseen[1]:
        return cycle
    else:
        return cycle-1

def main():
    # get run name
    if len(sys.argv) > 1:
        run = sys.argv[1]
    else:
        sys.exit('must provide run on command line')
    # get deck name, basedir: then logdir, mirrpath
    orcl = cx_Oracle.connect(oraconn)
    curs = orcl.cursor()

    curs.execute("""SELECT deck_name,run_sourcepath FROM runs
    WHERE run_name = :rname""",
                 rname=run);
    result = curs.fetchone()
    if result:
        (deck,run_srcpath) = result
    else:
        sys.exit('run not found in database')

    curs.execute("SELECT transfer_basedir FROM decks WHERE deck_name = :dname",
                 dname=deck)
    result = curs.fetchone()
    if result:
        basedir = result[0]
    else:
        sys.exit('deck not found in database')

    runlogs_dir = os.path.join(basedir,'logs',run_srcpath)
    print 'runlogsdir',runlogs_dir

    logfiles = glob.glob(os.path.join(runlogs_dir,"RunLog*.xml"))
    # we depend on the filenames lexically sorting in chronological order
    logfiles.sort()

    complete_cycle = check_cycles(basedir,run,logfiles)
    print complete_cycle

if __name__ == '__main__':
    main()
