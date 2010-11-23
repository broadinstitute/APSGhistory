#!/usr/bin/python
# $Id$
import sys,subprocess,string,os,shutil

sys.path.append('/broad/tools/scripts/')
import ssh

for cmcNum in range(50,90):
	cmc = "brsa%s" % cmcNum
	try:
		tempFile = '/tmp/nodepos/temp-%s' % cmc
		file = open (tempFile, 'w')
		s = ssh.Connection(cmc,'service')
		output = s.execute('getslotname')
		s.close()
		for item in output:
			item = item.rstrip()
			itemList = item.split()

			if "Host" not in item and len(itemList) < 4:
				if len(itemList) < 3:
					file.write('"%s",,,"%s","%s",,,' %(itemList[1],cmc,itemList[0]))
				else:
					file.write('"%s",,,"%s","%s",,,' %(itemList[2],cmc,itemList[0]))
	except Exception:
		file.close()
		os.remove(tempFile)
		continue
	else:
		file.close()
		file = '/tmp/nodepos/%s' % cmc
		shutil.move(tempFile,file)
