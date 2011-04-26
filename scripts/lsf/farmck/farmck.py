#!/usr/bin/env python
import os,sys
from os import putenv,getenv,environ
from optparse import OptionParser
from subprocess import *
import re

#Environment
environ['LSF_ENVDIR']="/broad/lsf/conf"
environ['LSF_SERVERDIR']='/broad/lsf/7.0/linux2.6-glibc2.3-x86_64/etc'
environ['LSF_LIBDIR']='/broad/lsf/7.0/linux2.6-glibc2.3-x86_64/lib'

#Commands
bhosts='/broad/lsf/7.0/linux2.6-glibc2.3-x86_64/bin/bhosts'
bjobs='/broad/lsf/7.0/linux2.6-glibc2.3-x86_64/bin/bjobs'
farmck='/home/radon00/ali/code/dev/farmck/farmck'
closed="{0} -c".format(farmck)
stalled_cmd="%s -w | awk \'NR==1{print}$5>0&&$6==0{print}\'" % bhosts

#Begin Parser
parser=OptionParser()

parser.add_option('-a', action='store_false', dest='verbose', default=False, help='Run all functions')
parser.add_option('-c', action='store_false', dest='verbose', default=False, help='Check for closed hosts')
parser.add_option('-s', action='store_false', dest='verbose', default=False, help='Check for stalled hosts')
parser.add_option('-u', action='store_false', dest='verbose', default=False, help='Check for wedged hosts')
(options, args) = parser.parse_args()
#End Parser

#String Variables

class Ddict(dict):
    def __init__(self, default=None):
        self.default = default

    def __getitem__(self, key):
        if not self.has_key(key):
            self[key] = self.default()
        return dict.__getitem__(self, key)

def all ():
    stalled()
    wedged()
    closed()


def closed ():
    closed=Popen([farmck,'-c'],stdout=PIPE).stdout
    closedDict=Ddict(dict)
    
    for host in closed:
            fields=host.lower().rstrip('\n').split('|')
#            if fields[1]=='closed_LIM':
#                key=fields.pop(1)
#            else:
            status=fields.pop(1)
            comment=fields.pop(1).lower()
            if closedDict[status].has_key(comment):
                closedDict[status][comment].append(fields)
            else:
                closedDict[status][comment]=[fields]
    
    for key in closedDict.keys():
        print("{0}".format(key))
        for entry in sorted(closedDict[key].keys()):
            if entry!='""' and len(entry)!=0: print(entry)
            #print(closedDict[key][entry])
            for list_entry in closedDict[key][entry]:
                fields=list_entry
                (hostName,njobs,nrun,nssusp,nususp,nrsv)=fields
                pingOut=Popen(["nmap","-sP","-PU","-T5","{0}".format(hostName) ], stdout=PIPE, stderr=None).stdout
                if "1 host up" not in pingOut:
                    pingStatus="{0} is not pingable".format(hostName)
                print("{0}".format(hostName))
                if len(pingStatus)==0: print("{0}\n".format(pingStatus))
                print("\t{0} {1} {2} {3} {4}".format(njobs,nrun,nssusp,nususp,nrsv))
            print("")
    
def stalled ():
    hostList=""
    hostTemp=[]
    hosts=Popen([farmck,'-s'], shell=True, stdout=PIPE).communicate()[0].split('\n')
    if len(hosts)<=1: 
        print("No stalled hosts.")
    for host in hosts:
        print("{0}".format(host))

def wedged ():
    wedged=Popen([farmck,'-u'], stdout=PIPE).communicate()[0].split('\n')
    wedgedDict=Ddict(dict)
    fields=[]
    i=0

    for line in wedged:
        fields=re.split('\s+',line) 

        if "Job" not in fields[0]: continue
        host=fields[5]
	time=fields[11] 

        if wedgedDict[host].has_key('when'):
            if wedgedDict[host]['when'] < time:
                wedgedDict[host]['when'] = wedgedDict[host]['when']
            else:
                wedgedDict[host]['when'] = time
            wedgedDict[host]['count'] += 1
        else:
	    wedgedDict[host]['when'] = time
            wedgedDict[host]['count'] = 1
        i += 1

    if i > 0:
        keys=sorted(wedgedDict.keys())
        for host in keys:
            print "%s apparently wedged %s hours ago.  There are nominally %s jobs running." \
                % (host,wedgedDict[host]['when'],wedgedDict[host]['count'])
    else:
        print "There are no wedged hosts.\n"
    
    print("")

args = {
    '-a': lambda : all(),
    '-c': lambda : closed(),
    '-s': lambda : stalled(),
    '-u': lambda : wedged()
}[sys.argv[1]]()

