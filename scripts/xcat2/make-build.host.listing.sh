#!/bin/bash

OUTFILE="/home/radon01/ali/private_html/build.host.listing.html"
TMP_FILE="/tmp/bhl.tmp"

FILE=$(echo "
<html>
<head>
<title>Build Host Listing</title>
</head>

<body>
<table border=1>
<tr>
<th>IP</th>
<th>MAC</th>
<th>Host Name</th>
<th>Tags</th>
</tr>
")

IP=$(/sbin/ifconfig eth1 | awk -F: '/inet addr/ {print $2}' | cut -f1 -d' ')
MAC=$(/sbin/ifconfig eth1 | awk '/HWaddr/ {print $5}')
HOST=$(hostname | cut -f1 -d.)

echo "|$IP|||$MAC|||$HOST|||||" > $TMP_FILE

IP_LIST=$(/opt/xcat/sbin/tabdump hosts)
MAC_LIST=$(/opt/xcat/sbin/tabdump mac)
TAG_LIST=$(/opt/xcat/sbin/tabdump nodelist)

for HOST in $(/opt/xcat/bin/nodels); do
        IP=$(echo "$IP_LIST" | grep -w $HOST | awk -F, '{print $2}' | tr -d '"')
        MAC=$(echo "$MAC_LIST" | grep -w $HOST | awk -F, '{print $3}' | tr -d '"')
        TAGS=$(echo "$TAG_LIST" | grep -w $HOST | awk -F\" '{print $4}')

	echo "|$IP|||$MAC|||$HOST|||$TAGS||" >> $TMP_FILE
done

FILE=${FILE}$(cat $TMP_FILE | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4 | sed -e '/^#/d' -e 's/^|/<tr><td>/g' -e 's/|$/<\/tr>/g' -e 's/||/<\/td>\n/g' -e 's/|/<td>/g' -e 's/<td><\/tr>/<\/td><\/tr>/g')
FILE=${FILE}$(echo "
</table>
</body>
</html>
")

echo "$FILE" > $OUTFILE

rm -f $TMP_FILE
