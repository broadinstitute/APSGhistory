#!/bin/bash

. /broad/tools/scripts/useuse
reuse -q LSF
for OS_TYPE in $(lshosts -s ostype | awk '$2 ~ /CENT/ {print $2}' | sort -u); do
	OUTPUT=$(~ali/bashcalc.sh $(lshosts -s ostype | grep $OS_TYPE | wc -l)/$(lshosts -s ostype | grep CENT | wc -l))
	OUTPUT=$(~ali/bashcalc.sh $OUTPUT*100)
	echo "$OUTPUT% ($(lshosts -s ostype | grep $OS_TYPE | wc -l)/$(lshosts -s ostype | grep -v RESOURCE | wc -l)) of LSF is $OS_TYPE"
done
echo "$(~ali/bashcalc.sh $(~ali/bashcalc.sh $(lshosts -s ostype | grep CENT | wc -l)/$(lshosts -s ostype | grep -v RESOURCE | wc -l))*100)% ($(lshosts -s ostype | grep CENT | wc -l)/$(lshosts -s ostype | grep -v RESOURCE | wc -l)) of LSF is CentOS"
