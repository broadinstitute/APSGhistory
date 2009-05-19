#!/bin/bash

for run in $(<$1)
  do
    SOLID=`echo $run | cut -f1 -d"|"`
    RUN=`echo $run | cut -f2 -d"|"`

    cat rsync.template | \
        sed -s "s/%SOLID%/${SOLID}/" | \
        sed -s "s/%RUN%/${RUN}/" | \
        sed -s "s/%JOBNAME%/${SOLID}-${RUN}/" > \
        RSYNC-${SOLID}-${RUN}.job
  done
