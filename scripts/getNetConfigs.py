#!/usr/bin/python
###Import Block###
from getpass import getpass,getuser
from os import path
from sys import exit
from datetime import datetime
from subprocess import *


###Function for Config Import###
def get_config(list,cmd):
	for item in list:
		p=Popen([cmd, item], stdin=None, stdout=PIPE)
		p.stdout.close()

		if path.isfile(basedir + "/%s" % item):
			print("%s completed successfully\n" % item)
			if not path.isfile("%s/%s" % (smb_rdir,item)):
				Popen(["cp", "%s/%s" % (basedir,item), "%s" % smb_rdir])
				if path.isfile("%s/%s" % (smb_rdir,item)):
					print("%s completed successfully\n" % item)
				else:
					print("%s copy failed\n" % item)
			else:
				print("File Already Copied\n")
###End Functions###




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

###Expect Scripts###
ios_cmd = "/root/bin/getIOS.exp"
ftos_cmd = "/root/bin/getFTOS.exp"

###Device List By OS###
##Cisco##
ios = ["7cc-7141-a1-4948"]
pix = ["7cc-7141-5540a"]
nxos = ["5cc-1330-5010"]

##Force10##
ftos = ["7cc-7141-a17-s50n"]
sftos = ["7cc-7141-b3-s50n"]

###Create TFTP Path###
if not path.exists(basedir):
	Popen(["mkdir", basedir])
	Popen(["chown", "nobody", basedir])

###Create Remote Path###
if not path.exists(smb_rdir):
	Popen(["mkdir", smb_rdir])

###Config Import###
get_config(ios,ios_cmd)
get_config(ftos,ftos_cmd)
