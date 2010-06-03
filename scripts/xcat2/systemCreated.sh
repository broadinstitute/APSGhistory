#!/bin/bash

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
	FS=$(ssh $HOST df -P / 2> /dev/null | awk 'END{print $1}')
	FS_DATE=$(ssh $HOST tune2fs -l $FS 2> /dev/null | grep 'Filesystem created:')
	FS_DATE=$(echo $FS_DATE | awk -F'created: ' '{print $2}')
	FS_DATE=$(date +%F -s "$FS_DATE") 
	echo "| $FS_DATE || $HOST" >> /root/bin/hostList.tmp

	NODE=$(cat /root/bin/hostList.tmp | sort | grep $FS_DATE | awk -F'| ' '{print $4}')
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
