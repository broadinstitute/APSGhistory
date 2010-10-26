#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit

def setDHCP():
	configList = []
	groupName="cfgLanNetworking"

	configList.append("config -g %s -o cfgNicUseDhcp 1" % groupName)
	configList.append("config -g %s -o cfgDNSServersFromDHCP 1" % groupName)
	configList.append("config -g %s -o cfgDNSDomainNameFromDHCP 1" % groupName)
	
	return configList

def deploy():
	return ["deploy -a -u root -p %s -d" % password]

def setNetSvcs():
	configList = []
	groupName="cfgRemoteHosts"
	smtpAddr="smtp"
	ntpAddr1="ntp1"
	ntpAddr2="ntp2"
	ntpAddr3="ntp0"
	syslogAddr="glutamine"
	configList.append("config -g %s -o cfgRhostsSmtpServerIpAddr %s" % (groupName,smtpAddr))
	configList.append("config -g %s -o cfgRhostsNtpEnable 1" % groupName)
	configList.append("config -g %s -o cfgRhostsNtpServer1 %s" % (groupName,ntpAddr1))
	configList.append("config -g %s -o cfgRhostsNtpServer2 %s" % (groupName,ntpAddr2))
	configList.append("config -g %s -o cfgRhostsNtpServer3 %s" % (groupName,ntpAddr3))
	configList.append("config -g %s -o cfgRhostsSyslogEnable 1" % groupName)
	configList.append("config -g %s -o cfgRhostsSyslogServer1 %s" % (groupName,syslogAddr))
	
	return configList

configArg = argv.pop(1)
debugMode = True

configDict = {
	"setDHCP": setDHCP,
	"deploy": deploy,
	"setNetSvcs": setNetSvcs}

configList = configDict.get(configArg)()
for host in argv[1:]:
	child = pexpect.spawn("ssh service@%s" % host)
	if debugMode:
		child.logfile = sys.stdout
	child.expect('$')
	for configItem in configList:
		child.sendline("racadm %s" % configItem)
	child.expect('$')
	child.sendline("exit")
	child.expect(pexpect.EOF)
	argv.pop(1)
