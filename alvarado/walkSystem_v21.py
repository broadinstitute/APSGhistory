import sys
import os
import stat
import time
import subprocess
import MySQLdb
from makeStats_v2 import Statter
from assignBins_v4 import Binner
from parseOutput_v3 import Wrapper


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
    def statWalk(self, command, filepath, firstpass = 1, level = 1, Print = 0):
        Print = int(Print)
        level = int(level)
        firstpass = int(firstpass)
        if self.limDict == {}:
            self.setLimDict()
        if self.extHandle == []:
            self.setExt()
        # Is this the first time it is walking through the directory (i.e. is this a mount point)
        if firstpass:
            if os.access(filepath, os.R_OK):
                if level == 1:
                    print 'setDecList'
                    self.setDecList(filepath)
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
                                        self.decList.remove(item)
                                    if (statted.st_uid) not in self.dirs:
                                        self.dirs[statted.st_uid] = Binner()
                                        self.dirs[statted.st_uid].setLim(self.limDict)
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    else:
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    self.statWalk(command, os.path.join(filepath, item), 0, Print = 0)
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
                    #self.deprecate(filepath,decList)
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
                                        self.decList.remove(item)
                                    if (statted.st_uid) not in self.dirs:
                                        self.dirs[statted.st_uid] = Binner()
                                        self.dirs[statted.st_uid].setLim(self.limDict)
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    else:
                                        self.dirs[statted.st_uid].makeBins({'links':statted.st_nlink},True)
                                    #Make a LSF call using this script, with firstcall set to 0 
                                    print os.path.join(filepath,item)
                                    scan = self.getScanNum(os.path.join(filepath,item))
                                    outFile = "/broad/shptmp/alvarado/tester/scan" + str(scan)+".out"
                                    job = "scan"+str(scan)
                                    print job
                                    runtime = self.getRuntime(filepath,item)
                                    if runtime <= 300:
                                        pipe = subprocess.Popen("bsub -P crawler -q priority -J %s -o %s python %s %s %d %d %d" %
                                                                (job, outFile, command, os.path.join(filepath,item), 0, 2, 1),shell = True,stdout=subprocess.PIPE)
                                        print pipe.communicate()[0]
                                    else:
                                        pipe = subprocess.Popen("bsub -P extracrawler -q priority -J %s -o %s python %s %s %d %d %d" %
                                                                (job, outFile, command, os.path.join(filepath,item), 1, 2, 1),shell = True,stdout=subprocess.PIPE)
                                        print pipe.communicate()[0]                                        
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
                    #self.deprecate(filepath,decList)
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
                                self.statWalk(command, os.path.join(filepath, item), 0, Print = 0)
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
                    return 'done'


    def setLimDict(self):
        query = "SELECT * FROM bin_limits"
        output = self.dbQuery(query)
        for row in output:
            self.limDict[self.typeMap[row[0]]] = list(row[1:len(row)-1])

    def setExt(self):
        query = "SELECT * FROM ext_config"
        output = self.dbQuery(query)
        for row in output:
            self.extHandle.append(row[0])

    def setDecList(self, filepath):
        db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
        cursor = db.cursor()
        query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filepath)
        output = self.dbQuery(query)
        for row in output:
            fsid = row[0]
        query = "SELECT * FROM subdir WHERE fsid = %d AND deprecated = 0" % (fsid)
        output = self.dbQuery(query)
        for row in output:
            if row[4] != '.':
                self.decList.append(row[4])

    def getRuntime(self, filepath, name):
        db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
        cursor = db.cursor()
        query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filepath)
        output = self.dbQuery(query)
        for row in output:
            fsid = row[0]
        query = "SELECT * FROM subdir WHERE fsid = %d AND name = '%s' AND deprecated = 0" % (fsid, name)
        output = self.dbQuery(query)
        for row in output:
            if row[4] == name:
                dirid = row[1]
        query = "SELECT * FROM runtime WHERE fsid = %d and dirid = %d" % (fsid, dirid)
        output = self.dbQuery(query)
        if len(output) == 0:
            runtime = 0
        else:
            for row in output:
                runtime = row[2]
        return runtime


    def deprecate(self,filepath,decList):
        if decList != []:
            db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
            cursor = db.cursor()
            query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filepath)
            output = self.dbQuery(query)
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
    def getScanNum(self, filepath):
        try:
            db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
            cursor = db.cursor()
            absPath = os.path.abspath(filepath)
            mount, subDir = self.getMount(absPath)
            fsquery = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
            cursor.execute(fsquery)
            fsdata = cursor.fetchall()
            fsid = fsdata[0][0]
            sbquery = "SELECT * FROM subdir WHERE name = '%s' AND fsid = %d AND deprecated = 0" % (subDir, fsid)
            cursor.execute(sbquery)
            sbdata = cursor.fetchall()
            for row in sbdata:
                if row[4] == subDir:
                    sbid = row[1]                    
            db.close()
            return str(fsid) + '-' + str(sbid)
        #If the entry is not in the database
        except:
            db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
            cursor = db.cursor()
            absPath = os.path.abspath(filepath)
            mount, subDir = self.getMount(absPath)
            fsquery = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
            cursor.execute(fsquery)
            fsdata = cursor.fetchall()
            fsid = fsdata[0][0]
            fsquery = "SELECT * FROM subdir WHERE fsid = %d" % (fsid)
            cursor.execute(fsquery)
            entries = cursor.fetchall()
            dirid = entries[-1][1]
            subquery = "INSERT INTO subdir(fsid, dirid, name) VALUES(%d, %d, '%s')" % (fsid, dirid+1, subDir)
            output = cursor.execute(subquery)
            db.commit()
            db.close()
            return str(fsid) + '-' + str(dirid+1)
        
        
    #Method which given an abosolute path returns the mount
    #used in the getScanNum method
    def getMount(self,absPath):
        if len(os.path.split(absPath)[0].split('/')) == 3:
            return os.path.split(absPath)[0], os.path.split(absPath)[1]
        else:
            return self.getMount(os.path.split(absPath)[0])

    #General query method
    #Given a query as a string it will return the output from the database
    def dbQuery(self, query):
        db = MySQLdb.connect('mysql','alvarado','olincollege','alvarado')
        cursor = db.cursor()
        cursor.execute(query)
        output = cursor.fetchall()
        db.close()
        return output

#=========================================================End of Walker================================================================================
        
       
'''def waiter(spcFile,fileList):
    if spcFile not in fileList:
        time.sleep(1)
        return False
    else:
        return True

if __name__ == '__main__':
    print sys.argv
    status = False
    try:
        os.remove('./notify.txt')
    except:
        pass
    walk = Walker()
    if len(sys.argv) == 3:
        output = walk.statWalk(sys.argv[0], sys.argv[1], sys.argv[2])
    elif len(sys.argv) == 2:
        output = walk.statWalk(sys.argv[0], sys.argv[1])

    absPath = os.path.abspath(sys.argv[1])
    mount, subDir = walk.getMount(absPath)
    query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (mount)
    fsid = walk.dbQuery(query)
    if output[0] == 'done':
        pipe = subprocess.Popen('bsub -q priority -w "ended(scan*)" -o notify-%s.txt date' % (fsid) ,shell = True,stdout=subprocess.PIPE)
        print pipe.communicate()[0]   
    
    currFiles = os.listdir('.')
    status = waiter('notify.txt',currFiles)
    while status == False:
        currFiles = os.listdir('.')
        status = waiter('notify.txt',currFiles)'''
    

    
