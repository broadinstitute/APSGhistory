#!/usr/bin/env python

import pexpect
import telnetlib
import os
import sys
import re
import socket
from nodes import *
from mhl import *

# List all dell chassis that contain FarmTNG compute nodes here.
dellchassis = [ 
    'brsa64',
    'brsa63' ]

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

def dell_nodeinfo (host, username, password):

    global mhldict
    nodedict = {}
    nodelist = []
    idre = re.compile('(Server-\d+) +(.*)')
    srvre = re.compile('(Server-\d+)')
    macre = re.compile('([0-9a-fA-F]{2}[:|\-]?){6}')
    nare = re.compile('N/A')
    plugre = re.compile('(\d+)')

    # Get Service Tags to build a list of nodes in chassis
    output = m1000e_run_command(host, username, password, 'getsvctag')
    for line in output.splitlines():
        # If this is a Server line and a ST is available, add an entry for it.
        s = idre.match(line)   
        if s and not nare.search(line):
            nodedict[s.groups()[0]] = [ s.groups()[1] ]

    # Get MAC Addresses
    output = m1000e_run_command(host, username, password, 'getmacaddress')
    for line in output.splitlines():
        s = srvre.match(line)
        if s and s.groups()[0] in nodedict:
            slot = s.group()
            macs = []
            for word in line.split():
                mac = macre.search(word)	
                if mac:
                    macs.append(mac.group().rstrip().lower())
            nodedict[slot].extend(macs)
    # Nodelist now has all slots/blades along with ST and a list of macs in 
    # BMC, NIC1, NIC2, ..., NICn where n can be as large as 6.
    for slot in nodedict.keys():
        plug = int(plugre.search(slot).group())
        node = Node(nodedict[slot][0], host, plug)
        n = nodedict[slot]
        macaddr = EUI(n[1])
        if macaddr in mhldict:
            node.addnic('BMC', 
                        macaddr, 
                        ipaddr = mhldict[macaddr].ipaddr,
                        hostname = mhldict[macaddr].hostname,
                        cnames = mhldict[macaddr].aliases)
        else:
            node.addnic('BMC', macaddr) 
        i = 0
        for nic in n[2:]:
            i = i + 1
            name = "NIC" + str(i)
            macaddr = EUI(nic)
            if macaddr in mhldict:
                node.addnic(name, 
                            macaddr, 
                            ipaddr = mhldict[macaddr].ipaddr,
                            hostname = mhldict[macaddr].hostname,
                            cnames = mhldict[macaddr].aliases)
            else:
                node.addnic(name, macaddr) 
        nodelist.append(node)
    return nodelist
    
username = 'root'
password = 'U71l9ru8'
chassislist = {}
mhldict = buildmhldict()

for brsa in dellchassis:

    chassislist[brsa] = dell_nodeinfo (brsa, username, password)
    for chassis in chassislist.keys():
        for node in chassislist[chassis]:
            print node.powerman_node()
