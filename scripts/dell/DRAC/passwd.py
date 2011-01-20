#!/usr/bin/python
import pexpect,sys,time
from sys import argv,exit
from getpass import getpass

opass = getpass("Current Password:")
npass = getpass("New Password:")
npassConfirm = getpass("Confirm New Password:")
debugMode = True

if npass == npassConfirm:
	for host in argv[1:]:
		child = pexpect.spawn("ssh %s" % host)
		if debugMode:
			child.logfile = sys.stdout
		child.expect("root@%s.*'s password:" % host)
		child.sendline("%s" % opass)
		time.sleep(2)
		#child.expect('$')
		child.expect(['$', '>'])
		child.sendline("racadm config -g cfgUserAdmin -o cfgUserAdminPassword -i 2 \'%s\'" % npass)
		child.expect(['$', '>'])
		child.sendline("racadm racreset")
		child.expect(['$', '>'])
		child.sendline("exit")
		child.expect(pexpect.EOF)
		argv.pop(1)
else:
	print "Passwords do not match.  Exiting..."
	exit(1)
