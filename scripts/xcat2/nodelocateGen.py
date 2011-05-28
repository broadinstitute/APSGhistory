#!/bin/env python
# $Id$
import sys,string,os,shutil,glob
from subprocess import *

ssh_lib_path = '/broad/tools/scripts'
sys.path.append(ssh_lib_path)
import ssh

ofile_path = '/tmp'
ofile="{0}/nodepos.csv".format(ofile_path)
outDict = {}
nodeposBody=""

for cmcNum in range(50,93):
	cmc = "brsa{0}".format(cmcNum)
	try:
		s = ssh.Connection(cmc,'service')
		output = s.execute('getslotname')
		s.close()
		
		outDict[cmc]=[]
		for item in output:
			outDict[cmc].append(item)

	except Exception as e:
		print("{0} Failed with Exception {1}".format(cmc,e)) 
		continue


os.remove('%s/ssh.pyc' % ssh_lib_path)
for key in sorted(outDict.keys()):
	for entry in outDict[key]:
		if "Host" in entry: continue
		itemList=entry.split()
		if len(itemList)==2: host=itemList[1]
		if len(itemList)==3: host=itemList[2]
		else: continue
		if 'SLOT' in host: continue
		slot=itemList[0]
		nodeposBody=("{0}\n\"{1}\",,,\"{2}\",\"{3:02d}\",,".format(nodeposBody,host,key,int(slot)))
		
nodeposHead="#node,rack,u,chassis,slot,room,comments,disable"


FILE=open(ofile,'w')
FILE.write(nodeposBody)
FILE.close()

FILE=open(ofile,'r')
lines=FILE.readlines()
FILE.close()

FILE=open(ofile,'w')
FILE.write("{0}".format(nodeposHead))
for line in sorted(lines, key=str.lower):
	FILE.write(line)
FILE.close()



#Popen(["tabrestore",'%s/nodepos.csv' % ofile_path],stdin=None,stdout=open('/dev/null','w'),stderr=open('/dev/null','w'))
#Popen(["tabrestore",'%s/nodepos.csv' % ofile_path])

#os.remove('%s/nodepos.csv' % ofile_path)
