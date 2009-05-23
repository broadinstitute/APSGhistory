#!/bin/bash

# Location of the checkmount command.
CHECKMOUNT=/broad/tools/NoArch/pkgs/local/checkmount

if [[ "x$1" == "x" ]]; then
  echo "Must give at least one path to check."
fi

for path in $@; do
  $CHECKMOUNT $path
  ERRVAL=$?

  case $ERRVAL in
    0)
      # There is no NFS or other error preventing access to the path
      echo "$path is a valid, accessible path."
      ;;
    1) 
      # The attempt to access the path failed or timed out.
      # An error code of one means access failed or timed out but the path 
      # is not located on a mounted NFS share or in the autofs map. 
      # Potentially a disk error. Seek help@broad.mit.edu.
      echo "Access failed, path is not in autofs or mounted on NFS."
      ;;
    3)
      # An error code of three means access failed or timed out and the path
      # was found in the autofs map but is not currently mounted via NFS.
      # Potentially a hung or dead autofs process, seek help@broad.mit.edu 
      echo "Access failed, path is in autofs map but not currently mounted."
      ;;
    5)
      # An error code of five means access failed or timed out and the path
     # is currently mounted via NFS but not found in autofs. This probably
      # means the path is on a manually mounted NFS server which probably means
      # this is a non-standard volume which probably means all bets are off with 
      # some custom NFS server thingy. Failed access immplies that the NFS server
      # is either down or very busy, wait and try again later or seek 
      # help@broad.mit.edu.
      echo "Access failed, path is mounted via nfs but not in autofs map."
      ;;
    7)
      # An error code of seven means access failed or timed out and the path
      # is currently mounted via NFS and found in autofs. This probably means 
      # that autofs is working but the NFS server is either down or too busy
      # to respond within the timeout. Wait and try again later or seek 
      # help@broad.mit.edu
      echo "Access failed, path is mounted via nfs and is in autofs map."
      ;;
     8)
      # An error code of eight means that the checkmount script somehow got bad arguments.
      echo "Incorrect checkmount script arguments."
      ;;
     *) 
      # Was checkmount modified without updating sample code?
      echo "Unknown error value, contact help@broad.mit.edu."
      ;;
  esac
done
