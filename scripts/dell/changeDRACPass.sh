#!/bin/bash
HOSTS=$(echo $1 | tr ',' ' ')

echo -e "Please enter your desired password: "
stty -echo
read PASSWORD
echo -e "Please re-enter your desired password: "
stty -echo
read CONF_PASS
stty echo

if [ $PASSWORD == $CONF_PASS ]; then
	for HOST in $HOSTS; do
		ssh $HOST racadm config -g cfgUserAdmin -o cfgUserAdminPassword -i 2 $PASSWORD
		ssh $HOST racadm racreset
	done
else
	echo "Passwords do not match.  Please try again."
	exit 1
fi
