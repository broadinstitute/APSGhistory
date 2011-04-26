#!/bin/bash

FS=`perl -e 'print join "--", map { s./.-.g; s.^-..; $_ } @ARGV' "$@"`

GROUP=${LSB_JOBGROUP:-/apsg/cleanup/$FS}

JID=${LSB_JOBID:-root}

# output file for child jobs
OUT=${LSB_OUTPUTFILE:-$(mkdir -p /sysman/scratch/apsg/cleanup/log/$FS ; echo /sysman/scratch/apsg/cleanup/log/$FS/`date +%s`)}.$JID

bgadd $GROUP >/dev/null 2>&1
bgmod -L 100 $GROUP >/dev/null 2>&1

AGE=14

RES='rusage['`/broad/tools/scripts/io_resource_for_file "$@" | sort | uniq | perl -0777ne 'print join ",", map { "$_=1" } split'`']'

BSUB="bsub -q hour -W 3:30 -u adb -g $GROUP -o $OUT -R $RES"

TEST="( -mtime +$AGE -ctime +$AGE -atime +$AGE )"

RECURSE="-execdir $BSUB $0 {} +"

BIGDIR='( -type d ( -size +10k -o -links +50 ) )'

# The "-wholename" bit is so we don't parallelize below a certain
# depth.

exec find "$@" -nowarn -mindepth 1 \( $BIGDIR $RECURSE -prune \) -o \( \( $TEST -o \( -wholename './*/*' -type d \) \) \( -type d -fprintf >(xargs -0 -I{} $BSUB find {} $TEST -ls -delete) '%p\0' -o -type f -execdir rm {} + \) -prune \)
