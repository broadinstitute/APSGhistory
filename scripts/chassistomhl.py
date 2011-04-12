#!/usr/bin/env python3
import random,sys,signal,re
from subprocess import *

def ipCorrect(ipType,ipList):
    if ipType == "prodIP" or ipType == "buildIP":
        if int(ipList[3]) == 255:
            ipList[2]=str(int(ipList[2])+1)
            ipList[3]="0"
            ip='.'.join(ipList)
        else:
            ipList[3]=str(int(ipList[3])+1)
            ip='.'.join(ipList)
    elif ipType == "racIP":
        if int(ipList[3]) == 0:
            ipList[2]=str(int(ipList[2])-1)
            ipList[3]="255"
            ip='.'.join(ipList)
        else:
            ipList[3]=str(int(ipList[3])-1)
            ip='.'.join(ipList)
    return ip

def returnIP(ipType,tmpIP):
    if ipType == "prodIP":
        prompt="""What is the starting IP address for the PRODUCTION interfaces? 
                  Example: 69.173.45.2 or 10.200.96.95 [{0}]""".format(tmpIP)
        pattern="(69\.173\.\d+\.\d+)|(10\.200\.(9[6-9]|10\d|111)\.\d+)"
    elif ipType == "buildIP":
        prompt="""What is the starting IP address for the BUILD interface?
                  Example: 192.168.32.200 [{0}]""".format(tmpIP)
        pattern="192\.168\.\d+\.\d+"
    elif ipType == "racIP":
        prompt="""What is the starting IP address for the RAC interface?
                  Example: 172.16.255.140 [{0}]
                  Remember the RAC IP addresses go from high to low""".format(tmpIP)
        pattern="172\.16\.\d+\.\d+"

    while True:
        try:
            if sys.version_info[0]==2:
                IP=raw_input("{0}\n".format(prompt))
            elif sys.version_info[0]==3:
                IP=input("{0}\n".format(prompt))

            if re.match(pattern,IP):
                break
            if len(IP)==0:
                IP=tmpIP
                break
        except ValueError:
            continue
        except KeyboardInterrupt:
            sys.exit(1)

    return IP
    
FILE='/sysman/install/broad/master.host.listing'
chassisName=sys.argv[1].replace('brsa','ufarm')
mhlList=[]
prodList=[]
buildList=[]
racList=[]
prodIP=""
buildIP=""
racIP=""

if (len(sys.argv) !=2):  
    print("Usage: chassistomhl.py <chassis_name>")
    
if not re.search("ufarm\d\d$",chassisName):
    print('Invalid Chassis')
    sys.exit(1)

while True:
    try: 
        nodeNumber=input('What is the starting node number?  Example: 1589\n')
        nodeNumber=int(nodeNumber)
        break
    except ValueError:
        continue
    except NameError:
        continue
    except KeyboardInterrupt:
        sys.exit(1)

mhl=open(FILE,'r')
for line in mhl:
    if "node{0}".format(nodeNumber) in line:
        mhlList.append(line)

for entry in mhlList:
    if re.search("10\.200\.(9[6-9]|10\d|111)\.\d+",entry)\
    or re.search("69\.173\.\d+\.\d+",entry):
        tmpProdIP=entry.lstrip('#').split('|')[0]
    elif re.search("192\.168\.\d+\.\d+",entry):
        tmpBuildIP=entry.split('|')[0].split()[1]
    elif re.search("172\.16\.\d+\.\d+",entry):
        tmpRacIP=entry.split('|')[0]

prodIP=returnIP("prodIP",tmpProdIP)
buildIP=returnIP("buildIP",tmpBuildIP)
racIP=returnIP("racIP",tmpRacIP)

cmcOutput=Popen(['ssh',"service@{0}".format(sys.argv[1]),'getmacaddress'],stdout=PIPE).communicate()[0]
if sys.version_info[0]==2:
    cmcOutput=str(cmcOutput).split('\n')
elif sys.version_info[0]==3:
    cmcOutput=str(cmcOutput,encoding='UTF-8').split('\n')

racSlot=1
for entry in cmcOutput:
    if re.match("Server-\d{0,1}",entry):
        entry=entry.lower()
        entryList=entry.split()
        entryList.pop(0)
        entryList.pop(0)
        (prodMac,buildMac,racMac)=entryList

        prodList.append("{0}|-|{1}|node{2}|-|unix_svr|g|runaround,linux,centos,centos-5,x86_64,7cc,nfshosts,{3}|dell blade".format(prodIP,prodMac,nodeNumber,chassisName))
        racList.append("{0}|-|{1}|node{2}-rac|-|dhcpdevice|g|-|dell remote access controller".format(racIP,racMac,nodeNumber))
        buildList.append("#xCAT# {0}|{1}|node{2}|dell,farm,all|||".format(buildIP,buildMac,nodeNumber))

	# Split out the IP address into an array

        prodIP=ipCorrect("prodIP",prodIP.split('.'))
        racIP=ipCorrect("racIP",racIP.split('.'))
        buildIP=ipCorrect("buildIP",buildIP.split('.'))
	
        nodeNumber += 1
        racSlot += 1

print("Production MHL Entries")
for entry in prodList:
    print(entry)

print("RAC MHL Entries")
for entry in reversed(racList):
    print(entry)

print("xCAT MHL Entries")
for entry in buildList:
    print(entry)
