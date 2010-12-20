import os
import sys
from parseOutput_v3 import Wrapper
from sql_Update_v3 import Updater

class Adder(Wrapper):

    def __init__(self):
        self.order = ['size', 'capacity', 'posOverhead', 'negOverhead', 'atime', 'ctime', 'mtime']

    def getOutput(self, folder, mountId):
        outputDict = dict()
        scans = os.listdir(folder)
        if len(scans) != 0:
            for scan in scans:
                if scan.partition('-')[0].lstrip('scan') == str(mountId):
                    wrap = Wrapper()
                    update = Updater()
                    wrap.wrap(os.path.join(folder,scan))
                    #print wrap.map
                    dirid = scan.partition('-')[2].rstrip('.out')
                    update.writeToDB(int(mountId), int(dirid), wrap.map)
                    #print wrap.getDict() , '\n'
                    outputDict[scan.partition('-')[2].rstrip('.out')] = wrap.getDict()
            return outputDict                            
        else:
            print  "No scans were found in " + folder + ". Cannot calculate a total"


    def sumSubDirs(self, folder, mountId):
        totals = dict()
        output = self.getOutput(folder,mountId)
        for dirId in output:
            for mainKey in output[dirId]:
                #print mainKey
                subTotals = dict()
                #print subTotals
                if mainKey != 'Directories' and mainKey != 'Runtime':
                    if output[dirId][mainKey] != {}:
                        for userId in output[dirId][mainKey]:
                            #print userId
                            for category in self.order:
                                weighted = long(output[dirId][mainKey][userId][category][0])
                                count = long(output[dirId][mainKey][userId][category][1])
                                if category not in subTotals:
                                    subTotals[category] = [weighted,count]
                                else:
                                    subTotals[category][0] += weighted
                                    subTotals[category][1] += count
                        #print subTotals, '\n'
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
        #print totals
        return totals

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

    def combineSums(self,sumSubDir, topSumSubDir):
        sumSubDir.update(topSumSubDir)
        return sumSubDir
        
                
                            
                
            

'''if __name__ == '__main__':
    adder = Adder()
    subDirTotal = adder.sumSubDirs(sys.argv[1],sys.argv[2])
    print subDirTotal
    print ''
    print adder.overallSum(subDirTotal)'''
