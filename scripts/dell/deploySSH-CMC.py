#!/usr/local/bin/python
import pexpect
import sys
from sys import argv,exit
from getpass import getpass

hosts = argv[1].split(',')
password = getpass("Password:")
debugMode = True

configList=[]
	
#TRP key - Index 1, full auth
configList.append('sshpkauth -i svcacct -k 1 -p0xfff -t "ssh-dss AAAAB3NzaC1kc3MAAACBAMdPwPbhgProKuYZZLUVRGrVoJYsWoR0Vyd+MGvv7HWngBvNLQ4i3CoixE34wpWhdS/jCX/nYkKWlt+AsENOUrxpmE/uMTp18If6gx8PPxZQkoz7sDQ85ICpeo2HS73jHVdvb2ssLdY3tj5Aqt7lqyMWVFNEF0Ub3S/Zrvx5pD4XAAAAFQDwUVkm5hx0Wc3TwpTfxFKdO40Y6wAAAIB2klA/DaHRZ8UNlcjdu7ie4xd8jaVtc3ZLLdxC4wM98AgCmj9MgwbNpxS8XdTrWgra+Tj+SuN9u6Z9WnC1shHiJYqMG0y3SJDYfgT654GpggeZxiFgmq9baFfr69F3GfXgkzC+nEqaXn5aLwr6QDb+slTKK3Ind7hX/LikzHLNrwAAAIAmRk7ROAMTgGYu7qUNMx1r4z4bJO9dQol/sYPcw5jmd+H1NUC1RQxcY798b0hHVtH04Thzb2EsJtxkz0HeTZkZSa3zptKYSR0XjiOgfcK2EcjNdt2rP9IRVDphUb3Tv7kxkYqEilqihf1LKqaMG4hJaTWCAODalHN9sZcH7TBYqQ== root@tryptophan.broad.mit.edu"')

#xcat2 key - Index 2, full auth
configList.append('sshpkauth -i svcacct -k 2 -p0xfff -t "ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAlTS7D6TAyIa4tw00LjBsQ7s6hYGWPW4OD9SQCHhlN95ISSPtXRCjcInY8m238fIrhNEm/3agFiqEFnbbCp9mwr6WDB3WhPCjBIgO6lpDDOVZyMH9bkUUus3suwCBcXWGwrUUaSzz2i/N4T9NRdjvOpE1NQZ3LSbMtpgDlEoSEp9Fm+SRb1j8iMdmBVkrOmr7wbE2QopUeM63KvZxSaO2qF4gK/ko9BAB79LIzQTqGItOTABN8qyT3ROEvKrOG1HqEATPFgjlY9LHg8HgUKNmO54A4DL0IMu4I0VRhqks0IfhaBVzmhd4lzTzpgipTP4XoGFLxB4UvdR6gwsb53FK4Q== root@xcat2.broadinstitute.org"')

for host in hosts:
	child = pexpect.spawn("ssh %s" % host)
	if debugMode:
		child.logfile = sys.stdout
	child.expect("root@%s.*'s password:" % host)
	child.sendline("%s" % password)
	child.expect('$')
	for configItem in configList:
		child.sendline("racadm %s" % configItem)
	child.expect('$')
	child.sendline("exit")
	child.expect(pexpect.EOF)
