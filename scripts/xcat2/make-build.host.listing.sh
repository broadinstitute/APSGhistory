#!/bin/bash

FILE="/home/radon01/ali/private_html/build.host.listing.html"
TMP_FILE="/tmp/bhl.tmp"

echo "
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
" > $FILE

IP=$(/sbin/ifconfig eth1 | awk -F: '/inet addr/ {print $2}' | cut -f1 -d' ')
MAC=$(/sbin/ifconfig eth1 | awk '/HWaddr/ {print $5}')
HOST=$(hostname | cut -f1 -d.)

echo "|$IP|||$MAC|||$HOST|||||" >> $TMP_FILE

for HOST in $(/opt/xcat/bin/nodels); do
	IP=$(/opt/xcat/sbin/tabdump hosts | grep -w $HOST | awk -F, '{print $2}' | tr -d '"')
	MAC=$(/opt/xcat/sbin/tabdump mac | grep -w $HOST | awk -F, '{print $3}' | tr -d '"')
	TAGS=$(/opt/xcat/sbin/tabdump nodelist | grep -w $HOST | awk -F\" '{print $4}')

	echo "|$IP|||$MAC|||$HOST|||$TAGS||" >> $TMP_FILE
done

cat $TMP_FILE | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4 >> $FILE
sed -i -e '/^#/d' -e 's/^|/<tr><td>/g' -e 's/|$/<\/tr>/g' -e 's/||/<\/td>\n/g' -e 's/|/<td>/g' -e 's/<td><\/tr>/<\/td><\/tr>/g' $FILE
echo "
</table>
</body>
</html>
" >> $FILE

rm -f $TMP_FILE
