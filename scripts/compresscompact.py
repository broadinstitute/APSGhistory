#!/util/bin/python

import os,re,sys,time

skipre = re.compile('^(s_\d+_(matrix.txt|phasing.xml)|params\d+.xml|matrix\d+.txt)$')

def skipfile(name):
    if name.endswith('qcm.xml'):
        return True
    if skipre.search(name):
        return True
    return False

def logmsg(msg):
    print time.ctime(),msg
    sys.stdout.flush()

def make_tarball(dirname):
    (parent,name) = os.path.split(dirname)
    os.chdir(parent)
    tarname = "%s.tar.gz" % name
    if os.path.exists(tarname):
        logmsg('%s already exists! oh no!' % os.path.join(parent,tarname))
        return False
    logmsg('starting tar of %s' % dirname)
    retval = os.spawnlp(os.P_WAIT,'tar','tar','czf', tarname, name)
    if retval:
        logmsg('tar process failed')
        return False
    return True

def cleanout_files(topdir):
    for root,dirs,files in os.walk(topdir):
        if root == topdir:
            if 'logs' in dirs:
                dirs.remove('logs')
            if 'Config' in dirs:
                dirs.remove('Config')
            continue
        for name in files:
            if not skipfile(name):
                try:
                    os.remove(os.path.join(root,name))
                except OSError:
                    logmsg("remove of %s failed" % os.path.join(root,name))
        
def main():
    if len(sys.argv) > 1:
        topdirs = sys.argv[1:]
    else:
        sys.exit('must provide at least one dir on command line')
    for topdir in topdirs:
        topdir = os.path.realpath(topdir)
        if not os.path.isdir(topdir):
            logmsg('%s is not a directory' % topdir)
            continue
        if make_tarball(topdir):
            cleanout_files(topdir)

if __name__ == '__main__':
    main()
