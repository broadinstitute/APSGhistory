#Written By Matt Alvarado Broad Institute Intern Fall 2010
#If there are any issues please contact me at matthew.alvarado@students.olin.edu
import sys
import os

#Class used to get data from Config.txt saved in same directory
class Config():

    #used to get Database cridentials
    def getDBInfo(self):
        output = dict()
        files = os.listdir('.')
        if "Config.txt" not in files:
            print "Error! there is no Config.txt file saved in your current directory"
        else:
            config = open("Config.txt","r")
            #assemble output dictonary 
            for line in config.readlines():
                if "##" not in line:
                    if "dbhost" in line:
                        output["dbhost"] = line.split('=')[1].lstrip().replace("\n","").replace("\r","")
                    elif "dbuser" in line:
                        output["dbuser"] = line.split('=')[1].lstrip().replace("\n","").replace("\r","")
                    elif "dbpassword" in line:
                        output["dbpassword"] = line.split('=')[1].lstrip().replace("\n","").replace("\r","")
                    elif "database" in line:
                        output["database"] = line.split('=')[1].lstrip().replace("\n","").replace("\r","")
            return output

    #used to get the save locations for the output of the LSF jobs
    #Also used to as a refrence to their location
    def getWriteLocations(self):
        output = dict()
        files = os.listdir('.')
        if "Config.txt" not in files:
            print "Error! there is no Config.txt file saved in your current directory"
        else:
            config = open("Config.txt","r")
            #assemble output dictonary
            for line in config.readlines():
                if "##" not in line:
                    if "saveto" in line:
                        output["saveto"] = str(line.split("=")[1].lstrip().replace("\n","").replace("\r",""))
                    if "notifyto" in line:
                        output["notifyto"] = str(line.split("=")[1].lstrip().replace("\n","").replace("\r",""))
            return output




