#!/usr/bin/python
###Import Block###
from getpass import getpass,getuser
from time import sleep
from os import path,makedirs
from sys import exit
from datetime import datetime
from subprocess import *

import logging,string

###Function for Config Import###
def get_config(list,cmd,user_pass,en_pass,ip):
	username="admin"
	for item in list:
		if not path.exists("%s/%s" % (smb_rdir,item)):
			p=Popen([cmd, item, user_pass, en_pass, username,ip], stdin=None, stdout=PIPE)
			sleep(30)
			p.stdout.close()
			p.wait()

			if path.exists("%s/%s" % (basedir,item)):
				Popen(["cp", "%s/%s" % (basedir,item), "%s" % smb_rdir]).wait()
				Popen(["rm","-f", "%s/%s" % (basedir,item)]).wait()
				if path.exists("%s/%s" % (smb_rdir,item)):
					logging.info("%s remote transfer complete\n" % item)
					print("%s remote transfer complete\n" % item)
				else:
					logging.error("%s remote transfer failed\n" % item)
			else:
				logging.error("%s local download failed" % item)


		else:
			logging.warning("%s/%s already exists...skipping" % (smb_rdir,item))

def getDevices(model):
	FILE = "%s" % smb_mount + "/Networking/Switch, Router, & Firewall Configs/devicelist.txt"
#	FILE = "%s" % exp_path + "devicelist.txt"
        infile = open("%s" % FILE)
        result = []
        for line in infile:
                if string.find(line,'#') == -1:
                        fields = line.split(':')
                        if len(fields) >= 2:
                                name = fields[0].rstrip("\r\n")
                                type = fields[1].rstrip("\r\n")

                                if type.lower() == model:
                                        result.append(name)
        return result
###End Functions###


###Set TFTP IP###
tftpIP="69.173.67.37"

###Get YYYYMMDD date and establish local basedir###
now = datetime.now()
date = now.strftime("%Y%m%d")
tftpdir= "/tftpboot/"
basedir = tftpdir + date

###Configure Samba###
smb_user = getuser()
#smb_user = "ali"  ##User hard-coded for non-NIS environment.  Useless without password anyway.
smb_dom = "charles"
smb_password = getpass("Please enter your Active Directory password:")
smb_share = "//oxygen/systems/" #share
smb_mount = "/mnt/oxygen" #mount point
smb_rdir = smb_mount + "/Networking/Switch, Router, & Firewall Configs/%s" % date

###Mount Share###
Popen(["sudo","mount", "-t", "cifs", "-o", "username=%s,domain=%s,password=%s" % (smb_user,smb_dom,smb_password), "%s" % smb_share, "%s" % smb_mount])


###Prompt for device passwords###
netdev_user_pass = getpass("Please enter device user password:")
netdev_en_pass = getpass("Please enter enable mode password:")
voipdev_en_pass="password" ## Password left in file, as this one is not considered "secure" and is provided to vendor
util_pass = getpass("Please enter util password:")

###Expect Scripts###
exp_path = "/usr/local/bin/"
##Cisco##
ios_cmd = exp_path + "getIOS.exp"
fos_cmd = exp_path + "getFOS.exp"
nxos_cmd = exp_path + "getNXOS.exp"
iosxe_cmd = exp_path + "getIOSXE.exp"

##Force10##
ftos_cmd = exp_path + "getFTOS.exp"
sftos_cmd = exp_path + "getSFTOS.exp"

##Others##
ent_cmd = exp_path + "getEnt.exp"
dell_cmd = exp_path + "getDell.exp"
dellv2_cmd = exp_path + "getDellv2.exp"

###Device List By OS###
##Cisco
ios = getDevices("ios")
iosxe = getDevices("iosxe")
fos = getDevices("fos")
nxos = getDevices("nxos")
voip = getDevices("voip")

##Force10
sftos = getDevices("sftos")
ftos = getDevices("ftos")

##Enterasys
ent = getDevices("ent")

##Dell
dell = getDevices("dell")
dellv2 = getDevices("dellv2")

###Create TFTP Path###
if not path.exists(basedir):
	Popen(["mkdir", basedir])
	Popen(["sudo", "chown", "nobody", basedir])

###Create Remote Path###
if not path.exists(smb_rdir):
	makedirs(smb_rdir)

###Configure Logging###
LOG = "%s/runlog.txt" % smb_rdir
logging.basicConfig(filename=LOG,level=logging.INFO,filemode='w',format="%(asctime)s - %(levelname)s - %(message)s")

###Config Import###
##Cisco##
get_config(ios,ios_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
get_config(fos,fos_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
get_config(nxos,nxos_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
get_config(voip,ios_cmd,netdev_user_pass,voipdev_en_pass,tftpIP)
get_config(iosxe,iosxe_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
##Force10##
get_config(ftos,ftos_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
get_config(sftos,sftos_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
##Others##
get_config(ent,ent_cmd,netdev_user_pass,netdev_en_pass,tftpIP)
get_config(dell,dell_cmd,util_pass,netdev_en_pass,tftpIP)
get_config(dellv2,dellv2_cmd,util_pass,netdev_en_pass,tftpIP)
