#/bin/bash

# $Id$

MYSQL_BIN="/usr/bin/mysql"
CLI_DIR="/var/lib/cacti/cli"
for VAR in $(grep '^\$' /etc/cacti/db.php | tr -d '$ ;'| tr "\'" '"');do
        eval $VAR
done
USER=$database_username
PASSWORD=$database_password
DB_SERVER=$database_hostname
DATABASE=$database_default
SRC_TREE_NAME=$1
DEST_TREE_NAME=$2
HOSTNAME=$3

HOST=$(php -q $CLI_DIR/add_tree.php --list-hosts | grep -w "$HOSTNAME" | awk '{print $1}')
SRC_TREE=$(php -q $CLI_DIR/add_tree.php --list-trees | grep -i "$SRC_TREE_NAME" | awk '{print $1}')
DEST_TREE=$(php -q $CLI_DIR/add_tree.php --list-trees | grep -i "$DEST_TREE_NAME" | awk '{print $1}')

SQL_CODE="
DELETE FROM graph_tree_items
WHERE host_id=${HOST}
	AND graph_tree_id=${SRC_TREE};"
	
SQL_CMD="$MYSQL_BIN -e \"${SQL_CODE}\" -u${USER} -p${PASSWORD} -h ${DB_SERVER} ${DATABASE}"

TREE_ID=$(php -q $CLI_DIR/add_tree.php --list-trees | grep -i "$DEST_TREE_NAME" | awk '{print $1}')
if [ -n $TREE_ID ]; then
        if [[ $(php -q $CLI_DIR/add_tree.php --list-nodes --tree-id=$TREE_ID | grep -wc "$HOSTNAME") -eq 0 ]]; then
                php -q $CLI_DIR/add_tree.php --type=node --node-type=host --host-id=$HOST --tree-id=$DEST_TREE
		echo "$SQL_CMD" | bash
        else
                echo "Skipping add_tree for $HOST.  Already exists in tree, and Cacti is stupid."
        fi
else
        echo "Something is wrong with tree.  Does not compute."
fi
