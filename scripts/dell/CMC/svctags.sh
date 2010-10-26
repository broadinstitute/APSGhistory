#!/bin/bash

USER=service

while [ $# -ge 1 ]; do
	HOST=$1
	SVCTAG=$(ssh $USER@$HOST getsvctag -m chassis 2> /dev/null | awk '$1 ~ /Chassis/ {print $2}')

	if [ -z $SVCTAG ]; then
		echo "SSH Failed. Check username." && exit 1
	fi

	echo -e "$HOST\t$SVCTAG"  
	shift
done
