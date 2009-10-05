#!/usr/bin/env python

import pexpect
import telnetlib
import os
import sys
import re
import socket

class Chassis:
    def __init__(self, vendor, model, vendor_uuid ):
        self.vendorid = vendorid
        self.model = model
        self.vendor_uuid = vendor.uuid

def m1000e_run_command (host, username, password, cmd):
    ssh_newkey = 'Are you sure you want to continue connecting'
    child = pexpect.spawn('ssh -l %s %s %s'%(username, host, cmd ))
    i = child.expect([pexpect.TIMEOUT, ssh_newkey, 'password: '])
    if i == 0: # Timeout
        print 'ERROR!'
        print 'SSH could not login. Here is what SSH said:'
        print child.before, child.after
        return None
    if i == 1: # SSH does not have the public key. Just accept it.
        child.sendline ('yes')
        child.expect ('password: ')
        i = child.expect([pexpect.TIMEOUT, 'password: '])
        if i == 0: # Timeout
            print 'ERROR!'
            print 'SSH could not login. Here is what SSH said:'
            print child.before, child.after
            return None
    child.sendline(password)
    child.expect(pexpect.EOF)
    output = child.before
    return output

def ibm_run_command (host, username, password, cmd):
    prompt = 'system> '
    slots = []

    try:
        brsa = telnetlib.Telnet(host)
    except socket.error:
        print "%s refused connection." % host
        return None

    brsa.read_until('username: ')
    brsa.write(username + '\r\n')
    brsa.read_until('password: ')
    brsa.write(password + '\r\n')
    brsa.read_until(prompt)
    brsa.write(cmd + '\r\n')
    output = brsa.read_until(prompt)
    brsa.write('exit\r\n')

    return output

if __name__ == "__main__":
    import sys
    print m1000e_run_command("brsa63", "root", "U71l9ru8", "getmacaddress")
    print ibm_run_command("brsa33", "root", "U71l9ru8", "list -l 2")
    
