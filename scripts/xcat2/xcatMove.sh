#!/bin/bash

#Set Variables
USER="root"
HOST="pm"
NODE=$1

if [ $(tabgrep $1 2> /dev/null | wc -l) -gt 0 ]; then
	echo "$1 exists.  Exiting..."
	exit 0
fi

MAC=$(ssh $USER@$HOST grep "$NODE-eth0" /opt/xcat/etc/mac.tab | cut -f2 -d' ')
IP=$(ssh $USER@$HOST grep $NODE /opt/xcat/etc/hosts | cut -f1 -d' ')
MODEL=$(ssh $USER@$HOST grep $NODE /opt/xcat/etc/nodemodel.tab | cut -f2 -d' ')

case $MODEL in
	"DELL") 			GROUP="dell,farm,all";;
	"LS21" | "LS20" | "HS20") 	GROUP="ibm,farm,all";;
	"HP") 				GROUP="hp,farm,all";;
	*) 				GROUP="farm,all";;
esac

svnbuild nodeadd $NODE groups=$GROUP mac.interface=eth0 hosts.ip=$IP mac.mac=$MAC
sleep 30

makehosts $NODE
makedhcp $NODE

ssh $USER@$HOST makedhcp -d $NODE
