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

#function which runs the adder methods which add up output from LSF
#Also updates those totals to the corresponding databaset tables
def processOut(fsid, saveLocation):
    addup = Adder()
    parse = Wrapper()
    totalUpdate = Updater()
    subDict = addup.sumSubDirs(saveLocation,fsid)
    totalUpdate.writeDirTotals(fsid,subDict)
    total = addup.overallSum(subDict)
    totalUpdate.writeTotals(fsid,total)


#Run when filesystme scan is done
#Takes one argument: fsid of completed scan
if __name__ == '__main__':
    configData = Config()
    saveLocations = configData.getWriteLocations()
    fsid = int(sys.argv[1])
    processOut(fsid,saveLocations["saveto"])
