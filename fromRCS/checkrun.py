#!/util/bin/python

import sys

sys.path.append('/broad/tools/lib/python2.4/site-packages/')

import cx_Oracle,glob,os,re
from datetime import datetime,timedelta

# oracle connection string
oraconn = 'slxasync/c0piiRn2pr@seqprod'

pathre = re.compile('<CONVERSION.*Path="([^"]+?)"')

def check_cycles(basedir,run,logfiles,cycles_done,cycles_expected):
    lastseen = {}
    scandirs = {}
    cycle_max = {}
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
                cycle_type = cycle_dir[0]
                if cycle_type in 'CD' and cycle_dir[1] in "0123456789":
                    cycle = int(float(cycle_dir[1:]))
                    cycle_max[cycle_type] = cycle
                    lastseen[(cycle_type,cycle)] = fname
                else:
                    sys.exit("could not find cycle in path %s" % path)
                if cycle > cycles_done:
                    imagedir = os.path.join(basedir,'mirror',
                                            run,*pathitems[:-1])
                    scandirs.setdefault((cycle,imagedir),{})[fname] = 1
        lfp.close()
    # now that we have the list in memory, do an efficient listdir
    # across each of the directories and remove files that we find exist.
    # after that, if anything is left we are missing a file.
    for scantuple in sorted(scandirs):
        print scantuple
        (cycle,scandir) = scantuple
        try:
            os.chdir(scandir)
        except OSError:
            print 'could not chdir to %s' % scandir
            return (cycle-1,False)
        else:
            for fname in os.listdir(scandir):
                scandirs[scantuple].pop(fname,None)
            if len(scandirs[scantuple]):
                # we're missing something in this directory!
                return (cycle-1,False)
    # if all files exist, check if last cycle is actually complete
    # we do this by saving the last file of each cycle,
    # then checking if last cycle's last file matches the pattern
    # and that it's not the only cycle
    if cycle == 1:
        return (0,False)
    if (lastseen[('C',cycle_max['C'])] == lastseen[('C',1)]
        and lastseen[('D',cycle_max['D'])] == lastseen[('D',1)]):
        if (cycle_max['C'],cycle_max['D']) == cycles_expected:
            # we're finished
            # return C assuming C >= D
            return(cycle_max['C'],True)
        else:
            # return D assuming D <= C
            return(cycle_max['D'],False)

def check_recipe(recipe_file):
    seen_protocol = False
    C_cycles = 0
    D_cycles = 0
    fp = open(recipe_file)
    for line in fp:
        if '<Protocol>' in line:
            seen_protocol = True
            continue
        elif not seen_protocol:
            continue
        if '<Incorporation ' in line:
            C_cycles = C_cycles + 1
        elif '<Cleavage ' in line:
            D_cycles = D_cycles + 1
    fp.close()
    return (C_cycles,D_cycles)

def main():
    # get run name
    if len(sys.argv) > 1:
        run = sys.argv[1]
    else:
        sys.exit('must provide run on command line')
    # get deck name, basedir: then logdir, mirrpath
    orcl = cx_Oracle.connect(oraconn)
    curs = orcl.cursor()

    curs.execute("""SELECT deck_name,run_sourcepath,last_cycle_copied FROM runs
    WHERE run_name = :rname""",
                 rname=run);
    result = curs.fetchone()
    if result:
        (deck,run_srcpath,cycles_done) = result
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

    recipes = glob.glob(os.path.join(runlogs_dir,"Recipe*.xml"))
    if len(recipes) != 1:
        sys.exit("no recipe file, or multiple recipe files")

    cycles_needed = check_recipe(recipes[0])

    complete_cycle = check_cycles(basedir,run,logfiles,
                                  cycles_done,cycles_needed)
    print complete_cycle
    # XXX FIXME check for stalled run/stalled copy
    # stalled run: 'syncing' or 'running' and no log change in N hours
    # stalled copy: log changed recently but last cycle not incrementing
    

if __name__ == '__main__':
    main()
