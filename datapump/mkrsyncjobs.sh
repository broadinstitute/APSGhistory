#!/bin/bash



for run in $(<$1)
  do
    INSTRUMENT=`echo $run | cut -f1 -d"|"`
    RUN=`echo $run | cut -f2 -d"|"`
    SRCROOT=`echo $run | cut -f3 -d"|"`
    DSTROOT=`echo $run | cut -f4 -d"|"`
    
    cat rsync.template | \
        sed -s "s/%INSTRUMENT%/${INSTRUMENT}/" | \
        sed -s "s/%RUN%/${RUN}/" | \
        sed -s "s/%JOBNAME%/${INSTRUMENT}-${RUN}/" |
        sed -s "s/%SRCROOT%/${SRCROOT}/" | 
        sed -s "s/%DSTROOT%/${DSTROOT}/" > \
        RSYNC-${INSTRUMENT}-${RUN}.job
  done
