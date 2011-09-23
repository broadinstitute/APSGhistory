#!/usr/bin/env python
import os
from subprocess import *
from socket import gethostname
import sys
from tempfile import NamedTemporaryFile

#Functions
def addHosts(line):
    fields=line.split()[1].split('|')
    (ip,mac,node,groups,mpa,id)=fields[0:6]
    if len(mpa)>0 and len(id)>0:
        nodeaddCMD="nodeadd {0} groups={1} mac.interface=eth0 hosts.ip={2} mac.mac={3} mp.mpa={4} mp.id={5}".format(node,groups,ip,mac,mpa,id)
    else:
        nodeaddCMD="nodeadd {0} groups={1} mac.interface=eth0 hosts.ip={2} mac.mac={3}".format(node,groups,ip,mac)
        
    Popen(nodeaddCMD.split(),stdout=PIPE,stderr=PIPE).communicate()

def removeHosts(line):
    fields=line.split('|')
    if len(fields) < 4: return 
    node=fields[2]
    nodermCMD="noderm {0}".format(node)
    
    Popen(nodermCMD.split(),stdout=PIPE,stderr=PIPE).communicate()
#Commands
lsdefAttr='ip,mac,groups,mpa,id'
lsdefCMD=['lsdef','-t','node','-i',lsdefAttr]
lsdef=Popen(lsdefCMD,stdout=PIPE).communicate()[0].split('Object')

#Files
buildFile=NamedTemporaryFile(mode='a',delete=False)
buildFileName=buildFile.name
buildfile_entries=""
masterHost='/sysman/install/broad/master.host.listing'

for block in lsdef:
    if len(block.split('\n'))==0:continue
    hostName=None
    groups=None
    id=None
    ip=None
    mac=None
    mpa=None
    for line in block.split('\n'):
        if len(line.rstrip())==0:continue
        if 'name' in line: hostName=line.split(':')[1].lstrip()
        if 'groups=' in line: groups=line.split('=')[1]
        if 'id=' in line: id=line.split('=')[1]
        if 'ip=' in line: ip=line.split('=')[1]
        if 'mac=' in line: mac=line.split('=')[1]
        if 'mpa=' in line: mpa=line.split('=')[1]
    if (hostName is None or
	groups is None or
	ip is None or
	mac is None): continue
    buildfile_entries="{0}#xCAT# {1}|{2}|{3}|{4}|{5}|{6}|\n".format(buildfile_entries,ip,mac,hostName,groups,mpa,id)
buildFile.write(buildfile_entries)
buildFile.close()

with open(buildFileName,'r') as buildfile:
	buildFileList=buildfile.readlines()
os.remove(buildFileName)

mhlList=[]

with open(masterHost,'r') as mhl:
	for line in mhl:
	    if not line.startswith('#xCAT#'):continue
	    if '7cc' in line and 'xcat2s' in gethostname():
		continue
	    elif '1ss' in line and ('xcat2' == gethostname() or
	    'xcat2.broadinstitute.org' == gethostname()):
		continue
	    mhlList.append(line)

for line in buildFileList:
    if line in mhlList: continue
    if len(line.split('|')) < 4: continue
    print("To be removed: {0}".format(line.rstrip()))
    removeHosts(line)
    
for line in mhlList:
    if line in buildFileList: continue
    print("To be added/modified: {0}".format(line.rstrip()))
    removeHosts(line)
    addHosts(line)
