#!/bin/bash
# $Id$

VENDORS="dell ibm"
LOGPATH="/tmp/events/"

for VENDOR in $VENDORS; do
	for HOST in $(nodels $VENDOR); do 
		/opt/xcat/bin/reventlog $HOST > $LOGPATH/$VENDOR/$HOST.log 2>&1
		cat $LOGPATH/$VENDOR/$HOST.log | /bin/logger -t SEL -p local1.error
		sleep 2
	done
done
