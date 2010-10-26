#!/bin/bash

USER=service

while [ $# -ge 1 ]; do
	HOST=$1

	ssh $USER@$HOST config -g cfgActiveDirectory -o cfgADCertValidationEnable 0 &> /dev/null

	if [ $? -gt 0 ];then
		echo "Configure Failed.  Check SSH."
		exit 1
	fi

	shift
done
