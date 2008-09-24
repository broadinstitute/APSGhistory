#!/bin/sh

#DATESTR=`date +%Y%m%d-%H%M%S`
DATESTR=`date +%Y%m%d`

for fs in `zfs list | awk '/SL-X/ {print $1}' | egrep -v '(images|@)'`
do
    zfs snapshot "$fs@bkup$DATESTR"
done
