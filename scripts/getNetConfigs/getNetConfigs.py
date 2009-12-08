#!/usr/bin/python
###Import Block###
from getpass import getpass,getuser
from time import sleep
from os import path
from sys import exit
from datetime import datetime
from subprocess import *

import logging

###Function for Config Import###
def get_config(list,cmd,user_pass,en_pass,ip):
	username="admin"
	for item in list:
		if not path.exists("%s/%s" % (smb_rdir,item)):
			p=Popen([cmd, item, user_pass, en_pass, username,ip], stdin=None, stdout=PIPE)
			p.stdout.close()
			p.wait()

			if path.exists("%s/%s" % (basedir,item)):
				p=Popen(["mv", "%s/%s" % (basedir,item), "%s" % smb_rdir])
				p.wait()
				if path.exists("%s/%s" % (smb_rdir,item)):
					logging.info("%s remote transfer complete\n" % item)
				else:
					logging.error("%s remote transfer failed\n" % item)
			else:
				logging.error("%s local download failed" % item)


		else:
			logging.warning("%s/%s already exists...skipping" % (smb_rdir,item))
###End Functions###


###Set TFTP IP###
tftpIP="69.173.115.212"

###Get YYYYMMDD date and establish local basedir###
now = datetime.now()
date = now.strftime("%Y%m%d")
tftpdir= "/tftpboot/"
basedir = tftpdir + date

###Configure Samba###
#smb_user = getuser()
smb_user = "ali"  ##User hard-coded for non-NIS environment.  Useless without password anyway.
smb_dom = "charles"
smb_password = getpass("Please enter your Active Directory password:")
smb_share = "//oxygen/systems/" #share
smb_mount = "/mnt/oxygen" #mount point
smb_rdir = smb_mount + "/Rescomp/%s" % date # location to place files

###Mount Share###
Popen(["mount", "-t", "cifs", "-o", "username=%s,domain=%s,password=%s" % (smb_user,smb_dom,smb_password), "%s" % smb_share, "%s" % smb_mount])

###Configure Logging###
LOG = "%s/runlog.txt" % smb_rdir
logging.basicConfig(filename=LOG,level=logging.INFO,filemode='w',format="%(asctime)s - %(levelname)s - %(message)s")

###Prompt for device passwords###
netdev_user_pass = getpass("Please enter device user password:")
netdev_en_pass = getpass("Please enter enable mode password:")
voipdev_en_pass = getpass("Please enter VOIP enable mode password:")
util_pass = getpass("Please enter util password:")

###Expect Scripts###
exp_path = "/root/bin/"
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

###Device List By OS###
##Cisco##
ios = ["7cc-1062-3",\
	"7cc-2062-3a",\
	"7cc-2062-3b",\
	"7cc-3062-3a",\
	"7cc-3062-3b",\
	"7cc-4062-3a",\
	"7cc-4062-3b",\
	"7cc-5062-3a",\
	"7cc-5062-3b",\
	"7cc-6062-3a",\
	"7cc-6062-3b",\
	"7cc-7062-3a",\
	"7cc-7062-3b",\
	"7cc-7091-3",\
	"7cc-7141-6",\
	"7cc-7141-a1-4948",\
	"7cc-7141-d5-4948",\
	"7cc-7141-e6-4948",\
	"7cc-7141-e12-4948",\
	"7cc-7141-f3-4948",\
	"320c-159-3a",\
	"320c-159-3b",\
	"320c-183-3",\
	"320c-1147-3a",\
	"320c-1147-3b",\
	"320c-1147-3c",\
	"320c-2102-6513",\
	"5cc-1330-3",\
	"190f-214-3750"]

fos = ["7cc-7141-5540a"]
nxos = ["5cc-1330-5010"]
voip = ["7cc-7141-n1-3a",\
	"7cc-7141-n1-3b",\
	"7cc-1062-voip",\
	"7cc-2062-voip",\
	"7cc-3062-voip",\
	"7cc-4062-voip",\
	"7cc-5062-voip",\
	"7cc-6062-voip",\
	"7cc-7062-voip",\
	"320c-2102-3",\
	"320c-159-voip",\
	"320c-183-voip",\
	"320c-1147-voip",\
	"5cc-1330-voip"]
iosxe = ["1sum-asr1006-v2"]

##Force10##
ftos = ["7cc-7141-c300",\
	"7cc-7141-a17-s50n",\
	"7cc-7141-d13-s50n",\
	"7cc-7141-f6-s50n",\
	"7cc-7141-f7-s50n",\
	"7cc-7141-n6-s50n",\
	"7cc-7141-n8-s50n",\
	"320c-2102-b2-s50n",\
	"5cc-1330-a2-s50n",\
	"5cc-1330-c2-s50n"]

sftos = ["7cc-7141-b3-s50n",\
	"7cc-7141-c8-s50n",\
	"7cc-7141-c10-s50n",\
	"7cc-7141-d4-s50n",\
	"7cc-7141-d11-s50n",\
	"7cc-7141-d14-s50n",\
	"7cc-7141-e13-s50n",\
	"7cc-7141-f2-s50n",\
	"7cc-7141-f11-s50n",\
	"7cc-7141-f13-s50n",\
	"320c-2102-a5-s50n"]


##Others##
ent = ["7cc-1038t-sw-1",\
	"7cc-2062t-sw-1",\
	"7cc-3062t-sw-1",\
	"7cc-4062t-sw-1",\
	"7cc-5062t-sw-1",\
	"7cc-6062t-sw-1",\
	"7cc-7062t-sw-1",\
	"320c-169t-sw-1",\
	"320c-1171t-sw-1"]

dell = ["bswitch50-build",\
	"bswitch50-main",\
	"bswitch51-build",\
	"bswitch51-main",\
	"bswitch52-build",\
	"bswitch52-main",\
	"bswitch53-build",\
	"bswitch53-main",\
	"bswitch54-build",\
	"bswitch54-main",\
	"bswitch55-build",\
	"bswitch55-main",\
	"bswitch56-build",\
	"bswitch56-main",\
	"bswitch57-build",\
	"bswitch57-main",\
	"bswitch58-build",\
	"bswitch58-main",\
	"bswitch59-build",\
	"bswitch59-main",\
	"bswitch60-build",\
	"bswitch60-main",\
	"bswitch61-build",\
	"bswitch61-main",\
	"bswitch62-build",\
	"bswitch62-main",\
	"bswitch63-build",\
	"bswitch63-main",\
	"bswitch64-build",\
	"bswitch64-main",\
	"bswitch65-build",\
	"bswitch65-main",\
	"bswitch66-build",\
	"bswitch66-main",\
	"bswitch67-build",\
	"bswitch67-main",\
	"bswitch68-build",\
	"bswitch68-main",\
	"bswitch69-build",\
	"bswitch69-main",\
	"bswitch70-build",\
	"bswitch70-main",\
	"bswitch71-build",\
	"bswitch71-main",\
	"bswitch72-build",\
	"bswitch72-main",\
	"bswitch73-build",\
	"bswitch73-main",\
	"bswitch74-build",\
	"bswitch74-main",\
	"bswitch75-build",\
	"bswitch75-main"]

###Create TFTP Path###
if not path.exists(basedir):
	Popen(["mkdir", basedir])
	Popen(["chown", "nobody", basedir])

###Create Remote Path###
if not path.exists(smb_rdir):
	Popen(["mkdir", smb_rdir])

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

Popen(["umount", "%s" % smb_mount])
