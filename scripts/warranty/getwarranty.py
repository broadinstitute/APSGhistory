#!/usr/bin/env python
from database import Database
from datetime import datetime,timedelta
from re import match,split
from sys import exit,stderr
from time import mktime,sleep,strftime,strptime
#import time
from urllib2 import urlopen

class Warranty(object):

    def __init__(self):
        self.db=Database()

    def gethostinfo(self):
        sqlcode='''SELECT hostname,SKU,system_type,serialnum,vendor FROM
                   warranty'''
        self.db.curs.execute(sqlcode)
        rows=self.db.curs.fetchall()

        for row in rows:
            host,sku,type,serial,vendor=row
            if 'vmware' in vendor.lower(): continue
            try:
                self.getwarranty(host,sku,type,serial,vendor)
            except Exception,e:
                self.db.rollback(e)

    def getwarranty(self,host,sku,type,serial,vendor):
        lvendor=vendor.lower()

        if "dell" in lvendor:
            url=("http://support.dell.com/support/topics/global.aspx/support/"
                 "my_systems_info/details?c=us&cs=RC956904&l=en&s=hied&servicetag="+serial)
        elif "ibm" in lvendor:
            url=("http://www-307.ibm.com/pc/support/site.wss/warrantyLookup.do?"
                "type=%s&serial=%s&country=897&iws=off&sitestyle=lenovo" %
                (type,serial))
        elif "hp" in lvendor:
            url=("http://h20000.www2.hp.com/bizsupport/TechSupport/"
                 "WarrantyResults.jsp?lang=en&cc=us&prodSeriesId=454811&"
                 "prodTypeId=12454&sn=%s&pn=%s&country=US&nickname=&"
                 "find=Display+Warranty+Information" % (serial,sku))

        file=urlopen(url)
        lines=split('>|<',file.read())
        dates=[convertdate(line) for line in lines if convertdate(line)]

        warranty_start=strftime("%Y-%m-%d",min(dates))
        warranty_end=strftime("%Y-%m-%d",max(dates))
        if warranty_start == warranty_end: warranty_start = None

        sqlcode='''UPDATE warranty 
                   SET start_date=%s,end_date=%s
                   WHERE hostname=%s and SKU=%s and system_type=%s 
                   and serialnum=%s and vendor=%s'''
        self.db.curs.execute(sqlcode,(warranty_start,warranty_end,host,
                            sku,type,serial,vendor))

def convertdate(line):
	'''Based on RegEx match, convert date string to time object for future parsing'''
	if match('[\d]{1,2}/[\d]{1,2}/[\d]{4}',line): 
		return strptime(line,"%m/%d/%Y")
	elif match('[\d]{4}-[\d]{1,2}-[\d]{1,2}',line):
		#return time.strptime(line,"%Y-%m-%d")
		return strptime(line,"%Y-%m-%d")
	elif match('[\d]{1,2} (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) [\d]{4}',line):
		#return time.strptime(line,"%d %b %Y")
		return strptime(line,"%d %b %Y")
    else:
        return False #Not a Date

warranty=Warranty()
warranty.gethostinfo()
warranty.db.finish()
