#!/bin/bash

FS=`perl -e 'print join "--", map { s./.-.g; $_ } @ARGV' "$@"`

GROUP=${LSB_JOBGROUP:-/apsg/cleanup/$FS}

OUT=${LSB_OUTPUTFILE:-$FS.`date --iso`.log}

bgadd $GROUP >/dev/null 2>&1
bgmod -L 50 $GROUP >/dev/null 2>&1

AGE=14

RES='rusage['`/broad/tools/scripts/io_resource_for_file "$@" | sort | uniq | perl -0777ne 'print join ",", map { "$_=1" } split'`']'

BSUB="bsub -g $GROUP -o /sysman/scratch/apsg/cleanup/$OUT -R $RES"

TEST="( -mtime +$AGE -ctime +$AGE -atime +$AGE )"

RECURSE="-execdir $BSUB $0 {} +"

BIGDIR='( -type d ( -size +10k -o -links +50 ) )'

exec find "$@" -nowarn -mindepth 1 \( $BIGDIR $RECURSE -prune \) -o \( $TEST -fprintf >(xargs -I{} $BSUB find {} $TEST -delete) \"%p\n\" \)
