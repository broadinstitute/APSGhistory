#!/usr/bin/env python
import os
import sys
from string import Template

import pdb

# A service requires:
#  - A service.plist file in ~/Library/LaunchAgents
#  - An ssh key pair with public half specifying the command to run
#  - launchctl load for each service.plist file
def createService(targethost, port, localport):
    global username
    global homedir
    global sshdir

    label = targethost + "_" + str(port)

    # Create ssh key
    (sshpath, sshkeyfile) = createSshKey(label)

    # Create service.plist file
    plist_tmpl = open("./template.plist", 'r')
    plist_fname = homedir + "/Library/LaunchAgents/" + label + ".plist"
    plist = open(plist_fname, 'w')

    for line in plist_tmpl:
        t = Template(line)
        plist.write(t.substitute(label=label, user=username, port=localport, sshdir=sshdir, sshkey=sshkeyfile))

    # Load service
    # sys.stdout.write(os.popen("launchctl load " + plist_fname).readline())


def createSshKey(label):
    global sshdir
    global username
    type='rsa'
    passphrase=''
    comment='Key pair for ' + label
    bits='2048'
    filepath = sshdir + '/' + label

    # Create ssh directory if it does not exist
    if not os.path.exists(sshdir):
        os.mkdir(sshdir, mode=0700)
    

    # Build ssh command to create key.
    arguments = {'bits' : bits, 'comment' : comment, 'passphrase' : passphrase, 'filepath' : filepath, 'type' : type}
    sshcommand = 'ssh-keygen -b %(bits)s -C "%(comment)s" -N "%(passphrase)s" -f %(filepath)s -q -t %(type)s' % arguments
    # Create key if it doesn't exist, choke otherwise. This needs exceptions.
    if not os.path.exists(filepath):
        print sshcommand
        p = os.popen(sshcommand).readline()
        if p != '':
            print "Error creating key: " + p
        # Add command section to public half of key
        pub_fname = filepath + ".pub"
        pub_file = open(pub_fname, 'r')

        # Read the key    
        key = pub_file.readline()
        pub_file.close()
        (target, port) = label.split('_')
        values = {'target' : target, 'port' : port}
        keycmd = 'command="netcat %(target)s %(port)s",no-X11-forwarding,no-agent-forwarding,no-port-forwarding ' % values

        # Write command+key back into file    
        pub_file = open(pub_fname, 'w')
        pub_file.write(keycmd + key)    
        pub_file.close()
    else:
        print "Key " + filepath + " exists, should you really be running setup again?"
	sys.exit(1)

    return (filepath, label)

# Main program starts here

# Path to ssh directory
homedir = os.getenv('HOME')
sshdir = homedir + "/.ssh"
username = os.getenv('USER')


# Check for ssh directory. If it is not there, then exit and warn user 
# to set up passwordless ssh to gold before running this script.
if not os.path.exists(sshdir):
    print "You don't have an ssh directory, please configure ssh for"
    print "passwordless login to gold before proceeding with this script."
    sys.exit()

solids = ['ab-saa', 'ab-sab', 'ab-sac', 'ab-sad', 'ab-sae', 'ab-saf', 'ab-sag', 'ab-sah']

lport = 10110
for solid in solids:
    createService(solid, 5900, lport)
    lport += 1

