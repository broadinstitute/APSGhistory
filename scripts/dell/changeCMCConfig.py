#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

hosts = argv[1].split(',')
group = argv[2]
object = argv[3]
value = argv[4]
password = getpass("Password:")
debugMode = True

for host in hosts:
	child = pexpect.spawn("ssh %s" % host)
	if debugMode:
		child.logfile = sys.stdout
	child.expect("root@%s's password:" % host)
	child.sendline("%s" % password)
	child.expect('Welcome')
	child.expect('$')
	child.sendline("racadm config -g %s -o %s %s" % (group,object,value))
	child.expect('$')
	child.sendline("exit")
	child.expect(pexpect.EOF)
