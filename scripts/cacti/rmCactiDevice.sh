#!/bin/bash

HOST=$1

cd ~cacti/cli
#Add Host
HOST_ID=$(php -q remove_device.php --list-devices | grep -i $HOST | awk '{print $1}')
php -q remove_device.php --device-id=$HOST_ID

#Return you to your regularly scheduled program
cd -
