#!/bin/bash

# This script sets up a user to use passwordless ssh login to gold/silver/lead/...


echo "This script assumes your local username is the same"
echo "as your broad username, that is, that you log onto this"
echo "computer with the same username you would use to connect"
echo "to gold.broad.mit.edu."
echo
echo
echo "First we'll ssh to gold, just to make sure you have a "
echo "correctly configured ~/.ssh directory on the local machine."
echo
echo
read -p "Press Enter to continue, CTRL-C to exit script: "
echo
echo
ssh gold.broad.mit.edu uptime
echo
read -p "Press Enter to continue, CTRL-C to exit script: "
echo
echo "You should have been prompted for your password, then "
echo "the command should have returned the output of 'uptime'"
echo "on gold. "
echo 
echo "If you got the uptime output but weren't prompted for a "
echo "password, then you can CTRL-C this script as you already "
echo "have a working passwordless ssh setup."
echo
echo "If you were unable to log on with your password, then go"
echo "fix that problem and come back when you have a working "
echo "password."
echo
echo
echo
echo "Now we'll create an ssh key for you."
read -p "Press enter to continue, CTRL-C to exit..."
echo
echo

SSHDIR="$HOME/.ssh"
SSHPRIVKEY="$SSHDIR/id_rsa"
SSHPUBKEY="$SSHDIR/id_rsa.pub"

if [ -e $SSHPRIVKEY ] && [ -e $SSHPUBKEY ]; then
  echo "Your rsa identity already exists, using it."
else
  echo "You can protect your ssh identity with a passphrase. However,"
  echo "if you do you will need to enter that passphrase to use the "
  echo "identity when making connections. This is a Good Thing(tm) "
  echo "and if you are using OS X Leopard or later it should intelligently"
  echo "manage this for you. "
  echo

  read -p "Would you like to use a passphrase? [y or n]: " RESPONSE
  if [[ $RESPONSE == "y" || $RESPONSE == "Y" || $RESPONSE == "" ]]; then 
    ssh-keygen -b 2048 -f $SSHPRIVKEY -t rsa
  else
    ssh-keygen -b 2048 -f $SSHPRIVKEY -t rsa -N ''
  fi
fi

echo
read -p "Press Enter to continue, CTRL-C to exit script: "
echo
echo "Next your ssh key public half will be installed in your home "
echo "directory on gold (and consequently all broad machines) as "
echo "an authorized key. During this process you may be asked for "
echo "your unix password several times to connect to gold. "
echo
read -p "Press enter to continue, CTRL-C to exit script: "
echo
echo
# Make sure .ssh directory exists
echo "Checking for ssh directory..."
ssh gold.broad.mit.edu "mkdir .ssh"
echo "Checking ssh directory permissions..."
ssh gold.broad.mit.edu "chmod 0700 .ssh"
echo "Installing public key in authorized_keys file"
cat $SSHPUBKEY | ssh gold.broad.mit.edu "cat >> .ssh/authorized_keys"
echo
echo
read -p "Press Enter to continue, CTRL-C to exit script: "
echo
echo
echo "Unless there were errors from the last step, you should be ready to "
echo "connect without using a password. Let's test it."
echo
read -p "Press enter to continue, CTRL-C to exit script: "
echo
echo
ssh gold.broad.mit.edu uptime
echo
echo
echo "If you just got the output of the uptime command from gold, then "
echo "setup was successful. If not or if you were prompted for your "
echo "password then you'll need to take additional steps. If you "
echo "chose to use a passphrase then you may have been prompted for it"
echo "but if you selected the option to store it in your keychain, you "
echo "should not see that prompt again (until/unless you change your "
echo "login password on this workstation."
echo



