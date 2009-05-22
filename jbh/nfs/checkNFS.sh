#!/bin/bash

# This script verifies NFS mounts exist and are mounted correctly. 
# It does not guarantee that a path is valid, just that it's underlying
# NFS mount is valid and working.
#
# jbh - 2009-04-16
#

# verbose
# Echo argument if VERBOSE is defined.
function verbose () {
  if [ ! -z "$VERBOSE" ]; then
    echo $1 >&2
  fi
}

# Recursive function to find the NFS mountpoint 
function isNfsMount () {
  # check if arg is an nfs mountpoint
  MPINFO=`mount | grep $1 | grep "type nfs"`
  MPRESULT=$?
  if [ $MPRESULT == 0 ]; then 
    NFS=`echo $MPINFO | awk '{print $1}'`
    verbose "Mounted at $NFS"
    return 0
  fi

  # Drop down one level
  MP=`dirname $1`
  if [ "x$MP" == "x/" ]; then
    # If we are all the way to /, exit with error. 
    verbose "Hit bottom at $MP."
    return 1
  else
    # Check next level down.
    isNfsMount ${MP}
    return $?
  fi
}

function isAutofsMount () {
 # This function shoudl parse the ypcat output to verify this is a broad automount.
 return 1
}

function isAccessible () {
  # Verify that this is not a hung NFS mount (or hung mount 
  # of any kind, i guess. Use a 10 second timeout. That should 
  # be plenty for an automount to take place if necessary and 
  # return something. The something should be the number 1
  # even if the path is non-existant.i
  unset RESULT
  read -t10 RESULT < <( ls -ld $1 2>&1 | wc -l )

  # Collect the result of the read. 
  # 0 means it was successful, that is, it did not block and/or timeout.
  # 1 means it timed out.
  READ=$?

  return $READ
}


######################################################################
# Main Program

# Process arguments
while getopts "nv" OPTION; do
  case $OPTION in 
    n ) NOTIFY=true ;;
    v ) VERBOSE=true ;;
    * ) 
      echo "$0: Bad argument to script." 
      exit 1
      ;;
  esac
done
# Put rest of args in place to check all paths given.
shift $((OPTIND-1))

# Check for at least one path argument
if [ "x$1" == "x" ]; then
  echo "$0: No path given."
  exit 1
fi
 
RETURN=0
# Check the path
if isAutofsMount $1 ; then
  verbose "$1 appears to be a Broad AutoFS mounted Filesystem."
else
  verbose "$1 does not appear to be a Broad AutoFS mounted Filesystem."
fi

if isAccessible $1; then
  verbose "$1 is accessible."
else
  verbose "$1 is NOT accessible."
  RETURN=1
fi

if isNfsMount $1; then
  verbose "$1 is mounted via NFS."
else
  verbose "$1 is not a mounted NFS filesystem."
fi

exit $RETURN
