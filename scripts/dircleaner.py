#!/usr/bin/env python

import os,stat,time
from optparse import OptionParser
import errno

# allow an hour for files even with no procs running
# to avoid race conditions or the like
window = 60 * 60
exptime = int(time.time() - window)

def handle_item(dir,file):
    path = os.path.join(dir,file)
    statbuf = os.lstat(path)
    mode = statbuf[stat.ST_MODE]
    if hasproc.has_key(statbuf[stat.ST_UID]):
        return
    if (stat.S_ISDIR(mode) or stat.S_ISLNK(mode)):
        timestamp = statbuf[stat.ST_MTIME]
    elif stat.S_ISREG(mode):
        timestamp = max(statbuf[stat.ST_ATIME],statbuf[stat.ST_MTIME],
                        statbuf[stat.ST_CTIME])
    else:
        # sockets, devices, whatever: ignore them
        return
    if timestamp < exptime:
        if stat.S_ISDIR(mode):
            dirlist.append(path)
        else:
            filelist.append(path)

def main():
    global options
    global hasproc,filelist,dirlist

    hasproc = {}
    filelist = []
    dirlist = []

    usage = 'usage: %prog [options] directory ...'
    parser = OptionParser(usage)
    parser.add_option('-f', '--force', action='store_true', dest='force',
                      help='force removal in non scratch/tmp directories')
    parser.add_option('-n', '--dry-run', action='store_true', dest='dry_run',
                      help='do not remove files or directories. implies -v')
    parser.add_option('-v', '--verbose', action='store_true', dest='verbose',
                      help='show files and directories being removed')
    (options,args) = parser.parse_args()
    if len(args) == 0:
        parser.error('No directories given!')

    proclist = os.popen('ps --no-headers -eo uid')
    for line in proclist:
        hasproc[int(line)] = True
    proclist.close()

    if options.dry_run:
        options.verbose = True
    for tree in args:
        if options.force or '/tmp' in tree or '/scratch' in tree:
            if options.verbose:
                print 'processing',tree
            for (dirname, dirshere, fileshere) in os.walk(tree, topdown=False):
                for file in fileshere:
                    handle_item(dirname,file)
                for dir in dirshere:
                    handle_item(dirname,dir)
        else:
            print 'skipping %s, use -f to force' % tree
        for path in filelist:
            status = ''
            if not options.dry_run:
                try:
                    os.remove(path)
                except OSError, e:
                    if errno.errorcode[e.errno] != 'ENOENT':
                        status = 'failed '
            if options.verbose:
                print status + 'rm:',path
        for path in dirlist:
            status = ''
            if not options.dry_run:
                try:
                    os.rmdir(path)
                except OSError, e:
                    if errno.errorcode[e.errno] != 'ENOENT':
                        status = 'failed '
            if options.verbose:
                print status + 'rmdir:',path

if __name__ == '__main__':
    main()
