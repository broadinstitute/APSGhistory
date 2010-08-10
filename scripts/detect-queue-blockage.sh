#!/usr/bin/env bash

# make dotkit stfu
alias ish=true
alias isub=true

. /broad/tools/scripts/useuse
reuse -q LSF

# usage:
#
#   detect-queue-blockage.sh care
#   detect-queue-blockage.sh care "carehosts someotherhosts"
#
# This will tell you if the specified queue is being starved by jobs
# from other queues running on its hosts.

queue=$1
hosts=${2:-${1}hosts}

foreign_job_count=$(bjobs -r -m "$hosts" -u all | tail -n +2 | awk '{ print $4 }' | grep -v $queue | wc -l)
waiting_job_count=$(bqueues care | tail -n +2 | awk '{ print $9 }')

if [[ $waiting_job_count -ge 1 && $foreign_job_count -ge 1 ]]
then
    echo
    echo "$waiting_job_count job(s) waiting in $queue queue"
    echo "$foreign_job_count job(s) running on $hosts from other queues"
    echo
    echo "Please bstop, memhog, wait, and bresume the following jobs:"
    echo
    bjobs -m "$hosts" -w -u all -r | tail -n +2 | perl -lane 'print unless $F[3] eq "'$queue'"'
fi
