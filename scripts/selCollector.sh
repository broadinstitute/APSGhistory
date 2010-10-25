#!/bin/bash

USER=service
GREP_EXCEPTIONS="log cleared"

START=$1
END=$(($START+9))
MAX_BRSA=88
x=0 # Correct value gets set in for loop

while [ $x -le $MAX_BRSA ]; do
	for x in $(seq $START $END); do
		CMC="brsa$x"
		HOSTS=$(ssh $USER@$CMC getslotname)
		for i in {1..16}; do
			HOST=$(echo "$HOSTS" | grep -w $i | awk '{print $NF}')
			MESSAGE=$(ssh $USER@$CMC getsel -m server-$i | grep -v "$GREP_EXCEPTIONS")
			if [ -n "$MESSAGE" ]; then
				echo -e "$HOST\n$MESSAGE"
			fi
		done
	done
done
