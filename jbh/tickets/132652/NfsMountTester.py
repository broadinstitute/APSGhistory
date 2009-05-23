#!/usr/bin/env python
import os, subprocess, sys

# checkmount
def checkmount (path):
    # This really should do a more intelligent job of finding the checkmount script.    
    command = "/broad/tools/NoArch/pkgs/local/checkmount"
    
    # Execute the checkmount command.
    errval = subprocess.call([command, path]);

    # Return the result
    return errval

def main ():
    if len(sys.argv) == 1:
        print "Must give at least one path to check."
    else:
        for path in sys.argv[1:]:
            errvalue = checkmount(path);
            if errvalue == 0:
                # There is no NFS or other error preventing access to the path
                print path + " is a valid, accessible path."
            elif errvalue == 1:
                # The attempt to access the path failed or timed out.
                # An error code of one means access failed or timed out but the path 
                # is not located on a mounted NFS share or in the autofs map. 
                # Potentially a disk error. Seek help@broad.mit.edu.
                print "Access failed, path is not in autofs or mounted on NFS."
            elif errvalue == 3:
                # An error code of three means access failed or timed out and the path
                # was found in the autofs map but is not currently mounted via NFS.
                # Potentially a hung or dead autofs process, seek help@broad.mit.edu 
                print "Access failed, path is in autofs map but not currently mounted."
            elif errvalue == 5:
                # An error code of five means access failed or timed out and the path
                # is currently mounted via NFS but not found in autofs. This probably
                # means the path is on a manually mounted NFS server which probably means
                # this is a non-standard volume which probably means all bets are off with 
                # some custom NFS server thingy. Failed access immplies that the NFS server
                # is either down or very busy, wait and try again later or seek 
                # help@broad.mit.edu.
                print "Access failed, path is mounted via nfs but not in autofs map."
            elif errvalue == 7:
                # An error code of seven means access failed or timed out and the path
                # is currently mounted via NFS and found in autofs. This probably means 
                # that autofs is working but the NFS server is either down or too busy
                # to respond within the timeout. Wait and try again later or seek 
                # help@broad.mit.edu
                print "Access failed, path is mounted via nfs and is in autofs map."
            elif errvalue == 8: 
                # An error code of eight means that the checkmount script somehow got bad arguments.
                print "Incorrect checkmount script arguments."
            else: 
              # Was checkmount modified without updating sample code?
              print "Unknown error value, contact help@broad.mit.edu."

if __name__ == '__main__':
    sys.exit(main())

 
