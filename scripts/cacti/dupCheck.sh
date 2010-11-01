#/bin/bash

MYSQL_BIN="/usr/bin/mysql"
MAIL_LIST="ali@broadinstitute.org frans@broadinstitute.org teixeira@broadinstitute.org"
USER="cacti"
PASSWORD="S9Ph6w7p"
DB_SERVER="itdb"
DATABASE="cacti"
SQL_CODE="
SELECT host.hostname AS HostName,graph_tree.name FROM
(
	SELECT graph_tree.name AS TreeName,host.hostname AS HostName,count(host.hostname) AS HostCount FROM graph_tree
        INNER JOIN graph_tree_items ON graph_tree_items.graph_tree_id=graph_tree.id
        INNER JOIN host ON graph_tree_items.host_id=host.id
        GROUP BY HostName
        HAVING ( HostCount > 1)
) AS tree_counts
JOIN host ON tree_counts.HostName=host.hostname
JOIN graph_tree_items ON host.id=graph_tree_items.host_id
JOIN graph_tree ON graph_tree_items.graph_tree_id=graph_tree.id
ORDER BY HostName;"

SQL_CMD="$MYSQL_BIN -e \"${SQL_CODE}\" -u${USER} -p${PASSWORD} -h ${DB_SERVER} ${DATABASE}"
SQL_OUT=$(echo "$SQL_CMD" | bash)

COUNT=0
for HOST in $(echo "$SQL_OUT" | awk '$1 !~ /HostName/ {print $1}' | uniq);do
	COUNT=$(($COUNT+1))
done

OUTPUT=$(echo "$COUNT host(s) in DB ${DATABASE} with duplicates:")

OUTPUT="${OUTPUT}
$(for HOST in $(echo "$SQL_OUT" | awk '$1 !~ /HostName/ {print $1}' | uniq);do
	echo -e "\t$HOST has entries in:"

	for TABLE in $(echo "$SQL_OUT" | grep -w $HOST | awk '{print $2}'); do
		echo -e "\t\t$TABLE"
	done
done)"

echo "$OUTPUT" | mail -s "Cacti Duplicate Check" ${MAIL_LIST}
