#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import os
import sys
from parseOutput import Wrapper
from sql_Update import Updater

#class used to add up .out files from LSF
class Adder(Wrapper):

    def __init__(self):
        self.order = ['size', 'capacity', 'posOverhead', 'negOverhead', 'atime', 'ctime', 'mtime']

    #Return an output dictonary from all of the .out files written by LSF for a particular file system
    #Use the Wrapper class to wrap up output for individual scans. Also updates the database with the output
    def getOutput(self, folder, mountId):
        outputDict = dict()
        scans = os.listdir(folder)
        if len(scans) != 0:
            for scan in scans:
                if scan.partition('-')[0].lstrip('scan') == str(mountId):
                    sys.stdout.write(scan)
                    sys.stdout.write('\n')
                    wrap = Wrapper()
                    update = Updater()
                    #scan the "scan" file 
                    wrap.wrap(os.path.join(folder,scan))
                    dirid = scan.partition('-')[2].rstrip('.out')
                    update.writeToDB(int(mountId), int(dirid), wrap.map)
                    #get the dictonary for each file from the parser and add it to the output
                    outputDict[scan.partition('-')[2].rstrip('.out')] = wrap.getDict()
            return outputDict                            
        else:
            print  "No scans were found in " + folder + ". Cannot calculate a total"


    #Function which get the overall output from getOutput and extracts the totals from it
    #It then assembles a dictonary with all the directory totals
    def sumSubDirs(self, folder, mountId):
        totals = dict()
        #call getOutput
        output = self.getOutput(folder,mountId)
        for dirId in output:
            for mainKey in output[dirId]:
                subTotals = dict()
                if mainKey != 'Directories' and mainKey != 'Runtime':
                    if output[dirId][mainKey] != {}:
                        for userId in output[dirId][mainKey]:
                            for category in self.order:
                                weighted = long(output[dirId][mainKey][userId][category][0])
                                count = long(output[dirId][mainKey][userId][category][1])
                                if category not in subTotals:
                                    subTotals[category] = [weighted,count]
                                else:
                                    subTotals[category][0] += weighted
                                    subTotals[category][1] += count
                        if dirId not in totals:    
                            totals[dirId] =  {mainKey:subTotals}
                        else:
                            totals[dirId][mainKey] = subTotals
                elif mainKey == 'Directories':
                    if output[dirId][mainKey] != {}:
                        for userId in output[dirId][mainKey]:
                            for category in ['links']:
                                weighted = float(output[dirId][mainKey][userId][category][0])
                                count = float(output[dirId][mainKey][userId][category][1])
                                if category not in subTotals:
                                    subTotals[category] = [weighted,count]
                                else:
                                    subTotals[category][0] += weighted
                                    subTotals[category][1] += count
                        if dirId not in totals:    
                            totals[dirId] =  {mainKey:subTotals}
                        else:
                            totals[dirId][mainKey] = subTotals
                elif mainKey == 'Runtime':
                    if dirId not in totals:
                        totals[dirId] = {mainKey:output[dirId][mainKey]}
                    else:
                        totals[dirId][mainKey] = output[dirId][mainKey]
        return totals

    #Takes the dictonary of directory totals and returns an overall sum for all the statistics for the whole file system
    def overallSum(self, subDirTotal):
        total = dict()
        for dirId in subDirTotal:
            for mainKey in subDirTotal[dirId]:
                if mainKey != 'Runtime':
                    if mainKey not in total:
                        total[mainKey] = dict()
                    if mainKey != 'Directories':
                        if len(subDirTotal[dirId][mainKey].keys()) != 0: 
                            for category in self.order:
                                weighted = long(subDirTotal[dirId][mainKey][category][0])
                                count = long(subDirTotal[dirId][mainKey][category][1])
                                if category not in total[mainKey]:
                                    total[mainKey][category] = [weighted,count]
                                else:
                                    total[mainKey][category][0] += weighted
                                    total[mainKey][category][1] += count
                    else:
                        for category in ['links']:
                            weighted = float(subDirTotal[dirId][mainKey][category][0])
                            count = float(subDirTotal[dirId][mainKey][category][1])
                            if category not in total[mainKey]:
                                total[mainKey][category] = [weighted,count]
                            else:
                                total[mainKey][category][0] += weighted
                                total[mainKey][category][1] += count
                        
        return total

    #NOT USED ANYMORE
    #Method used to combine the statistics from the top level directory with the statistics from the all other subdirectories
    #Returns a dictonary with all the statistics combined
    def combineSums(self,sumSubDir, topSumSubDir):
        sumSubDir.update(topSumSubDir)
        return sumSubDir
        
                
                            
                
            

'''if __name__ == '__main__':
    adder = Adder()
    subDirTotal = adder.sumSubDirs(sys.argv[1],sys.argv[2])
    print subDirTotal
    print ''
    print adder.overallSum(subDirTotal)'''
