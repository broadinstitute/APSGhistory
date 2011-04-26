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
DEST_TREE_NAME="default"
SQL_CODE="
SELECT DISTINCT host_id FROM graph_tree_items WHERE host_id IN
(
SELECT host_id FROM 
(
	SELECT DISTINCT host.id AS Host_ID,count(host.hostname) AS HostCount FROM graph_tree
    	    INNER JOIN graph_tree_items ON graph_tree_items.graph_tree_id=graph_tree.id
        	INNER JOIN host ON graph_tree_items.host_id=host.id
        	GROUP BY Host_ID
        	HAVING ( HostCount > 1)
)AS host_IDS
);"
SQL_CMD="$MYSQL_BIN -e \"${SQL_CODE}\" -u${USER} -p${PASSWORD} -h ${DB_SERVER} ${DATABASE}"
SQL_OUT=$(echo "$SQL_CMD" | bash | grep -vi host_id)

TREE_ID=$(php -q $CLI_DIR/add_tree.php --list-trees | grep -i "$DEST_TREE_NAME" | awk '{print $1}')

if [ -n "${TREE_ID:+x}" ]; then
	SQL_CODE="
	DELETE FROM graph_tree_items WHERE host_id IN
	(
	SELECT host_id FROM 
	(
        SELECT DISTINCT host.id AS Host_ID,count(host.hostname) AS HostCount FROM graph_tree
            INNER JOIN graph_tree_items ON graph_tree_items.graph_tree_id=graph_tree.id
                INNER JOIN host ON graph_tree_items.host_id=host.id
                GROUP BY Host_ID
                HAVING ( HostCount > 1)
	)AS host_IDS
	) AND graph_tree_id <> $TREE_ID;"
	SQL_CMD="$MYSQL_BIN -e \"${SQL_CODE}\" -u${USER} -p${PASSWORD} -h ${DB_SERVER} ${DATABASE}"
else
	echo "Something is wrong with tree.  Does not compute." && exit 1
fi

for HOST_ID in $SQL_OUT; do
	if [ -n "${TREE_ID:+x}" ]; then
		if [[ $(php -q $CLI_DIR/add_tree.php --list-nodes --tree-id=$TREE_ID | grep -wc $HOST_ID) -eq 0 ]]; then
			php -q $CLI_DIR/add_tree.php --type=node --node-type=host --host-id=$HOST_ID --tree-id=$TREE_ID
			echo "$SQL_CMD" | bash
		else
			echo "Skipping add_tree for $HOST.  Already exists in tree, and Cacti is stupid."
		fi
	else
		echo "Something is wrong with tree.  Does not compute."
	fi
done
