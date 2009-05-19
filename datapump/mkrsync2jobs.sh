#!/bin/bash

for list in /data/results_new/input/split/*
  do
    RUN=`basename $list`
    echo "RUN: $RUN"
    cat /data/results_new/scripts/rsync2.template | \
        sed -s "s/%RUN%/${RUN}/" | \
        sed -s "s/%FILES%/\/data\/results_new\/input\/split\/${RUN}/" > \
        /data/results_new/scripts/jobs/RSYNC2-${RUN}.job
  done
