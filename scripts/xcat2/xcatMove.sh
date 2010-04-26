#!/bin/bash

function info () 
{
	echo $(ssh $USER@$HOST grep $NODE $1 | cut -f$2 -d' ')
}


#Set Variables
USER="root"
HOST="pm"
NODE=$1

if [ $(tabgrep $1 2> /dev/null | wc -l) -gt 0 ]; then
	echo "$1 exists.  Exiting..."
	exit 0
fi

MAC=$(info /opt/xcat/etc/mac.tab 2)
IP=$(info /opt/xcat/etc/hosts 1)
MODEL=$(info /opt/xcat/etc/nodemodel.tab 2)

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
