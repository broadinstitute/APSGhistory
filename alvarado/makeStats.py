#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import os
import time

#Statter class which takes in os.lstat object
#uses getStats method to return necessary statistics in usable form
class Statter:

    #initalize instance variables used to store statistics
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

    #Method which takes in "stat" object created using os.lstat and assigns stats to
    #instance variables designated for that statistic
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

    #Getter Method used to return the statistics as values in a dictonary with preset keys
    #Keys are used as a standard in all other classes
    def getStats(self):
        return {'uid':self.uid, 'filetype':self.filetype, 'size':(self.size)*.000976,
                'capacity':self.capacity*.000976, 'posOverhead':self.posOverhead,
                'negOverhead':self.negOverhead, 'atime':self.atime, 'ctime':self.ctime,
                'mtime':self.mtime}


