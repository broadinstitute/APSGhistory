#!/bin/bash

makehosts -n

service named stop
rm -f /etc/named.conf
makedns
service named start

service dhcpd stop
rm -f /etc/dhcpd.conf
/opt/xcat/sbin/makedhcp -a -d
/opt/xcat/sbin/makedhcp -n
/opt/xcat/sbin/makedhcp -a
service dhcpd restart
