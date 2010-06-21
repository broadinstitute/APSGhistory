#!/bin/bash

if [ -z $(which bhosts 2> /dev/null) ]; then
	. /broad/tools/scripts/useuse
	reuse LSF
fi

HOST_LIST=$(nodels)
echo "{| class="wikitable sortable"
|+Nodes Moved to Centos (Date is last Rebuild)
|-
! Date !! Details
"

for HOST in $HOST_LIST; do
	if [ $(bhosts $HOST 2>/dev/null | wc -l) -lt 1 ]; then
		continue
	fi

	IP=$(host $HOST 2>/dev/null | awk '{print $NF}')
	if [ -z $IP ]; then
		continue
	fi
	FS_DATE=$(snmpget -v2c -c pzCuQMLd $IP HOST-RESOURCES-MIB::hrSWInstalledDate.1 2>/dev/null | awk -F'STRING:' '{print $2}' 2>/dev/null | awk -F',' '{print $1" " $2}' | cut -f1 -d'.')
	if [ -z "$FS_DATE" ]; then
		continue
	fi
	OFFSET=$(snmpget -v2c -c pzCuQMLd $IP HOST-RESOURCES-MIB::hrSWInstalledDate.1 2>/dev/null | awk -F'STRING:' '{print $2}' 2>/dev/null | awk -F, '{print $NF}' | cut -f1 -d:)
	if [ -z "$OFFSET" ]; then
		continue
	fi

	FS_DATE=$(date -d @$(~ali/bashcalc.sh $(date +%s -d "$FS_DATE")+$(($OFFSET*$((60*60)))))) # Convert from UTC
	
	FS_DATE=$(date +%F -d "$FS_DATE")
	echo "| $FS_DATE || $HOST" >> /root/bin/hostList.tmp

	#FS=$(ssh $HOST df -P / 2> /dev/null | awk 'END{print $1}')
	#FS_DATE=$(ssh $HOST tune2fs -l $FS 2> /dev/null | grep 'Filesystem created:')
	#FS_DATE=$(echo $FS_DATE | awk -F'created: ' '{print $2}')
	#FS_DATE=$(date +%F -s "$FS_DATE") 

#	NODE=$(cat /root/bin/hostList.tmp | sort | grep $FS_DATE | awk -F'| ' '{print $4}')
	NODE=$(cat /root/bin/hostList.tmp | grep $FS_DATE | awk -F'| ' '{print $4}')
	OUTPUT="|-"
	OUTPUT="$OUTPUT $(echo "| $FS_DATE || $NODE" | tr '\n' ',' | sed 's/,$//g')"
	echo "$OUTPUT" >> /root/bin/hostList
done

for HOST in $HOST_LIST; do
	grep $HOST /root/bin/hostList | awk 'END{print}' >> /root/bin/hostList.tmp2
done

echo "$(cat /root/bin/hostList.tmp2 | sort -r | uniq | sed 's/|-/|-\n/g' | sed -r 's/(.{100},)/\1\<br \/\>/g')"
rm -f /root/bin/hostList.tmp*
rm -f /root/bin/hostList
echo "|}"
