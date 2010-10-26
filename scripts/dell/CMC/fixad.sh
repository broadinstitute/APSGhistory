#!/bin/bash

while [ $# -ge 1 ]; do
	HOST=$1
	SVCTAG=$(ssh $USER@$HOST config -g cfgActiveDirectory -o cfgADCertValidationEnable 0 2> /dev/null)

	if [ -z $SVCTAG ]; then
		echo "SSH Failed. Check username." && exit 1
	fi

	echo -e "$HOST\t$SVCTAG"  
	shift
done
