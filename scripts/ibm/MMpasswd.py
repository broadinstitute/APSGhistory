#!/usr/bin/python
import pexpect,sys
from sys import argv,exit
from getpass import getpass
from time import sleep

opass = getpass("Current Password:")
npass = getpass("New Password:")
npassConfirm = getpass("Confirm New Password:")
failedMM=[]
debugMode = True

if npass == npassConfirm:
	for host in argv[1:]:
		try:
			child = pexpect.spawn("ssh %s" % host)
			if debugMode:
				child.logfile = sys.stdout
			child.expect('password:')
			child.sendline("%s" % opass)
			child.expect('>')
			child.send("env -T system:mm[1]\r")
			child.expect('>')
			child.send("users -2 -p %s\r" % npass)
			child.expect('>')
			child.send("users -2 -op %s -p %s\r" % (opass,npass))
			child.expect('>')
			child.send("exit\r")
			child.expect(pexpect.EOF)
		except Exception:
                        failedMM.append(host)
                        argv.pop(1)
                        continue

        for host in failedMM:
		print "%s ".rstrip() % host

else:
        print "Passwords do not match.  Exiting..."
        exit(1)
