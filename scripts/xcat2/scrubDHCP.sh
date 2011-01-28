#!/bin/bash

/opt/xcat/sbin/makehosts -n

sudo /sbin/service named stop
sudo rm -f /etc/named.conf
/opt/xcat/sbin/makedns
sudo /sbin/service named start

sudo /sbin/service dhcpd stop
sudo rm -f /etc/dhcpd.conf
/opt/xcat/sbin/makedhcp -a -d
/opt/xcat/sbin/makedhcp -n
/opt/xcat/sbin/makedhcp -a
sudo /sbin/service dhcpd restart

awk '$1 ~ /#xCAT#/ {print $2}' /sysman/install/broad/master.host.listing > /broad/tools/scripts/xcat2/build.host.listing
