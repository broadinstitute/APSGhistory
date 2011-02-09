#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import sys
import os
import stat
import time
import subprocess
import os
import ast
from parseOutput import Wrapper
from addOutputs import Adder
from sql_Update import Updater
from config import Config

#Function which process all the .out files LSF wrote to a the saveto directory
def processOut(notify, saveLocation):
    for notify in notifyList:
        addup = Adder()
        parse = Wrapper()
        totalUpdate = Updater()
        print notify + '\n'
        subDict = addup.sumSubDirs(saveLocation,int(notify.split('-')[1].rstrip('.txt')))
        totalUpdate.writeDirTotals(int(notify.split('-')[1].rstrip('.txt')),subDict)
        total = addup.overallSum(subDict)
        totalUpdate.writeTotals(int(notify.split('-')[1].rstrip('.txt')),total)

#Remove the file that appeared from the notifylist
#Run processing function
def waiting(path,notifyList, saveLocation):
    if notifyList == []:
        return True
    else:
        files = os.listdir(path)
        for notify in files:
            if notify in notifyList:
                processOut(notify, saveLocation)
                notifyList.remove(notify)
        return False

if __name__ == '__main__':
    configData = Config()
    saveLocations = configData.getWriteLocations()
    notifyList = sys.argv[1].replace('[','').replace(']','').split(',')
    print notifyList
    status = False
    #wait untill one fo the files in notifyList appers in notify directory
    while status == False:
        status = waiting(saveLocations["notifyto"],notifyList, saveLocations["saveto"])
