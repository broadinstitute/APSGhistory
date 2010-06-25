#!/bin/sh

set -e

DIR=/sysman/scratch/apsg/host-survey/hosts
HOSTNAME=$1

LOGDIR=$DIR/$HOSTNAME

mkdir -p $LOGDIR

ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'uname -io' >$LOGDIR/uname 2>$LOGDIR/ssh.log

grep -qi linux $LOGDIR/uname

ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'netstat -nlp'  >$LOGDIR/netstat 2>>$LOGDIR/ssh.log
ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'ps -H waxj'     >$LOGDIR/ps 2>>$LOGDIR/ssh.log
ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'last -F'       >$LOGDIR/last 2>>$LOGDIR/ssh.log
ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'find /etc -mount -type f -print0 | xargs -0 egrep -i "18.103|broad.mit.edu"' >$LOGDIR/etc 2>>$LOGDIR/ssh.log
ssh -n -o "PasswordAuthentication no" -o "ConnectTimeout 10" root@$HOSTNAME 'md5sum /etc/sudoers' >$LOGDIR/sudoers 2>>$LOGDIR/ssh.log

echo $HOSTNAME complete
