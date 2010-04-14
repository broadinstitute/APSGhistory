#!/usr/bin/python
# Import Block
import sys
from subprocess import Popen, PIPE

def info(file,awkParam):
	p1=Popen(["ssh", "%s@%s" % (sshUser,sshHost), "grep", "%s" % node, "%s" % file],stdout=PIPE).wait()
	p2 = Popen("awk " + awkParam, stdin=p1.stdout, stdout=PIPE, shell=True, universal_newlines=True)
	return p2.stdout.readlines()[0].rstrip('\n')

def migrateDHCP(makeCmd):
	Popen=(["%s" % makeCmd, "%s" % node]).wait()
	Popen=(["ssh","%s@%s" % (sshUser,sshHost), "%s" % clearCmd, "-d", "%s" % node])

#Set Variables
sshUser = "root"
sshHost = "pm"
node = sys.argv[1]

mac = info("/opt/xcat/etc/mac.tab",r"'{print $2}'")
ip = info("/opt/xcat/etc/hosts",r"'{print $1}'")
model = info("/opt/xcat/etc/nodemodel.tab",r"'{print $2}'")

if (model == "DELL"):
	model = "dell,farm,all"
elif (model == "LS21") | (model == "LS20"):
	model = "ibm,farm,all"
elif model == "HS20":
	model = "ibm,farm.raid,all"
else:
	model = "all"

Popen(["svnbuild", "nodeadd","%s" % node,"groups=%s" % model ,"mac.interface=eth0","hosts.ip=%s" % ip ,"mac.mac=%s" % mac\
	,"nodehm.mgt=ipmi","nodehm.power=ipmi"]).wait()

migrateDHCP("makehosts")
migrateDHCP("makedhcp")
