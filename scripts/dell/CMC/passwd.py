#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

if len(argv) < 2:
	print "Feed me a chassis to work with"
	print "USAGE: %s $CHASSIS" % argv[0]
	exit (1)

npass = getpass("New Password:")
npassConfirm = getpass("Confirm New Password:")
debugMode = True

if npass == npassConfirm:
	for host in argv[1:]:
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
		argv.pop(1)
else:
	print "Passwords do not match.  Exiting..."
	exit(1)
