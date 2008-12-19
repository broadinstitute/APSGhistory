#!/bin/bash

cd ~/Library/LaunchAgents

for svc in *ab*; do
  svcname=`echo $svc | cut -f1 -d'.'`
  if  launchctl list | grep $svcname > /dev/null 2>&1; then
    launchctl unload $svc
  else
    echo "Service $svcname not loaded."
  fi
done

rm *ab*

cd /Users/jbh/.ssh

rm *ab-*	
