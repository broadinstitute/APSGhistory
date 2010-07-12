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
                child.expect('password:')
                child.sendline("%s" % opass)
                child.expect('system>')
		child.send("env -T system:mm[1]\r")
		child.expect('system')
		child.send("users -2 -p %s\r" % npass)
		child.expect('system')
		child.send("users -2 -op %s -p %s\r" % (opass,npass))
		child.expect('system')
                child.send("exit\r")
                child.expect(pexpect.EOF)
else:
        print "Passwords do not match.  Exiting..."
        exit(1)
