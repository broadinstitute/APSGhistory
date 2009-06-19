#!/bin/sh

# work on the given user or the current user

TARGET=${1:-$USER}

# For reasons unknown, strace will reliably unstick stuck Emacsen.

for pid in `pgrep -u $TARGET emacs`
do 
  echo stracing $pid for 1 second...
  strace -qp $pid >/dev/null 2>&1 &
  sleep 1 && kill $!
done
