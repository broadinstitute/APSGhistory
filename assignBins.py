#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu

class Binner():

    #binRef stores the statistic data 
    def __init__(self):
        self.instRef = {"size":list(), "capacity":list(), "posOverhead":list(),
                "negOverhead":list(), "atime":list(), "ctime":list(), "mtime":list(), "links":list()}
        self.binsRef = {"size":[dict(),dict()], "capacity":[dict(),dict()], "posOverhead":[dict(),dict()],
                "negOverhead":[dict(),dict()], "atime":[dict(),dict()], "ctime":[dict(),dict()],
                   "mtime":[dict(),dict()],"links":[dict(),dict()]}
        
    # set the instRef instance varable from Walker
    def setLim(self,limDict):
        for key in limDict.keys():
            self.instRef[key] = limDict[key]
        for key in ['posOverhead','negOverhead']:
            self.instRef[key] = self.instRef['size']
            

    #Method used to get the number of the bin the statistic should be placed in based
    #upon the limits set in the the 
    def getBinLocation(self, value, limit):
        tmpList = (limit + [value])
        tmpList.sort()
        return tmpList.index(value)

    #Method which adds a particular statistic to its corresponding bin
    def addToBin(self, key, loc, value, weight, count):
        if 'bin'+ str(loc) not in weight:
            weight['bin'+ str(loc)] = value
        else:
            weight['bin'+ str(loc)] += value
        if 'bin'+ str(loc) not in count:
            count['bin'+ str(loc)] = 1
        else:
            count['bin'+ str(loc)] += 1
        if 'total' not in weight:
            weight['total'] = value
        else:
            weight['total'] += value
        if 'total' not in count:
            count['total'] = 1
        else:
            count['total'] += 1
        return weight, count
        
    #Method used to run through a group of statistics and add them to their approprate bins
    def makeBins(self, stats, direct = False):
        if not direct:
            for key in self.binsRef:
                if key != 'links':
                    loc = self.getBinLocation(stats[key],self.instRef[key])
                    self.binsRef[key][0], self.binsRef[key][1] = self.addToBin(key, loc, stats[key], self.binsRef[key][0], self.binsRef[key][1])
        else:
            key = 'links'
            loc = self.getBinLocation(stats[key],self.instRef[key])
            self.binsRef[key][0], self.binsRef[key][1] = self.addToBin(key, loc, stats[key], self.binsRef[key][0], self.binsRef[key][1])
            
    #method used to print the contents of the bin for LSF .out files
    def getBins(self):
        fields = ['size', 'capacity', 'posOverhead', 'negOverhead', 'atime', 'ctime', 'mtime', 'links']
        for key in fields:
            if self.binsRef[key] != [{},{}]:
                print self.binsRef[key]
        
        

