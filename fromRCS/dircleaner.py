#!/util/bin/python

import os,stat,time

# allow an hour for files even with no procs running
# to avoid race conditions or the like
window = 60 * 60
exptime = int(time.time() - window)

proclist = os.popen('ps --no-headers -eo uid')

hasproc = {}

for line in proclist:
    hasproc[int(line)] = True

proclist.close()

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
            # try: os.rmdir, except OSError: return
            print 'rmdir:',path
        else:
            print 'rm:',path

for (dirname, dirshere, fileshere) in os.walk('/tmp', topdown=False):
    for file in fileshere:
        handle_item(dirname,file)
    for dir in dirshere:
        handle_item(dirname,dir)
