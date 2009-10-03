#!/usr/bin/env python

import sys
import re
import os

# Files
mhl = open("//sysman/install/broad/master.host.listing", 'r')
ci = open("/sysman/scratch/jbh/blades.list", 'r')

# Regex's
commentre = re.compile("^#.*$")
macre = re.compile("([a-fA-F0-9]{2}[:|\-]?){6}")
ipre = re.compile("^(\d{1,3}\.){3}\d{1,3}")
nodere = re.compile("^node\d*$")
ibmbrsare = re.compile("brsa[1234]\d")
dellbrsare = re.compile("brsa[56789]\d")

# Build mhl dictionary.

mhldict = {}
for line in mhl.readlines():
    if ipre.match(line):
        (ip, sip, mac, namelist, ttl, type, location, dhcpoptions, comment) = line.lower().split("|")
  
        if mac in mhldict:
            mhldict[mac].extend(namelist.split(','))
        else:
            names = namelist.split(',')
            mhldict[mac] =  names 

brsaalias = {}
brsaconf = {}
config = {}
aconfig = {}

for line in ci.readlines():
    lsplit = line.lower().split()
    brsa = lsplit[0]
    plug = lsplit[1]
    macs = lsplit[2:]
    
    for mac in macs:
        if mac in mhldict:
            key = brsa + "-" + plug
            brsaconf[key] = mhldict[mac] 

for a in brsaconf.keys():
    names = brsaconf[a]
    nodename = ""
    (brsa, plug) = a.split('-')
    for n in names:
        if nodere.match(n):
            # Print conf line
            if n not in config:
                nodename = n
                config[n] = [ 'node "%s" "%s" "%s"' % ( n, brsa, plug ) ]
                if brsa in brsaalias:
                    brsaalias[brsa].append(nodename)
                else:
                    brsaalias[brsa] = [ nodename ]
            else:
                config[n].append( '#DUPLICATE node "%s" "%s" "%s"' % ( n, brsa, plug ) )
            names.remove(n)
            break
    for n in names:
        if n not in config and nodename not in config:
            config[n] = [ 'node "%s" "%s" "%s"' % ( n, brsa, plug )  ]
            nodename = n
        elif n not in aconfig:
            aconfig[n] = [ 'alias "%s" "%s"' % ( n, nodename ) ]
        else: 
            aconfig[n].append( '#DUPLICATE alias "%s" "%s"' % ( n, nodename ) )

for d in config:
    for l in config[d]:
        print l

for d in aconfig:
    for l in aconfig[d]:
        print l

for brsa in brsaalias:
    nodelist = ",".join(brsaalias[brsa])
    print 'alias "%s" "%s"' % (brsa, nodelist)




