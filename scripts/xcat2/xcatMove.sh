#!/bin/bash

. /broad/tools/scripts/useuse
reuse -q Subversion-1.6

#Set Variables
USER="root"
HOST="pm"
DIR=/root/subversion/xcat2/tables/

NODE_LIST=$(echo "$1" | tr ',' ' ')

for NODE in $NODE_LIST
do
	if [ $(tabgrep $NODE  2> /dev/null | wc -l) -gt 0 ]; then
		echo "$NODE exists.  Skipping..."
		continue
	fi

	MAC=$(ssh $USER@$HOST grep "$NODE-eth0" /opt/xcat/etc/mac.tab | cut -f2 -d' ')
	IP=$(ssh $USER@$HOST grep -w $NODE /opt/xcat/etc/hosts | cut -f1 -d' ')
	MODEL=$(ssh $USER@$HOST grep -w $NODE /opt/xcat/etc/nodemodel.tab | cut -f2 -d' ')


	case $MODEL in
		"DELL") 			GROUP="dell,farm,all";;
		"LS21" | "LS20" | "HS20")
			GROUP="ibm,farm,all"
			IBM_SLOT=$(ssh $USER@$HOST grep -w $NODE /opt/xcat/etc/mp.tab | cut -f2 -d,)
			IBM_CHASSIS=$(ssh $USER@$HOST grep -w $NODE /opt/xcat/etc/mp.tab | cut -f1 -d, | awk '{print $2}')
			;;
		"HP") 				GROUP="hp,farm,all";;
		*) 				GROUP="farm,all";;
	esac

	echo "#xCAT# $IP|$MAC|$NODE|$GROUP|$IBM_CHASSIS|$IBM_SLOT|"

done
