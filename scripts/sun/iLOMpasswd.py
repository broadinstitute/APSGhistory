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
		child = pexpect.spawn("ssh %s" % host)
		if debugMode:
			child.logfile = sys.stdout
		child.expect("Password:")
		child.send("%s\r" % opass)
		child.expect('->')
		child.send("set /SP/users/root password=%s\r" % npass)
		child.expect('Enter new')
		child.send("%s\r" % npass)
		child.expect('->')
		child.send("exit\r")
		child.expect(pexpect.EOF)
else:
	print "Passwords do not match.  Exiting..."
	exit(1)
