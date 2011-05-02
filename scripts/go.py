#!/usr/local/bin/python
#import os,sys
#from os import putenv,getenv,environ
#from optparse import OptionParser
#from subprocess import *
#import re

goFileName='/web/wwwprod/go/.htaccess'
outFileName='/usr/local/www/systems/go.html'
goFile=open(goFileName,'r')
outFile=open(outFileName,'w')

outFile.write((
"<html>\n"
"\t<head>\n"
"\t\t<title></title>\n"
"\t</head>\n\n"
"\t<body>\n"
"\t\t<table>\n"
"\t\t\t<tr>\n"
"\t\t\t\t<th>Go Link</th>\n"
"\t\t\t\t<th>Destination</th>\n"
"\t\t\t</tr>\n"
"\t\t\t<tr>\n"
))

for line in goFile:
    fields=line.split()
    if len(fields) < 3: continue
    goLink=fields[1]
    goLink=goLink.replace('(/?.*)','/*')
    destLink=fields[2]
    destLink=destLink.replace('$1','*')
    outFile.write((
                   "\t\t\t\t<td>%s</td>\n"
                   "\t\t\t\t<td>%s</td>\n"
                   "\t\t\t</tr>\n" % (goLink,destLink)))
    #print("http://go.broadinstitute.org%s\t\t%s" % (goLink,destLink))

outFile.write((
"\t\t</table>\n"
"\t</body>\n"
"</html>"
))
outFile.close()