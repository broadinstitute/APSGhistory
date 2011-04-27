#!/usr/bin/python
import sys,os

ssh_lib_path = '/broad/tools/scripts'
ofile_path='/tmp'
destination = open('%s/nodepos.csv' % ofile_path, 'w')
destination.write("#node,rack,u,chassis,slot,room,comments,disable\n")

sys.path.append(ssh_lib_path)
import ssh

for cmcNum in range(50,93):
	cmc = "brsa%s" % cmcNum

	#try:
	s = ssh.Connection(cmc,'service')
	output = s.execute('getslotname')
	s.close()

	for item in output:
		if 'Slot' in item or 'SLOT' in item: continue
		fields=item.split()
		slot=fields[0]
		if len(fields)==2: hostname=fields[1]
		elif len(fields)==3: hostname=fields[2]
		print("{0}|{1}|{2:02d}|".format(hostname,cmc,int(slot)))
		destination.write("{0},,,{1},{2:02d},,\n".format(hostname,cmc,int(slot)))
		
	#except Exception:
	#	continue

os.remove('%s/ssh.pyc' % ssh_lib_path)
