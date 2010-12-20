import sys
import os
import stat
import time
import subprocess
import MySQLdb
from makeStats_v2 import Statter
from assignBins_v4 import Binner
import os
from parseOutput_v3 import Wrapper
from walkSystem_v21 import Walker
from addOutputs_v5 import Adder
from sql_Update_v3 import Updater

sys.setrecursionlimit(1500)


def processOut(notify, topOuts):
    for notify in notifyList:
        addup = Adder()
        parse = Wrapper()
        totalUpdate = Updater()
        subDict = addup.sumSubDirs('/broad/shptmp/alvarado',int(notify.split('-')[1].rstrip('.txt')))
        output = topOuts[int(notify.split('-')[1].rstrip('.txt'))]
        topDict = parse.assembleTopScan(output[0],output[1],output[2],output[3])
        combinedDict = addup.combineSums(subDict,topDict)
        totalUpdate.writeDirTotals(int(notify.split('-')[1].rstrip('.txt')),combinedDict)
        total = addup.overallSum(combinedDict)
        totalUpdate.writeTotals(int(notify.split('-')[1].rstrip('.txt')),total)

def waiting(path,notifyList, topOuts):
    if notifyList == []:
        return True
    else:
        files = os.listdir(path)
        for notify in files:
            if notify in notifyList:
                processOut(notify, topOuts)
                notifyList.remove(notify)
        return False
       
        

def unpackOutput(outputList):
    unpacked = {'Users':dict(),'Extentions':dict(),'Directories':dict(),'Runtime':float()}
    for keys in outputList[0]:
        tempDict = outputList[0][keys].binsRef
        del tempDict['links']
        unpacked['Users'][keys] = tempDict
    for keys in outputList[1]:
        tempDict = outputList[0][keys].binsRef
        del tempDict['links']
        unpacked['Extentions'][keys] = tempDict
    for keys in outputList[2]:
        unpacked['Directories'][keys] = dict()
        unpacked['Directories'][keys]['links'] = outputList[2][keys].binsRef['links']
    unpacked['Runtime'] = outputList[3]
    #print unpacked
    return unpacked


if __name__ == '__main__':
        topOuts = dict()
        notifyList = list()
        walk = Walker()
        filesystems = walk.dbQuery("SELECT * FROM filesystem WHERE mount = '/seq/software' AND deprecated = 0")
        pipe = subprocess.Popen('bkill 0',shell = True,stdout=subprocess.PIPE)
        for filesystem in filesystems:
            print filesystem
            walk = Walker()
            update = Updater()
            output = walk.statWalk('walkSystem_final2.py',filesystem[1])
            topOuts[filesystem[0]] = output
            unpackedDict = unpackOutput(output)         
            update.writeToDB(filesystem[0], 0 , unpackedDict)            
            notify = '/broad/shptmp/alvarado/notify/notify-'+str(filesystem[0])+'.txt'
            notifyList.append(os.path.split(notify)[1])
            scan = 'scan'+str(filesystem[0])+'*'
            pipe = subprocess.Popen('bsub -P crawler -q priority -w "ended(%s)" -o %s date' % (scan,notify) ,shell = True,stdout=subprocess.PIPE)
            status = False
        while status == False:
            status = waiting('/broad/shptmp/alvarado/notify',notifyList,topOuts)
