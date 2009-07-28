#!/bin/bash

# IP or CNAME target|new IP|MAC address|hostname|ttl|type|location|dhcpoptions|comment -*-Fundamental-*-

# Grab generic kernel info
KERNEL=`uname -n -m -r | tr ' ' '|'`

# Count the cores
NUMCPUS=`egrep -c "^processor" /proc/cpuinfo`

# Count the NICs
i=0
NICS=""
while /sbin/ifconfig eth${i} > /dev/null 2>&1 ; do
  NICS=${NICS}"eth${i} "
  let i+=1
done

NICINFO=
for nic in $NICS; do
  if [ -n "$NICINFO" ]; then NICINFO=${NICINFO}";"; fi
  NICINFO="${NICINFO}${nic},"
  NICINFO=${NICINFO}`/sbin/ifconfig $nic | awk '/HWaddr/ {print $5}'`
  NICINFO=${NICINFO}","`/sbin/ifconfig $nic | awk '/inet addr:/ { print $2;}' | cut -d':' -f2`
  NICINFO=${NICINFO}","`/sbin/ifconfig $nic | awk '/MTU/ {print $5}' | tr ':' '='`

  if [ -x /sbin/ethtool ]; then
    NICINFO=${NICINFO}","`/sbin/ethtool -i $nic | awk '/driver/ {print $2}'`
  fi  
done

MEM=`free -m | awk '/Mem/ {print $2}'`M

echo "$KERNEL|$NUMCPUS|$NICINFO|$MEM"

