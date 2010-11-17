#!/bin/bash

# $Id$
# Here we define Usage -- define once, print many
USAGE="Usage: $(basename $0) HOST TREE_NAME COMMUNITY TEMPLATE"

# Here we define how many arguments we should accept
ARG_NO=4

# error codes as defined in /usr/include/sysexits.h
E_OK=0       # successful termination
E_USAGE=64      # command line usage error 

if [ $# -ne "$ARG_NO" ]; then
        echo 1>&2 $USAGE
        exit $E_USAGE
fi

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
if [ -n "${TREE_ID:+x}" ]; then
	if [[ $(php -q add_tree.php --list-nodes --tree-id=$TREE_ID | grep -wc "$HOST") -eq 0 ]]; then
		php -q add_tree.php --type=node --node-type=host --host-id=$HOST_ID --tree-id=$TREE_ID
	else
		echo "Skipping add_tree for $HOST.  Already exists in tree, and Cacti is stupid."
	fi
else
	echo "Something is wrong with tree.  Does not compute."
fi

#Add Graphs
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=4
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=11
php -q add_graphs.php --host-id=$HOST_ID --graph-type=cg --graph-template-id=43
php -q add_graphs.php --graph-type=ds --host-id=$HOST_ID --graph-template-id=35 --snmp-query-id=1 --snmp-field=ifIP --snmp-query-type-id=13 --snmp-value=$(host $HOST | awk '{print $NF}') --graph-title="$HOST - Traffic"

#Return you to your regularly scheduled program
cd -
