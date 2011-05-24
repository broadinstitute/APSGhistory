#!/usr/bin/env python
import sys,re, socket
from subprocess import *
#
#Variables
##Lists
cmdList=[]
usage="Usage: %s HOST TREE_NAME COMMUNITY TEMPLATE" % sys.argv[0]
treeError="Something is wrong with tree. Does not compute."
apiPath="/var/lib/cacti/cli"
phpCmd="php -q %s" % apiPath
args=5
count=0
hostTemplateIDCmd="%s/add_device.php --list-host-templates" % phpCmd
hostIDCmd="%s/add_tree.php --list-hosts" % phpCmd
treeIDCmd="%s/add_tree.php --list-trees" % phpCmd

#Functions
def id(cmd,search):
	p=Popen(cmd.split(),stdout=PIPE).communicate()[0]
	for line in p.split('\n'):
		if re.search(search.lower(),line.lower()): return line.split()[0]

# Confirm proper usage
if len(sys.argv) != args:
	try:
		raise ValueError
	except ValueError:
		print(usage)
		sys.exit(1)

# Shall we begin?
(host,tree,cstring,hostTemplate)=sys.argv[1:5]
gaiError="%s: [Errno -2] Name or service not known" % host

try:
	hostIP=socket.gethostbyname(host)
except socket.gaierror:
	print gaiError
	sys.exit(1)
	
#model /broad/tools/scripts/cacti/addCactiDevice.sh pilsner centos pzCuQMLd ucd
hostTemplateID=id(hostTemplateIDCmd,hostTemplate)
treeID=id(treeIDCmd,tree)

nodeListCmd="%s/add_tree.php --list-nodes --tree-id=%s" % (phpCmd,treeID)

nodeAddCmd="%s/add_device.php --description=%s --ip=%s.broadinstitute.org --template=%s --community=%s --ping_method=udp" % (phpCmd,host,host,hostTemplateID,cstring)

(pout,perr)=Popen(nodeAddCmd.split(),stdout=PIPE).communicate()
if perr:
	print("%s\n\t%s" % (pout,perr))
else:
	print(pout)

hostID=id(hostIDCmd,host)

if treeID:
	p=Popen(nodeListCmd.split(),stdout=PIPE).communicate()[0]
	for line in p.split('\n'):
		if re.search(host,line):
			count = 1
	if count == 0:
		cmdList.append("%s/add_tree.php --type=node --node-type=host --host-id=%s --tree-id=%s" % (phpCmd,hostID,treeID))
	else:
		print "skipping add_tree for %s.  Already exists in tree, and Cacti is stupid." % host
else:
	try:
		raise NameError
	except NameError:
		print(treeError)
		sys.exit(1)

#Add Graphs
cmdList.append("%s/add_graphs.php --host-id=%s --graph-type=cg --graph-template-id=4" % (phpCmd,hostID))
cmdList.append("%s/add_graphs.php --host-id=%s --graph-type=cg --graph-template-id=11" % (phpCmd,hostID))
cmdList.append("%s/add_graphs.php --host-id=%s --graph-type=cg --graph-template-id=43" % (phpCmd,hostID))
cmdList.append("%s/add_graphs.php --graph-type=ds --host-id=%s --graph-template-id=35 --snmp-query-id=1 --snmp-field=ifIP --snmp-query-type-id=13 --snmp-value=%s --graph-title=\"%s--Traffic\"" % (phpCmd,hostID,hostIP,host))

for cmd in cmdList:
	(pout,perr)=Popen(cmd.split(),stdout=PIPE).communicate()
	if perr:
		print("%s\n\t%s" % (pout,perr))
	else:
		print(pout)
