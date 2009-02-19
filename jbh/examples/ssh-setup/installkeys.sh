#!/bin/bash

# Install solid VNC tunnel keys into users account on gold

echo "This script installs the public half of the new tunnel"
echo "keys into your authorized_keys file. It does NOT clean"
echo "up old copies of keys so if you are running this script"
echo "multiple times, you shoudl edit authorized_keys before"
echo "each run and remove old, unneeded keys."

read -p "Enter to continue and install keys, CTRL-C to exit: " 

pushd ~/.ssh
for key in ab-*.pub; do
  cat $key | ssh gold.broad.mit.edu "cat >> .ssh/authorized_keys"
done
