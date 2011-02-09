#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import sys
import os
import time
import MySQLdb
from config import Config

#Updater class used to update the database tables
class Updater():
    #instance varable corresponging to the type numbers
    typeMap = {'size':1,'capacity':2,'negOverhead':4,'posOverhead':3,'atime':14,'ctime':12,'mtime':10,'links':8}
    dbInfo = str()

    #create dummy bins and get DB Info
    def __init__(self):
        self.weightedBin = {'total':0 , 'bin0': 0, 'bin1':0, 'bin2':0 , 'bin3':0, 'bin4':0 , 'bin5':0, 'bin6':0 , 'bin7':0 , 'bin8':0}
        self.countedBin = {'total':0 , 'bin0': 0, 'bin1':0, 'bin2':0 , 'bin3':0, 'bin4':0 , 'bin5':0, 'bin6':0 , 'bin7':0 , 'bin8':0}
        config = Config()
        self.dbInfo = config.getDBInfo()
    
    #simple DB query method
    def dbQuery(self, query):
        db = MySQLdb.connect(self.dbInfo["dbhost"],self.dbInfo["dbuser"],
                             self.dbInfo["dbpassword"],self.dbInfo["database"])
        cursor = db.cursor()
        output = cursor.execute(query)
        output1 = cursor.fetchall()
        db.commit()
        db.close()
        return output1
    
    #Method used to write the directory totals to the corresponding database tables
    def writeDirTotals(self,fsid,dirTotalDict):
        for dirid in dirTotalDict:
            for mainKey in ['Users','Extentions','Directories','Runtime']:
                if mainKey == 'Users':
                    if mainKey in dirTotalDict[dirid]:
                        for category in dirTotalDict[dirid][mainKey]:
                            weightedTotal = dirTotalDict[dirid][mainKey][category][0]
                            countedTotal = dirTotalDict[dirid][mainKey][category][1]
                            query = "INSERT INTO userstats (fsid,dirid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d,%d)" %(fsid,int(dirid),self.typeMap[category],1,time.time(),weightedTotal)
                            self.dbQuery(query)
                            query = "INSERT INTO userstats (fsid,dirid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d,%d)" %(fsid,int(dirid),self.typeMap[category],0,time.time(),countedTotal)
                            self.dbQuery(query)
                elif mainKey == 'Extentions':
                    if mainKey in dirTotalDict[dirid]:
                        for category in dirTotalDict[dirid][mainKey]:
                            weightedTotal = dirTotalDict[dirid][mainKey][category][0]
                            countedTotal = dirTotalDict[dirid][mainKey][category][1]
                            query = "INSERT INTO extstats (fsid,dirid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d,%d)" %(fsid,int(dirid),self.typeMap[category],1,time.time(),weightedTotal)
                            self.dbQuery(query)
                            query = "INSERT INTO extstats (fsid,dirid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d,%d)" %(fsid,int(dirid),self.typeMap[category],0,time.time(),countedTotal)
                            self.dbQuery(query)
                elif mainKey == 'Directories':
                    if mainKey in dirTotalDict[dirid]:
                        for category in dirTotalDict[dirid][mainKey]:
                            weightedTotal = dirTotalDict[dirid][mainKey][category][0]
                            countedTotal = dirTotalDict[dirid][mainKey][category][1]
                            query = "UPDATE userstats SET links = %d WHERE fsid = %d AND dirid = %d AND weighted = 1 AND time > %d AND uid IS NULL AND diff > 0 " %(weightedTotal,fsid,int(dirid), (time.time()-30))
                            self.dbQuery(query)
                            query = "UPDATE userstats SET links = %d WHERE fsid = %d AND dirid = %d AND weighted = 0 AND time > %d AND uid IS NULL AND diff > 0" %(countedTotal,fsid,int(dirid), (time.time()-30))
                            self.dbQuery(query)
                elif mainKey == 'Runtime':
                    runtime = dirTotalDict[dirid][mainKey]
                    query = "SELECT * FROM runtime WHERE fsid = %d AND dirid = %d" % (int(fsid), int(dirid))
                    pastRuntime = self.dbQuery(query)
                    if pastRuntime != ():
                        if int(pastRuntime[0][2]) < int(runtime):
                            query = "REPLACE INTO runtime (fsid, dirid, runtime) VALUES(%d,%d,%f)" % (fsid, int(dirid), float(runtime))
                            self.dbQuery(query)

    #Method used to write overall totals to their corresponding databases           
    def writeTotals(self,fsid,totalDict):
        for mainKey in ['Users','Extentions','Directories']:
            if mainKey == 'Users':
                for category in totalDict[mainKey]:
                    weightedTotal = totalDict[mainKey][category][0]
                    countedTotal = totalDict[mainKey][category][1]
                    query = "INSERT INTO userstats (fsid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d)" %(fsid,self.typeMap[category],1,time.time(),weightedTotal)
                    self.dbQuery(query)
                    query = "INSERT INTO userstats (fsid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d)" %(fsid,self.typeMap[category],0,time.time(),countedTotal)
                    self.dbQuery(query)
            elif mainKey == 'Extentions':
                for category in totalDict[mainKey]:
                    weightedTotal = totalDict[mainKey][category][0]
                    countedTotal = totalDict[mainKey][category][1]
                    query = "INSERT INTO extstats (fsid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d)" %(fsid,self.typeMap[category],1,time.time(),weightedTotal)
                    self.dbQuery(query)
                    query = "INSERT INTO extstats (fsid,type,weighted,time,total) VALUES(%d,%d,%d,%d,%d)" %(fsid,self.typeMap[category],0,time.time(),countedTotal)
                    self.dbQuery(query)
            elif mainKey == 'Directories':
                for category in totalDict[mainKey]:
                    weightedTotal = totalDict[mainKey][category][0]
                    countedTotal = totalDict[mainKey][category][1]
                    query = "UPDATE userstats SET links = %d WHERE fsid = %d AND dirid IS NULL AND uid IS NULL AND time > %d AND weighted = 1 AND diff >0" % (weightedTotal, fsid, (time.time()-30))
                    self.dbQuery(query)
                    query = "UPDATE userstats SET links = %d WHERE fsid = %d AND dirid IS NULL AND uid IS NULL AND time > %d AND weighted = 0 AND diff >0" % (countedTotal, fsid, (time.time()-30))
                    self.dbQuery(query)
           
        
    #Method which writes a standard statistic output to the database
    def writeToDB(self, fsid, dirid, statDict):
        for category in ['Users','Extentions','Directories']:
            if category == 'Users':
                for key in statDict[category]:
                    for typ in statDict[category][key]:
                        self.__init__()
                        spcTyp = self.typeMap[typ]
                        for bins in statDict[category][key][typ][0]:
                            self.weightedBin[bins] = int(statDict[category][key][typ][0][bins])
                        for bins in statDict[category][key][typ][1]:
                            self.countedBin[bins] = int(statDict[category][key][typ][1][bins])
                        query = '''INSERT INTO userstats (fsid,dirid,uid,type,weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total)
                                    VALUES(%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d)''' %(fsid, dirid, int(key), spcTyp, 1, time.time(),
                                                        self.weightedBin['bin0'],self.weightedBin['bin1'],
                                                        self.weightedBin['bin2'],self.weightedBin['bin3'], 
                                                        self.weightedBin['bin4'],self.weightedBin['bin5'],
                                                        self.weightedBin['bin6'],self.weightedBin['bin7'],
                                                        self.weightedBin['bin8'],self.weightedBin['total'])
                        self.dbQuery(query)
                        query = '''INSERT INTO userstats (fsid,dirid,uid,type,weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total)
                                    VALUES(%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d)''' %(fsid, dirid, int(key), spcTyp, 0, time.time(),
                                                        self.countedBin['bin0'],self.countedBin['bin1'],
                                                        self.countedBin['bin2'],self.countedBin['bin3'], 
                                                        self.countedBin['bin4'],self.countedBin['bin5'],
                                                        self.countedBin['bin6'],self.countedBin['bin7'],
                                                        self.countedBin['bin8'],self.countedBin['total'])
                        self.dbQuery(query)
            elif category == 'Extentions':
                for key in statDict[category]:
                    for typ in statDict[category][key]:
                        self.__init__()
                        spcTyp = self.typeMap[typ]
                        for bins in statDict[category][key][typ][0]:
                            self.weightedBin[bins] = int(statDict[category][key][typ][0][bins])
                        for bins in statDict[category][key][typ][1]:
                            self.countedBin[bins] = int(statDict[category][key][typ][1][bins])
                        query = '''INSERT INTO extstats (fsid,dirid,uid,type,weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total)
                                    VALUES(%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d)''' %(fsid, dirid, int(key), spcTyp, 1, time.time(),
                                                        self.weightedBin['bin0'],self.weightedBin['bin1'],
                                                        self.weightedBin['bin2'],self.weightedBin['bin3'], 
                                                        self.weightedBin['bin4'],self.weightedBin['bin5'],
                                                        self.weightedBin['bin6'],self.weightedBin['bin7'],
                                                        self.weightedBin['bin8'],self.weightedBin['total'])
                        self.dbQuery(query)
                        query = '''INSERT INTO extstats (fsid,dirid,uid,type,weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total)
                                    VALUES(%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d)''' %(fsid, dirid, int(key), spcTyp, 0, time.time(),
                                                        self.countedBin['bin0'],self.countedBin['bin1'],
                                                        self.countedBin['bin2'],self.countedBin['bin3'], 
                                                        self.countedBin['bin4'],self.countedBin['bin5'],
                                                        self.countedBin['bin6'],self.countedBin['bin7'],
                                                        self.countedBin['bin8'],self.countedBin['total'])
                        self.dbQuery(query)
            elif category == 'Directories':
                for key in statDict[category]:
                    for typ in statDict[category][key]:
                        self.__init__()
                        spcTyp = self.typeMap[typ]
                        for bins in statDict[category][key][typ][0]:
                            self.weightedBin[bins] = int(statDict[category][key][typ][0][bins])
                        for bins in statDict[category][key][typ][1]:
                            self.countedBin[bins] = int(statDict[category][key][typ][1][bins])
                        query = '''INSERT INTO userstats (fsid, dirid, uid, type, weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total) VALUES(%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d,%d,%d,%d,%d)''' % (fsid, dirid, int(key), spcTyp, 1, time.time(),
                                                        self.weightedBin['bin0'],self.weightedBin['bin1'],
                                                        self.weightedBin['bin2'],self.weightedBin['bin3'], 
                                                        self.weightedBin['bin4'],self.weightedBin['bin5'],
                                                        self.weightedBin['bin6'],self.weightedBin['bin7'],
                                                        self.weightedBin['bin8'],self.weightedBin['total'])
                        self.dbQuery(query)
                        query = '''INSERT INTO userstats (fsid,dirid,uid,type,weighted,time,bin0,bin1,
                                    bin2,bin3,bin4,bin5,bin6,bin7,bin8,total)
                                    VALUES(%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,%d,
                                    %d,%d,%d,%d,%d)''' %(fsid, dirid, int(key), spcTyp, 0, time.time(),
                                                        self.countedBin['bin0'],self.countedBin['bin1'],
                                                        self.countedBin['bin2'],self.countedBin['bin3'], 
                                                        self.countedBin['bin4'],self.countedBin['bin5'],
                                                        self.countedBin['bin6'],self.countedBin['bin7'],
                                                        self.countedBin['bin8'],self.countedBin['total'])
                        self.dbQuery(query)

        

if __name__ == '__main__':
    pass
