#!/bin/bash

# This script verifies NFS mounts exist and are mounted correctly. 
# It does not guarantee that a path is valid, just that it's underlying
# NFS mount is valid and working.
#
# jbh - 2009-04-16
#


# Recursive function to find the NFS mountpoint 
function findNfsMount () {

  # check if arg is an nfs mountpoint
  MPINFO=`mount | grep $1 | grep "type nfs"`
  MPRESULT=$?
  if [ $MPRESULT == 0 ]; then 
    NFS=`echo $MPINFO | awk '{print $1}'`
    echo "$1 is mounted from $NFS"
    return 0
  fi

  # Drop down one level
  MP=`dirname $1`
  if [ "x$MP" == "x/" ]; then
    # If we are all the way to /, exit with error. 
    return 1
  else
    # Check next level down.
    findNfsMount ${MP}
    return $?
  fi
}


# Main Program

# Make sure we have an argument to check.
if [ "x$1" == "x" ]; then
  echo "usage: checkNFS /path/to/check"
  exit 255
fi
 
unset RESULT

# Verify that this ins not a hung NFS mount (or hung mount 
# of any kind, i guess. Use a 10 second timeout. That should 
# be plenty for an automount to take place if necessary and 
# return something. The something should be the number 1
# even if the path is non-existant.

read -t10 RESULT < <( ls -ld $1 2>&1 | wc -l )

# Collect the result of the read. 
# 0 means it was successful, 1 means it timed out.
READ=$?

if [ "x$READ" == "x1" ]; then
  echo "$1 appears to be inaccessible."
  exit 1
fi

# If the read didn't time out, we need to ask:
# "Is it *really* an NFS mounted path?"

if ! findNfsMount $1; then
  echo "$1 does not appear to be a path on an NFS mounted volume."
  exit 2
else
  echo "$1 appears to be a path on an NFS mounted volume."
  exit 0
fi


