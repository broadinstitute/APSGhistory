#!/bin/bash
HOST=$1
PASSWORD=$2

ssh $HOST racadm config -g cfgUserAdmin -o cfgUserAdminPassword -i 2 $PASSWORD
ssh $HOST racadm racreset
