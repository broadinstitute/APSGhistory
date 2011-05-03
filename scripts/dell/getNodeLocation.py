#!/usr/bin/env python
import sys,os

ssh_lib_path = '/broad/tools/scripts'
ofile_path='/sysman/scratch/cfengine3'
destination = open('%s/nodepostmp.csv' % ofile_path, 'w')
destination.write("#node,rack,u,chassis,slot,room,comments,disable\n")

sys.path.append(ssh_lib_path)
import ssh

#for cmcNum in range(50,93):
for cmcNum in range(83,93):
	cmc = "brsa%s" % cmcNum

	#try:
	s = ssh.Connection(cmc,'service')
	output = s.execute('getslotname')
	s.close()

	for item in output:
		fields=item.split()
		if not 2 <= len(fields) <= 3: continue
		slot=fields[0]
		if len(fields)==2: hostname=fields[1]
		elif len(fields)==3: hostname=fields[2]
		if (
			'Slot' in hostname or
			'SLOT' in hostname or
			'node1493' in hostname
		   ): continue
		
		#print("{0}|{1}|{2:02d}|".format(hostname,cmc,int(slot)))
		destination.write("{0},,,{1},{2:02d},,\n".format(hostname,cmc,int(slot)))
		
	#except Exception:
	#	continue

os.remove('%s/ssh.pyc' % ssh_lib_path)
