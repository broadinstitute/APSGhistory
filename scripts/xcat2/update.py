#!/usr/bin/env python
import sys,re,os
from subprocess import *
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
    node=fields[2]
    nodermCMD="noderm {0}".format(node)
    
    Popen(nodermCMD.split(),stdout=PIPE,stderr=PIPE).communicate()
#Commands
lsdefAttr='ip,mac,groups,mpa,id'
lsdefCMD=['lsdef','-t','node','-i',lsdefAttr]
lsdef=Popen(lsdefCMD,stdout=PIPE).communicate()[0].split('\n\n')

#Files
buildFile=NamedTemporaryFile(delete=False)
buildFileName=buildFile.name
masterHost='/sysman/install/broad/master.host.listing'

for line in lsdef:
    if len(line.split('\n'))==0:continue
    #print line.split('\n')
    for entry in line.split('\n'):
        if len(entry.rstrip())==0:continue
        if 'Object' in entry: hostName=entry.split(':')[1].lstrip(' ')
        if 'groups=' in entry: groups=entry.split('=')[1]
        if 'id=' in entry: id=entry.split('=')[1]
        if 'ip=' in entry: ip=entry.split('=')[1]
        if 'mac=' in entry: mac=entry.split('=')[1]
        if 'mpa=' in entry: mpa=entry.split('=')[1]
    buildFile.write("#xCAT# {0}|{1}|{2}|{3}|{4}|{5}|\n".format(ip,mac,hostName,groups,mpa,id))
buildFile.close()

buildFile=open(buildFileName,'r')
buildFileList=buildFile.readlines()

mhl=open(masterHost,'r')
mhlList=[]

for line in mhl:
    if not re.match('#xCAT#',line):continue
    mhlList.append(line)

for line in buildFileList:
    if line in mhlList: continue
    print("To be removed: {0}".format(line.rstrip()))
    removeHosts(line)
    
for line in mhlList:
    if line in buildFileList: continue
    print("To be added/modified: {0}".format(line.rstrip()))
    removeHosts(line)
    addHosts(line)

    
#Cleanup
buildFile.close()
os.remove(buildFileName)