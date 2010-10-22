#!/bin/bash
# Generates nodelocation for Dell blades.  Inserts in nodepos

POS_FILE=/tmp/nodepos.csv
echo "#node,rack,u,chassis,slot,room,comments,disable" > $POS_FILE
for CMC in brsa{50..88}; do
	ssh service@$CMC getslotname | awk -v cmc=$CMC '$5 !~ /Host/ {print $3 ",," cmc "," $1 ",,,"}' >> $POS_FILE
done

/opt/xcat/sbin/tabrestore $POS_FILE
rm -rf $POS_FILE
