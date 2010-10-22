#!/bin/bash

USER=service
GREP_EXCEPTIONS="log cleared"

for CMC in brsa{50..88}; do
	for i in {1..16}; do
		HOST=$(ssh $USER@$CMC getslotname -i $i)
		MESSAGE=$(ssh $USER@$CMC getsel -m server-$i | grep -v "$GREP_EXCEPTIONS")
		if [ -n "$MESSAGE" ]; then
			echo -e "$HOST\n$MESSAGE"
		fi
	done
done
