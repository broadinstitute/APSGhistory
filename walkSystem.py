#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import sys
import os
import stat
import time
import subprocess
import MySQLdb
from makeStats import Statter
from assignBins import Binner
from parseOutput import Wrapper
from config import Config


#Walker Class. Instantiate on a individual filesystem and it will walk it and return historgrams of statistics
class Walker(Statter):
    start = time.time()
    users = dict()
    ext = dict()
    dirs = dict()
    typeMap = {1:'size',2:'capacity',4:'negOverhead',3:'posOverhead',14:'atime',12:'ctime',10:'mtime',8:'links'}
    limDict = dict()
    extHandle = list()
    decList = list()
    
    #The main method used to walk the filesytem
    #
    #It checks to see if the firstpass variable is true or not. (If first pass is true than it will see if it can intantiate LSF jobs. Otherwise it just walks the directory normally)
    #It then checks if the user running this application has access to read the current filepath
    #If the user can read the current filepath it then stats the root directory in the current filepath and gets the number of nlinks for that direcotry
    #If the number of links are below 5000 it submits a job to LSF for each subdirectory
    #If the nubmer of links is above 5000 it would be very ineffiecent to submit jobs to LSF so it just walks the entire filesystem normally
    def statWalk(self, command, filepath, configData, firstpass = 1, level = 1, Print = 1):
        Print = int(Print)
        level = int(level)
        firstpass = int(firstpass)
        if self.limDict == {}:
            self.setLimDict(configData)
        if self.extHandle == []:
            self.setExt(configData)
        # Is this the first time it is walking through the directory (i.e. is this a mount point)
        if firstpass:
            if os.access(filepath, os.R_OK):
                if level == 0:
                    self.setDecList(filepath,configData)
                linkStat = os.lstat(filepath)
                if linkStat.st_nlink >= 5000:
                    #Run normal Walk on directory
                    for item in os.listdir(filepath):
                        if os.access(os.path.join(filepath,item),os.R_OK):
                            statted = os.lstat(os.path.join(filepath,item))
                            #If the file is not a symbolic link
                            if not stat.S_ISLNK(statted[stat.ST_MODE]):
                                #If the file is a directory
                                if stat.S_ISDIR(statted[stat.ST_MODE]):
                                    if level == 1:
                                        try:
                                            self.decList.remove(item)
                                        except:
                                            pass
                                    if (statted.st_uid) not in self.dirs:
                                        self.dirs[statted.st_uid] = Binner()
                                        self.dirs[statted.st_uid].setLim(self.limDict)
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    else:
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    self.statWalk(command, os.path.join(filepath, item),configData, 0,level+1, Print = 0)
                                #If it is not a directory
                                else:
                                    self.setStats(os.path.join(filepath,item), statted)
                                    stats = self.getStats()
                                    if stats['uid'] not in self.users:
                                        self.users[stats['uid']] = Binner()
                                        self.users[stats['uid']].setLim(self.limDict)
                                        self.users[stats['uid']].makeBins(stats)
                                    else:
                                        self.users[stats['uid']].makeBins(stats)
                                    #If its extention is one which you would like to stat
                                    if stats['filetype'] in self.extHandle:
                                        if stats['uid'] not in self.ext:
                                            self.ext[stats['uid']] = Binner()
                                            self.ext[stats['uid']].setLim(self.limDict)
                                            self.ext[stats['uid']].makeBins(stats)
                                        else:
                                            self.ext[stats['uid']].makeBins(stats)
                    
                    end = time.time()
                    if Print:
                        print ''
                        for key in self.users.keys():
                            print 'Users'
                            print key
                            self.users[key].getBins()

                        print ''
                        
                        for key in self.ext.keys():
                            print 'Extentions'
                            print key
                            self.ext[key].getBins()
                        print ''
                        
                        for key in self.dirs.keys():
                            print 'Directories'
                            print key
                            self.dirs[key].getBins()
                        print ''
                        end = time.time()
                        print 'runtime = ' +  str(end-self.start)
                    #self.deprecate(filepath,decList, configData)
                    return self.users, self.ext, self.dirs, str(end-self.start)

                else:
                    #Instantiate using LSF
                    for item in os.listdir(filepath):
                        if os.access(os.path.join(filepath,item),os.R_OK):
                            statted = os.lstat(os.path.join(filepath,item))
                            #If the file is not a symbolic link
                            if not stat.S_ISLNK(statted[stat.ST_MODE]):
                                #If the current file is a directory
                                if stat.S_ISDIR(statted[stat.ST_MODE]):
                                    if level == 1:
                                        try:
                                            self.decList.remove(item)
                                        except:
                                            pass
                                    if (statted.st_uid) not in self.dirs:
                                        self.dirs[statted.st_uid] = Binner()
                                        self.dirs[statted.st_uid].setLim(self.limDict)
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    else:
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    scan = self.getScanNum(os.path.join(filepath,item),configData, level)
                                    saveLocations = configData.getWriteLocations()
                                    outFile = str(saveLocations["saveto"]) + "/scan"+str(scan)+".out"
                                    job = "scan"+str(scan)
                                    mount, currentDir, parentDir = self.getMount(filepath)
                                    runtime = self.getRuntime(mount,item,configData)
                                    #Make a LSF call using this script, with firstpass set to 0 
                                    if runtime <= 300:
                                        pipe = subprocess.Popen('bsub -P crawler -r -Q "1" -q priority -J %s -o %s python %s %s %d %d %d' %
                                                                (job, outFile, command, os.path.join(filepath,item), 0, level + 1, 1),shell = True,stdout=subprocess.PIPE)
                                    #Make a LSF call using this script with firstpass set to 1 to parallelize
                                    else:
                                        pipe = subprocess.Popen('bsub -P crawler -r -Q "1" -q priority -J %s -o %s python %s %s %d %d %d' %
                                                                (job, outFile, command, os.path.join(filepath,item), 1, level + 1, 1),shell = True,stdout=subprocess.PIPE)                                       
                                #If the current file is not a directory
                                else:
                                    self.setStats(os.path.join(filepath,item), statted)
                                    stats = self.getStats()
                                    if stats['uid'] not in self.users:
                                        self.users[stats['uid']] = Binner()
                                        self.users[stats['uid']].setLim(self.limDict)
                                        self.users[stats['uid']].makeBins(stats)
                                    else:
                                        self.users[stats['uid']].makeBins(stats)
                                    if stats['filetype'] in self.extHandle:
                                        if stats['uid'] not in self.ext:
                                            self.ext[stats['uid']] = Binner()
                                            self.ext[stats['uid']].setLim(self.limDict)
                                            self.ext[stats['uid']].makeBins(stats)
                                        else:
                                            self.ext[stats['uid']].makeBins(stats)
                 
                    end = time.time()
                    if Print:
                        print ''
                        for key in self.users.keys():
                            print 'Users'
                            print key
                            self.users[key].getBins()

                        print ''
                        
                        for key in self.ext.keys():
                            print 'Extentions'
                            print key
                            self.ext[key].getBins()
                        print ''
                        
                        for key in self.dirs.keys():
                            print 'Directories'
                            print key
                            self.dirs[key].getBins()
                        print ''
                        end = time.time()
                        print 'runtime = ' +  str(end-self.start)
                    #self.deprecate(filepath,decList, configData)
                    return self.users, self.ext, self.dirs, str(end-self.start)
        else:
            #If this is the second recursive pass --> walk normally
            if os.access(filepath, os.R_OK):
                for item in os.listdir(filepath):
                    if os.access(os.path.join(filepath,item),os.R_OK):
                        statted = os.lstat(os.path.join(filepath,item))
                        #If the current file is not a symbolic link
                        if not stat.S_ISLNK(statted[stat.ST_MODE]):
                            #If the current file is a directory
                            if stat.S_ISDIR(statted[stat.ST_MODE]):
                                if (statted.st_uid) not in self.dirs:
                                    self.dirs[statted.st_uid] = Binner()
                                    self.dirs[statted.st_uid].setLim(self.limDict)
                                    self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                else:
                                    self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                self.statWalk(command, os.path.join(filepath, item), configData, 0, Print = 0)
                            #If the current file is not a directory
                            else:
                                self.setStats(os.path.join(filepath,item), statted)
                                stats = self.getStats()
                                if stats['uid'] not in self.users:
                                    self.users[stats['uid']] = Binner()
                                    self.users[stats['uid']].setLim(self.limDict)
                                    self.users[stats['uid']].makeBins(stats)
                                else:
                                    self.users[stats['uid']].makeBins(stats)
                                if stats['filetype'] in self.extHandle:
                                    if stats['uid'] not in self.ext:
                                        self.ext[stats['uid']] = Binner()
                                        self.ext[stats['uid']].setLim(self.limDict)
                                        self.ext[stats['uid']].makeBins(stats)
                                    else:
                                        self.ext[stats['uid']].makeBins(stats)
                #Should it print the output? Used for LSF
                if Print:
                    print ''
                    for key in self.users.keys():
                        print 'Users'
                        print key
                        self.users[key].getBins()

                    print ''
                    
                    for key in self.ext.keys():
                        print 'Extentions'
                        print key
                        self.ext[key].getBins()
                    print ''
                    
                    for key in self.dirs.keys():
                        print 'Directories'
                        print key
                        self.dirs[key].getBins()
                    print ''
                    end = time.time()
                    print 'runtime = ' +  str(end-self.start)
                    return self.users, self.ext, self.dirs, str(end-self.start)

    #Read the limits from the databae and set the instance variable limDict
    def setLimDict(self,configData):
        query = "SELECT * FROM bin_limits"
        output = self.dbQuery(query,configData)
        for row in output:
            self.limDict[self.typeMap[row[0]]] = list(row[1:len(row)-1])

    #set the extHandle instance variable from ext_config database
    #can take more than one handle but have not tested fully
    def setExt(self,configData):
        query = "SELECT * FROM ext_config"
        output = self.dbQuery(query, configData)
        for row in output:
            self.extHandle.append(row[0])

    #initialize decrement list.
    #decrement list is an instance variable decList
    def setDecList(self, filepath, configData):
        dbinfo = configData.getDBInfo()
        db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
        cursor = db.cursor()
        query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filepath)
        output = self.dbQuery(query,configData)
        for row in output:
            fsid = row[0]
        query = "SELECT * FROM subdir WHERE fsid = %d AND deprecated = 0" % (fsid)
        output = self.dbQuery(query,configData)
        for row in output:
            if row[4] != '.':
                self.decList.append(row[4])

    #Get runtime for a specific directory. If there is no runtime data return 0
    def getRuntime(self, mount, name, configData):
        dbinfo = configData.getDBInfo()
        db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
        cursor = db.cursor()
        query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
        output = self.dbQuery(query, configData)
        for row in output:
            fsid = row[0]
        query = "SELECT * FROM subdir WHERE fsid = %d AND name = '%s' AND deprecated = 0" % (fsid, name)
        output = self.dbQuery(query, configData)
        for row in output:
            if row[4] == name:
                dirid = row[1]
        query = "SELECT * FROM runtime WHERE fsid = %d and dirid = %d" % (fsid, dirid)
        output = self.dbQuery(query, configData)
        #return 0 if there is no data
        if len(output) == 0:
            runtime = 0
        else:
            for row in output:
                runtime = row[2]
        return runtime

    #set the directories which do not exist anymore depricate flag to 1
    def deprecate(self,filepath,decList,configData):
        if decList != []:
            dbinfo = configData.getDBInfo()
            db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
            cursor = db.cursor()
            query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filepath)
            output = self.dbQuery(query,configData)
            for row in output:
                fsid = row[0]
            for directory in decList:
                query = "UPDATE subdir SET deprecated = 1 WHERE fsid = %d AND name = '%s'" % (fsid, directory)
                cursor.execute(query)
                db.commit()
            db.close()
            


    #Method which given a filepath returns the scan number to use for LSF
    #It gets the scan number by making a database call
    #If the file is not in the database insert a new entry into the database
    def getScanNum(self, filepath, configData, level):
        try:
            dbinfo = configData.getDBInfo()
            db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
            cursor = db.cursor()
            absPath = os.path.abspath(filepath)
            mount, subDir, parentDir = self.getMount(absPath)
            fsquery = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
            cursor.execute(fsquery)
            fsdata = cursor.fetchall()
            fsid = fsdata[0][0]
            if level == 0:
                sbquery = "SELECT * FROM subdir WHERE name = '%s' AND fsid = %d AND deprecated = 0 AND level = %d" % (subDir, fsid,level)
            else:
                parentquery = "SELECT * FROM subdir WHERE name = '%s' and fsid = %d AND deprecated = 0 AND level = %d" % (parentDir, fsid, level-1)
                cursor.execute(sbquery)
                parentData = cursor.fetchall()
                parentid = parentData[0][1]
                sbquery = "SELECT * FROM subdir WHERE name = '%s' AND fsid = %d AND deprecated = 0 AND level = %d AND parent = %d" % (subDir, fsid,level,parentid)
            cursor.execute(sbquery)
            sbdata = cursor.fetchall()
            for row in sbdata:
                if row[4] == subDir:
                    sbid = row[1]                    
            db.close()
            return str(fsid) + '-' + str(sbid)
        #If the entry is not in the database create an entry in the database
        except:
            dbinfo = configData.getDBInfo()
            db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
            cursor = db.cursor()
            absPath = os.path.abspath(filepath)
            mount, subDir, parentDir = self.getMount(absPath)
            fsquery = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
            cursor.execute(fsquery)
            fsdata = cursor.fetchall()
            fsid = fsdata[0][0]
            fsquery = "SELECT * FROM subdir WHERE fsid = %d" % (fsid)
            cursor.execute(fsquery)
            entries = cursor.fetchall()
            dirid = entries[-1][1]
            if level == 0:
                subquery = "INSERT INTO subdir(fsid, dirid, name) VALUES(%d, %d, '%s')" % (fsid, dirid+1, subDir)
                output = cursor.execute(subquery)
            #use level to get parent dir
            elif level >= 1:
                fsquery = "SELECT * FROM subdir WHERE fsid = %d AND name = '%s' AND deprecated = 0" % (fsid,parentDir)
                cursor.execute(fsquery)
                entries = cursor.fetchall()
                parentId = entries[-1][1]
                subquery = "INSERT INTO subdir(fsid, dirid, parent, name, level) VALUES(%d, %d, %d, '%s',%d)" % (fsid, dirid+1, parentId, subDir,level)
                output = cursor.execute(subquery)                
            db.commit()
            db.close()
            return str(fsid) + '-' + str(dirid+1)
        
        
    #Method which given an abosolute path returns the mount
    #used in the getScanNum method
    def getMount(self,absPath):
        if len(absPath.split('/')) >= 3:
            splitPath = absPath.split('/')
            return '/'+splitPath[1]+'/'+splitPath[2], splitPath[-1], splitPath[len(splitPath)-2]
        else:
            print "Error in walkSystem_23.py with method getMount. When called the path did not have the appropriate length. Should look like /seq/software/... \n"
            
    #General query method
    #Given a query as a string it will return the output from the database
    def dbQuery(self, query, configData):
        try:
            dbinfo = configData.getDBInfo()
            print configData.getDBInfo()
            db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
            cursor = db.cursor()
            cursor.execute(query)
            output = cursor.fetchall()
            db.close()
            return output
        except:
            configData = Config()
            return self.dbQuery(query,configData)
        

#=========================================================End of Walker================================================================================
        
       
    

if __name__ == '__main__':
    print sys.argv
    walk = Walker()
    configData = Config()
    #if named arguments are specified
    if len(sys.argv) == 5:
        output = walk.statWalk(sys.argv[0], sys.argv[1], configData, sys.argv[2],sys.argv[3],sys.argv[4])
    #use default named values for arguments
    elif len(sys.argv) == 2:
        output = walk.statWalk(sys.argv[0], sys.argv[1], configData)    
