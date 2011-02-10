#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.eduimport sys
import os
import sys
import stat
import time
import subprocess
import MySQLdb
from makeStats import Statter
from assignBins import Binner
import os
from walkSystem import Walker
from parseOutput import Wrapper
from addOutputs import Adder
from sql_Update import Updater
from config import Config

sys.setrecursionlimit(1000)

#General database query function
def dbQuery(query, configData):
    dbinfo = configData.getDBInfo()
    db = MySQLdb.connect(dbinfo["dbhost"],dbinfo["dbuser"],dbinfo["dbpassword"],dbinfo["database"])
    cursor = db.cursor()
    cursor.execute(query)
    output = cursor.fetchall()
    db.close()
    return output
        
#Takes arguments of file system mounts
if __name__ == '__main__':
        notifyList = list()
        filesystems = sys.argv[1:]
        configData = Config()
        #get write locations
        saveLocations = configData.getWriteLocations()
        dbInfo = configData.getDBInfo()
        #kill all existing jobs
        pipe = subprocess.Popen('bkill 0',shell = True,stdout=subprocess.PIPE)
        for filesystem in filesystems:
            query = "SELECT * FROM filesystem WHERE mount = '%s' AND deprecated = 0" % (filesystem)            
            fsid = dbQuery(query, configData)
            print fsid
            job = "scan"+str(fsid[0][0])+"-0"
            outFile = str(saveLocations["saveto"]) + "/scan"+str(fsid[0][0])+"-0.out"
            command = "walkSystem.py"
            #submit job to walk mount with firstpass = 1
            pipe = subprocess.Popen('bsub -P crawler -r -Q "1" -q priority -J %s -o %s python %s %s %d %d %d' %
                                  (job, outFile, command, filesystem, 1, 0, 1),shell = True,stdout=subprocess.PIPE)
            print pipe.communicate()[0]
            #notify = saveLocations["notifyto"]+'/notify-'+str(fsid[0][0])+'.txt'
            #notifyList.append(os.path.split(notify)[1])
            #scan = 'scan'+str(fsid[0][0])+'*'
            #pipe = subprocess.Popen('bsub -P crawler -J waiter -q priority -o waiting.out python waiting.py %s' % (repr(notifyList)) ,shell = True,stdout=subprocess.PIPE)
            #print pipe.communicate()[0]
            #pipe = subprocess.Popen('bsub -P crawler -q priority -w "ended(%s)" -o %s date' % (scan,notify) ,shell = True,stdout=subprocess.PIPE)
            #print pipe.communicate()[0]
            
            
        
