#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

hosts = argv[1].split(',')
opass = getpass("Current Password:")
npass = getpass("New Password:")
npassConfirm = getpass("Confirm New Password:")
debugMode = True

if npass == npassConfirm:
	for host in hosts:
		child = pexpect.spawn("ssh service@%s" % host)
		if debugMode:
			child.logfile = sys.stdout
		child.expect('Welcome')
		child.expect('$')
		child.sendline("racadm config -g cfgUserAdmin -o cfgUserAdminPassword -i 1 \'%s\'" % npass)
		child.expect('$')
		child.sendline("racadm deploy -a -u root -p %s" % npass)
		child.expect('$')
		child.sendline("racreset")
		child.expect('$')
		child.sendline("exit")
		child.expect(pexpect.EOF)
else:
	print "Passwords do not match.  Exiting..."
	exit(1)
