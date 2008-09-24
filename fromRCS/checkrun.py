#!/util/bin/python

import sys

sys.path.append('/broad/tools/lib/python2.4/site-packages/')

import cx_Oracle,glob,os,re
from datetime import datetime,timedelta

# oracle connection string
oraconn = 'slxasync/c0piiRn2pr@seqprod'

pathre = re.compile('<CONVERSION.*Path="([^"]+?)"')

def check_cycles(rundir,cycles_already_done,cycles_expected):
    run = os.path.basename(rundir)
    lastseen = {}
    scandirs = {'C':{}, 'D':{}}
    cycle_max = {}
    cycles_done = {}
    cycles_completed = {}
    cycles_needed = {}

    (cycles_done['C'],cycles_done['D']) = cycles_already_done
    (cycles_needed['C'],cycles_needed['D']) = cycles_expected

    cycles_completed['C'] = (0,False)
    cycles_completed['D'] = (0,False)

    logfiles = glob.glob(os.path.join(rundir,"RunLog*.xml"))
    # we depend on the filenames lexically sorting in chronological order
    logfiles.sort()

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
                if cycle > cycles_done[cycle_type]:
                    imagedir = os.path.join(rundir,*pathitems[:-1])
                    scandirs[cycle_type].setdefault((cycle,imagedir),
                                                    {})[fname] = 1
        lfp.close()
    # now that we have the list in memory, do an efficient listdir
    # across each of the directories and remove files that we find exist.
    # after that, if anything is left we are missing a file.
    for cycle_type in ['C','D']:
        if cycles_done[cycle_type] >= cycles_needed[cycle_type]:
            cycles_completed[cycle_type] = (cycles_done[cycle_type],True)
            break
        for scantuple in sorted(scandirs[cycle_type]):
            (cycle,scandir) = scantuple
            try:
                os.chdir(scandir)
            except OSError:
                # directory isn't there at all
                cycles_completed[cycle_type] = (cycle-1,False)
                break
            else:
                for fname in os.listdir(scandir):
                    scandirs[cycle_type][scantuple].pop(fname,None)
            if len(scandirs[cycle_type][scantuple]):
                # we're missing something in this directory!
                cycles_completed[cycle_type] = (cycle-1,False)
                break
            else:
                # nothing is missing
                cycles_completed[cycle_type] = (cycle, True)
        # now, if everything was there, more checks
        if cycles_completed[cycle_type][1]:
            # can't tell if cycle 1 is complete, so punt
            if cycles_completed[cycle_type][0] == 1:
                cycles_completed[cycle_type] = (0,False)
            elif not (lastseen[(cycle_type,cycle_max[cycle_type])] ==
                      lastseen[(cycle_type,1)]):
                # last cycle doesn't have the same last file as cycle 1
                # this means it's not complete
                cycles_completed[cycle_type] = (cycles_completed[cycle_type][0]-1, False)
            elif cycles_completed[cycle_type][0] < cycles_needed[cycle_type]:
                # last cycle is complete, but run is not complete
                cycles_completed[cycle_type] = (cycles_completed[cycle_type][0], False)
    return(cycles_completed['C'][0],cycles_completed['D'][0],
           cycles_completed['C'][1] and cycles_completed['D'][1])

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

    curs.execute("""SELECT deck_name,run_sourcepath,last_cycle_copied,last_d_cycle_copied
    FROM runs WHERE run_name = :rname""",
                 rname=run);
    result = curs.fetchone()
    if result:
        (deck,run_srcpath,C_cycles_done,D_cycles_done) = result
    else:
        sys.exit('run not found in database')

    curs.execute("SELECT transfer_basedir FROM decks WHERE deck_name = :dname",
                 dname=deck)
    result = curs.fetchone()
    if result:
        basedir = result[0]
    else:
        sys.exit('deck not found in database')

    run_dir = os.path.join(basedir,'mirror',run)

    logfiles = glob.glob(os.path.join(run_dir,"RunLog*.xml"))
    # we depend on the filenames lexically sorting in chronological order
    logfiles.sort()


    recipes = glob.glob(os.path.join(run_dir,"Recipe*.xml"))
    if len(recipes) != 1:
        sys.exit("no recipe file, or multiple recipe files")

    cycles_needed = check_recipe(recipes[0])
    print 'cycles needed',cycles_needed

    complete_cycle = check_cycles(run_dir,(C_cycles_done,D_cycles_done),cycles_needed)
    print 'regular check',complete_cycle

    #print 'check from 0',check_cycles(run_dir,(0,0),cycles_needed)
    # XXX FIXME check for stalled run/stalled copy
    # stalled run: 'syncing' or 'running' and no log change in N hours
    # stalled copy: log changed recently but last cycle not incrementing
    

if __name__ == '__main__':
    main()
