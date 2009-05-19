#!/bin/bash

for SOLID in Solid0038 Solid0048 Solid0060 Solid0152 Solid0154 Solid0160 Solid0161 Solid0163
  do

    cat find.template | \
        sed -s "s/%SOLID%/${SOLID}/" | \
        sed -s "s/%JOBNAME%/${SOLID}-find/" > \
        FIND-${SOLID}.job
  done
