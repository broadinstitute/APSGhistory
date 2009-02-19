#!/bin/bash

# This loads services in ~/Library/Launchagents matching pattern *ab*



cd ~/Library/LaunchAgents


for svc in *ab*; do
  svcname=`echo $svc | cut -f1 -d'.'`
  if ! launchctl list | grep $svcname > /dev/null 2>&1; then
    launchctl load $svc
  else
    echo "Service $svcname already loaded."
  fi
done


