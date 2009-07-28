#!/bin/bash

for dir in `ypcat mounts.byname | awk '{print $2}'`; 
  do 
    if ! /broad/tools/NoArch/pkgs/local/checkmount $dir; then 
      echo "Error checking $dir"
    fi
  done

for host in iwww www twiki tryptophan pm po www.google.com www.yahoo.com nohost; 
  do
    if host $host | grep -q "not found"; then
      echo "Error looking up $host."
    fi
  done

