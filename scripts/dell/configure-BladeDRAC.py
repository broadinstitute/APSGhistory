#!/usr/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

def setDHCP():
	optionList = []
	configList = []
	
	path = "/system1/sp1/enetport1/lanendpt1/ipendpt1"
	optionList.append("%s oemdell_usedhcp=1 committed=1" % path)

	path = "/system1/sp1/enetport1/lanendpt1/ipendpt1/dnsendpt1"
	optionList.append("%s oemdell_domainnamefromdhcp=1 oemdell_serversfromdhcp=1" % path)
	for optionItem in optionList:
		configList.append("set %s" % optionItem)

	for host in hosts:
		for configItem in configList:
			child = pexpect.spawn("ssh %s" % host)
			if debugMode:
				child.logfile = sys.stdout
			child.expect("root@%s's password:" % host)
			child.sendline("%s" % password)
			child.expect('->')
			child.sendline("%s" % configItem)
			child.expect("Connection to %s closed" % host) 
	
	return configList

def configAD():
	optionList = []
	configList = []
	
	path = "/system1/sp1/oemdell_adservice1"
	domain = "broad.mit.edu"
	domainController = "dracdc.broadinstitute.org"

	optionList.append("%s enablestate=1 oemdell_adrootdomain=%s oemdell_schematype=2 oemdell_adspecifyserverenable=1" % (path,domain))
	optionList.append("%s oemdell_addomaincontroller=%s oemdell_adglobalcatalog=%s" % (path,domainController,domainController))

	path = "/system1/sp1/group1"
	optionList.append("%s oemdell_groupname=DRACAdmin oemdell_groupdomain=%s oemdell_groupprivilege=0x1ff" % (path,domain))

	for optionItem in optionList:
		configList.append("set %s" % optionItem)
	
	for host in hosts:
		child = pexpect.spawn("ssh %s" % host)
		if debugMode:
			child.logfile = sys.stdout
		child.expect("root@%s's password:" % host)
		child.sendline("%s" % password)
		child.expect('->')
		for configItem in configList:
			child.sendline("%s" % configItem)
			child.expect('->')
		child.sendline("exit")
		child.expect(pexpect.EOF)

	return configList

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
hosts = argv[1].split(',')
password = getpass("Current Password:")
debugMode = True

configDict = {
	"setDHCP": setDHCP,
	"configAD": configAD,
#	"deploy": deploy,
	"setNetSvcs": setNetSvcs}

configList = configDict.get(configArg)()

for host in argv[1:]:
        child = pexpect.spawn("ssh %s" % host)
        if debugMode:
                child.logfile = sys.stdout
	child.expect("password:")
	child.sendline("%s" % password)
        child.expect('$')
        for configItem in configList:
                child.sendline("racadm %s" % configItem)
        child.expect('$')
        child.sendline("exit")
        child.expect(pexpect.EOF)
        argv.pop(1)
