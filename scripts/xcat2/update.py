#!/usr/bin/env python
import re,sys
from subprocess import *
from threading import *
from tempfile import NamedTemporaryFile



def prepareHosts(ip,mac,host,groups,chassis,slot):
    if len(chassis)>0 and len(slot)>0:
        hostInfo="nodeadd {0} groups={1} mac.interface=eth0 hosts.ip={2} mac.mac={3} mp.mpa={4} mp.id={5}".format(host,groups,ip,mac,chassis,slot)
    else:
        hostInfo="nodeadd {0} groups={1} mac.interface=eth0 hosts.ip={2} mac.mac={3}".format(host,groups,ip,mac)

    tmpBhl.write("{0}|{1}|{2}|{3}|{4}|{5}|\n".format(ip,mac,host,groups,chassis,slot))

    host_thread=Thread(target=configureHosts, args=(hostInfo,))
    host_thread.start()
    host_thread.join()

def configureHosts(command):
    masterFile="/sysman/install/broad/master.host.listing"
    buildFile="/broad/tools/scripts/xcat2/build.host.listing"
    Popen(command.split(),stdout=PIPE,stderr=PIPE).communicate()
    
if __name__ == '__main__':
    masterFile="/sysman/install/broad/master.host.listing"
    buildFile="/broad/tools/scripts/xcat2/build.host.listing"
    bhlExists=True
    mhlList=[]
    buildList=[]
    tmpBhl=NamedTemporaryFile(delete=False)
    
    try:
        with open(buildFile) as f0:
            bhl=f0.readlines()
    except IOError:
        bhlExists=False

    try:
        with open(masterFile) as f1:
            mhl=f1.readlines()
    except IOError as e:
        print("({0})".format(e))

    if bhlExists == True:
        f = NamedTemporaryFile()
        for entry in mhl:
            if re.match("#xCAT#",entry):
                entry=entry.split()[1]
                f.write("{0}\n".format(entry))
        f.flush()

        command="diff --suppress-common-lines -y {0} {1}".format(f.name,buildFile)
        p1=Popen(command.split(),stdout=PIPE).communicate()[0]

        for entry in p1.split('\n'):
            if len(entry)>0:
                buildList.append(entry.split()[0])

            if len(buildList)==0:
               sys.exit(0)
            else:
                for entry in buildList:
                    fields=entry.split('|')
                    #if len(chassis)>0 and len(slot)>0:
                    (ip,mac,host,groups,chassis,slot)=fields[0:6]
                     #   print(host)
                    #else:
                     #   (ip,mac,host,groups)=fields
                     #   print(host)

                    Popen(['noderm',host],stdout=PIPE,stderr=PIPE).communicate()

                    if len(chassis)>0 and len(slot)>0:
                        prepareHosts(ip,mac,host,groups,chassis,slot)
                    else:
                        prepareHosts(ip,mac,host,groups,"","")
                    

    elif bhlExists == False:
        for entry in mhl:
            if re.match("#xCAT#",entry):
                mhlList.append(entry)

        Popen(['noderm', 'all'],stdout=None)

        for entry in mhlList:
            fields=entry.split()[1].split('|')
            #print(fields)
            (ip,mac,host,groups,chassis,slot,extra)=fields

            if len(chassis)>0 and len(slot)>0:
                prepareHosts(ip,mac,host,groups,chassis,slot)
            else:
                prepareHosts(ip,mac,host,groups,"","")


    print("{0} {1}\n".format(tmpBhl.name,buildFile))
    try:
        Popen("mv {0} {1}".format(tmpBhl.name,buildFile),shell=True)
    except IOError as e:
        print("({0})".format(e))
    except OSError as e:
        print("({0})".format(e))

