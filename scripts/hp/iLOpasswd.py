#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

opass = getpass("Current Password:")
npass = getpass("New Password:")
npassConfirm = getpass("Confirm New Password:")
failediLO=[]
debugMode = True

if npass == npassConfirm:
	for host in argv[1:]:
		try:
			child = pexpect.spawn("ssh %s" % host)
			if debugMode:
				child.logfile = sys.stdout
			child.expect("password:")
			child.send("%s\r" % opass)
			child.expect('hpiLO')
			child.send("set map1/accounts1/root password=%s\r" % npass)
			child.expect('hpiLO')
			child.send("exit\r")
			child.expect(pexpect.EOF)
		except Exception:
			failediLO.append(host)
			argv.pop(1)
			continue

	for host in failediLO:
		print "%s ".rstrip() % host
		
else:
	print "Passwords do not match.  Exiting..."
	exit(1)
