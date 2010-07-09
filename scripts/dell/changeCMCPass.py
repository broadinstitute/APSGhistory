#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

host = argv[1]
opass = getpass("Current Password:")
npass = getpass("New Password:")

child = pexpect.spawn("ssh %s" % host)
child.logfile = sys.stdout
child.expect("root@%s's password:" % host)
child.sendline("%s" % opass)
child.expect('Welcome')
child.expect('$')
child.sendline("racadm config -g cfgUserAdmin -o cfgUserAdminPassword -i 1 \'%s\'" % npass)
child.expect('$')
child.sendline("racreset")
child.expect('$')
child.sendline("exit")
child.expect(pexpect.EOF)
