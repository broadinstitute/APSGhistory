#!/bin/bash

/opt/xcat/sbin/makedhcp -n
service dhcpd restart

for NODE in $(nodels); do
	makedhcp -d $NODE
	makehosts -d $NODE
	makehosts $NODE
	makedhcp $NODE
done

service dhcpd restart
