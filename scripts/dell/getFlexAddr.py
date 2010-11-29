#!/usr/bin/python
# $Id$
import sys

ssh_lib_path = '/broad/tools/scripts'
sys.path.append(ssh_lib_path)
import ssh

for cmcNum in range(50,90):
	cmc = "brsa%s" % cmcNum
	print "\n"
	print cmc

	try:
		s = ssh.Connection(cmc,'service')
		output = s.execute('getflexaddr')
		s.close()

		for item in output:
			item = item.rstrip()
			if "enabled" not in item.lower():
				print item
	except Exception:
		continue

os.remove('%s/ssh.pyc' % ssh_lib_path)
