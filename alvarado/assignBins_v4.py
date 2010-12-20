
class Binner():
    def __init__(self):
        self.sizeWeight = dict()
        self.sizeCount = dict()
        self.capWeight = dict()
        self.capCount = dict()
        self.negOvWeight = dict()
        self.negOvCount = dict()
        self.posOvWeight = dict()
        self.posOvCount = {}
        self.atimeWeight = dict()
        self.atimeCount = dict()
        self.ctimeWeight = dict()
        self.ctimeCount = dict()
        self.mtimeWeight = dict()
        self.mtimeCount = dict()
        self.linksWeight = dict()
        self.linksCount = dict()
        self.sizeLim = list()
        self.capLim = list()
        self.negOvLim = list()
        self.posOvLim = list()
        self.aLim = list()
        self.cLim = list()
        self.mLim = list()
        self.links = list()
        self.instRef = {"size":self.sizeLim, "capacity":self.capLim, "posOverhead":self.posOvLim,
                "negOverhead":self.negOvLim, "atime":self.aLim, "ctime":self.cLim, "mtime":self.mLim, "links":self.links}
        self.binsRef = {"size":[self.sizeWeight,self.sizeCount], "capacity":[self.capWeight,self.capCount], "posOverhead":[self.posOvWeight,self.posOvCount],
                "negOverhead":[self.negOvWeight,self.negOvCount], "atime":[self.atimeWeight,self.atimeCount], "ctime":[self.ctimeWeight,self.ctimeCount],
                   "mtime":[self.mtimeWeight,self.mtimeCount],"links":[self.linksWeight,self.linksCount]}
        

    def setLim(self,limDict):
        for key in limDict.keys():
            self.instRef[key] = limDict[key]
        for key in ['posOverhead','negOverhead']:
            self.instRef[key] = self.instRef['size']
            

    def getBinLocation(self, value, limit):
        tmpList = (limit + [value])
        tmpList.sort()
        return tmpList.index(value)

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
            

    def getBins(self):
        fields = ['size', 'capacity', 'posOverhead', 'negOverhead', 'atime', 'ctime', 'mtime', 'links']
        for key in fields:
            if self.binsRef[key] != [{},{}]:
                print self.binsRef[key]
        
        

