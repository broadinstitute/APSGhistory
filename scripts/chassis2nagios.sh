#!/bin/bash

#
# $Id$
#

# Uncomment the next line for testing
#set -x

#########################################################
#
# prints out needed lines for nagios
#
#########################################################

# Here we define Usage -- define once, print many
USAGE="Usage: $(basename $0) start_range how_many parent_switch"

# Here we define how many arguments we should accept
ARG_NO=3

# error codes as defined in /usr/include/sysexits.h
E_OK=0       # successful termination
E_USAGE=64      # command line usage error 

if [ $# -ne "$ARG_NO" ]; then
	echo 1>&2 $USAGE
	exit $E_USAGE
fi

START_RANGE=$1
HOW_MANY=$2
PARENT_SWITCH=$3
USE="generic-chassis"


for num in $(seq $START_RANGE $(($START_RANGE+$HOW_MANY))); do
 	echo "
define host{
        use                     $USE
        host_name               brsa$num
        address                 brsa$num.broadinstitute.org
        alias                   $(host brsa$num| awk '/address/ {print $NF}')
        parents                 $PARENT_SWITCH
        } "
done



exit $E_OK
