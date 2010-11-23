#!/usr/bin/python
# $Id$
import sys,subprocess,string,os,shutil,glob

ssh_lib_path = '/broad/tools/scripts'
sys.path.append(ssh_lib_path)
import ssh

ofile_path = '/tmp/nodepos'

for cmcNum in range(50,90):
	cmc = "brsa%s" % cmcNum
	try:
		tempFile = '%s/temp-%s' % (ofile_path,cmc)
		file = open (tempFile, 'w')
		s = ssh.Connection(cmc,'service')
		output = s.execute('getslotname')
		s.close()
		for item in output:
			item = item.rstrip()
			itemList = item.split()

			if "Host" not in item and len(itemList) < 4:
				if len(itemList) == 3:
					file.write('"%s",,,"%s","%s",,,\n' %(itemList[2],cmc,itemList[0]))
	except Exception:
		file.close()
		os.remove(tempFile)
		continue
	else:
		file.close()
		file = '%s/%s'  % (ofile_path,cmc)
		shutil.move(tempFile,file)

os.remove('%s/ssh.pyc' % ssh_lib_path)

destination = open('%s/nodepos.csv' % ofile_path, 'w')
for filename in glob.glob(os.path.join(ofile_path, 'brsa*')):
    shutil.copyfileobj(open(filename, 'r'), destination)
destination.close()

file = open('%s/nodepos.csv' % ofile_path, 'r')
lines = file.readlines()
file.close()
ofile = open('%s/nodepos.csv' % ofile_path, 'w')
ofile.write("#node,rack,u,chassis,slot,room,comments,disable\n")
for line in sorted(lines, key = str.lower):
        ofile.write(line)
ofile.close()
