#!/bin/bash

#Set Variables
USER="root"
HOST="pm"

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

	if [ $GROUP = "ibm,farm,all" ]; then
		svnbuild nodeadd $NODE groups=$GROUP mac.interface=eth0 hosts.ip=$IP mac.mac=$MAC mp.mpa=$IBM_CHASSIS mp.id=$IBM_SLOT
	else
		svnbuild nodeadd $NODE groups=$GROUP mac.interface=eth0 hosts.ip=$IP mac.mac=$MAC
	fi

	sleep 30

	makehosts $NODE
	makedhcp $NODE

	ssh $USER@$HOST makedhcp -d $NODE
	ssh $USER@$HOST service dhcpd stop
done
