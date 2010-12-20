import os
import time
class Statter:
    def __init__(self):
        self.uid = long()
        self.size = long()
        self.capacity = long()
        self.posOverhead =  long()
        self.negOverhead = long()
        self.atime = long()
        self.ctime = long()
        self.mtime = long()
        self.filetype = str()
        
    def setStats(self, handle, stat):
        self.__init__()
        self.uid = stat.st_uid
        self.size = stat.st_size
        self.capacity = (stat.st_blocks)/8.0* stat.st_blksize
        if self.capacity*.000976 < self.size*.000976:
            self.negOverhead = self.size*.000976
            self.posOverhead = 0
        if self.capacity >= self.size*.000976:
            self.posOverhead = self.size*.000976
            self.negOverhead = 0
        self.atime = (time.time() - stat.st_atime)
        self.ctime = (time.time() - stat.st_ctime)
        self.mtime = (time.time()- stat.st_mtime)
        self.filetype = os.path.splitext(handle)[1]

    def getStats(self):
        return {'uid':self.uid, 'filetype':self.filetype, 'size':(self.size)*.000976, 'capacity':self.capacity*.000976, 'posOverhead':self.posOverhead,
                'negOverhead':self.negOverhead, 'atime':self.atime, 'ctime':self.ctime, 'mtime':self.mtime}

'''stater = makeStats()
stater.setStats("test.txt")
print stater.getStats()'''
