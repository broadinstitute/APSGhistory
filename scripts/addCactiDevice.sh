#!/bin/bash

HOST=$1
TREE=$2
CSTRING=$3
HOST_TEMPLATE=$4

cd /var/lib/cacti/cli
#Add Host
HOST_TEMPLATE_ID=$(php -q add_device.php --list-host-templates | grep "$HOST_TEMPLATE" | awk '{print $1}')
php -q add_device.php --description=$HOST --ip=$(host $HOST | cut -f1 -d' ') --template=$HOST_TEMPLATE_ID --community=$CSTRING --ping_method=udp
HOST_ID=$(php -q add_tree.php --list-hosts | grep "$HOST" | awk '{print $1}')
TREE_ID=$(php -q add_tree.php --list-trees | grep -i "$TREE" | awk '{print $1}')
php -q add_tree.php --type=node --node-type=host --host-id=$HOST_ID --tree-id=$TREE_ID

#Add Graphs
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=4
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=11
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=13
php -q add_graphs.php --graph-type=ds --host-id=$HOST_ID --graph-template-id=35 --snmp-query-id=1 --snmp-field=ifIP --snmp-query-type-id=13 --snmp-value=$(host $HOST | awk '{print $NF}') --graph-title="$HOST - Traffic"

#Return you to your regularly scheduled program
cd -
