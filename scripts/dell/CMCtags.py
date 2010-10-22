#!/usr/local/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

hosts = argv[1].split(',')
opass = getpass("Current Password:")
debugMode = True

for host in hosts:
	child = pexpect.spawn("ssh %s" % host)
	if debugMode:
		child.logfile = sys.stdout
	child.expect("root@%s's password:" % host)
	child.sendline("%s" % opass)
	child.expect('Welcome')
	child.expect('$')
	child.sendline("racadm getsvctag -m chassis")
	child.expect('$')
	child.sendline("exit")
	child.expect(pexpect.EOF)
