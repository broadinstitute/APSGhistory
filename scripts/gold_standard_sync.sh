#!/bin/bash

export PATH=/opt/csw/bin:/usr/bin

LFTP_PID=`pgrep -u apsg -x lftp`

if [[ x$LFTP_PID == x ]]
then
    cd /broad/gold_standard/1000genomes/ftp &&
      lftp -c 'open ftp-trace.ncbi.nih.gov ; mirror -c --no-perms --loop --use-pget=10 --parallel=10 --log=/broad/gold_standard/.sync-log/'`date +"%Y-%m-%d-%H-%M-%S.log"`' 1000genomes/ftp/data'
else
    echo apsg lftp process $LFTP_PID still running >&2
    ps -lfp $LFTP_PID >&2
fi
