#!/bin/bash -x

FILE="/home/radon01/ali/private_html/build.host.listing.html"
TMP_FILE="/tmp/bhl.tmp"
USER=root
SSH_HOST=pm

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

for HOST in $(ssh $USER@$SSH_HOST nodels); do
	if [ $(ssh $USER@$SSH_HOST grep $HOST /etc/dhcpd.conf | wc -l) -lt 1 ]; then
		continue
	fi

	IP=$(ssh $USER@$SSH_HOST grep $HOST /opt/xcat/etc/hosts | awk '{print $1}')
	MAC=$(ssh $USER@$SSH_HOST grep $HOST /opt/xcat/etc/mac.tab | awk '{print $2}')
	TAGS=$(ssh $USER@$SSH_HOST grep $HOST /opt/xcat/etc/nodetype.tab | awk '{print $2}')

	echo "|$IP|||$MAC|||$HOST|||$TAGS||" >> $TMP_FILE
done

cat $TMP_FILE | sort -n -t . -k 1,1 -k 2,2 -k 3,3 -k 4,4 >> $FILE
sed -i -e '/^#/d' -e 's/^|/<tr><td>/g' -e 's/|$/<\/tr>/g' -e 's/||/<\/td>\n/g' -e 's/|/<td>/g' -e 's/<td><\/tr>/<\/td><\/tr>/g' $FILE
echo "
</table>
</body>
</html>
" >> $FILE

rm $TMP_FILE
