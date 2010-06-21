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

for HOST in $(nodels); do
	IP=$(tabdump hosts | grep $HOST | awk -F, '{print $2}' | tr -d '"')
	MAC=$(tabdump mac | grep $HOST | awk -F, '{print $3}' | tr -d '"')
	TAGS=$(tabdump nodelist | grep $HOST | awk -F\" '{print $4}')

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
rm -f /tmp/dhcpd.conf.pm
rm -f /tmp/hosts.pm
rm -f /tmp/mac.tab.pm
rm -f /tmp/nodetype.tab.pm
