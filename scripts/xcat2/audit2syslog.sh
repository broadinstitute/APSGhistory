#!/bin/bash
# $Id$

RAW_LOGS=$(/opt/xcat/sbin/tabprune auditlog -V -a | grep -v '^#')
CLEAN_LOGS=$(echo "$RAW_LOGS" | awk -F, '{printf "recid:" $1 ", audittime:" $2 ", userid:" $3 ", clientname:" $4 ", clienttype:" $5 ", command:" $6 ", noderange:" $7 ", args:" $8 ", status:" $9 "\n"}' | tr -d '"')
echo "$CLEAN_LOGS" | /bin/logger -t xCAT-Audit -p local0.notice
