if [ $(tabgrep $1 2> /dev/null | wc -l) -gt 0 ]; then
	echo "$1 exists.  Exiting..."
	exit 0
fi
#!/usr/bin/python
# Import Block
import sys
from time import sleep
from subprocess import Popen, PIPE

def info(file,awkParam):
	p1=Popen(["ssh", "%s@%s" % (sshUser,sshHost), "grep", "%s" % node, "%s" % file],stdout=PIPE)
	p1.wait()
	p2 = Popen("awk " + awkParam, stdin=p1.stdout, stdout=PIPE, shell=True, universal_newlines=True)
	return p2.stdout.readlines()[0].rstrip('\n')


#Set Variables
sshUser = "root"
sshHost = "pm"
node = sys.argv[1]

mac = info("/opt/xcat/etc/mac.tab",r"'{print $2}'")
ip = info("/opt/xcat/etc/hosts",r"'{print $1}'")
model = info("/opt/xcat/etc/nodemodel.tab",r"'{print $2}'")

if (model == "DELL"):
	model = "dell,farm,all"
elif (model == "LS21") | (model == "LS20") | (model == "HS20"):
	model = "ibm,farm,all"
elif (model == "HP"):
	model = "hp,farm,all"
else:
	model = "farm,all"

Popen(["svnbuild", "nodeadd","%s" % node,"groups=%s" % model ,"mac.interface=eth0","hosts.ip=%s" % ip ,"mac.mac=%s" % mac\
	,"nodehm.mgt=ipmi","nodehm.power=ipmi"])
sleep(30)

p1=Popen(["makehosts","%s" % node],stdout=PIPE)
p1.wait()

p1=Popen(["makedhcp", "%s" % node])
p1.wait()
p2=Popen(["ssh","%s@%s" % (sshUser,sshHost), "makedhcp", "-d", "%s" % node])
p2.wait()
