#!/usr/bin/python
from subprocess import Popen, PIPE
from datetime import datetime, timedelta
from optparse import OptionParser
import sys, time

currentDate = datetime.now()
#Nagios Exit Stati
UNKNOWN = -1
OK = 0
WARNING = 1
CRITICAL = 2

##commandline args
parser = OptionParser()
parser.add_option('-w', '--warning', dest='warningThresh')
options, args = parser.parse_args()
warningThresh = int(options.warningThresh)

def datetimeStr(mytime):
	time_format = "%m/%d/%Y"
	return datetime.fromtimestamp(time.mktime(time.strptime(mytime, time_format)))

def getSerial(awkParam,awkFS):
	try:
		p1 = Popen(["sudo","/usr/sbin/dmidecode"], stdout=PIPE, universal_newlines=True)
		p2 = Popen("awk" + " -F" + awkFS + awkParam, stdin=p1.stdout, shell=True, stdout=PIPE, universal_newlines=True)
		p3 = Popen(["head","-n1"],stdout=PIPE,stdin=p2.stdout,universal_newlines=True)
		output = (p3.communicate()[0].strip())
		return output
	except:
		print "UNKNOWN -- cannot retrieve system identification"
		raise SystemExit, UNKNOWN


def getVendor():
	awkParam = r"'/Vendor/ {print $2}'"
	sedParam = r"'s/ //'"

	try:
		p1 = Popen(["sudo","/usr/sbin/dmidecode"], stdout=PIPE, universal_newlines=True)
		p2 = Popen("awk" + " -F: " + awkParam, stdin=p1.stdout, shell=True, stdout=PIPE, universal_newlines=True)
		p3 = Popen("sed " +  sedParam, stdin=p2.stdout, shell=True, stdout=PIPE, universal_newlines=True)

		awkParam = r"'{print $1}'"
		p4 = Popen("awk " + awkParam, stdin=p3.stdout, shell=True, stdout=PIPE, universal_newlines=True)
		vendor = p4.communicate()[0].strip()

		return vendor
	except:
		print "UNKNOWN -- cannot retrieve vendor indentification"
		raise SystemExit, UNKNOWN
		
def ibmInfo():
	def isDate(isdate):
		if len(isdate) == 10 and isdate.find('-') == 4 and isdate.find('-',5,9) == 7:
			return True
		else:
			return False
	
	def getType(awkParam,awkFS):
		try:
			p1 = Popen(["sudo","/usr/sbin/dmidecode"], stdout=PIPE, universal_newlines=True)
			p2 = Popen("awk" + " -F" + awkFS + awkParam, stdin=p1.stdout, shell=True, stdout=PIPE, universal_newlines=True)
			output = p2.communicate()[0].strip()[0:4]
			return output
		except:
			print "UNKNOWN -- cannot retrieve system type"
			raise SystemExit, UNKNOWN


	#Parameters for both functions are an empty list, parameters for awk, and the awk field separator (FS)
	type = getType(r"'/Product Name/ {print $2}'","[ ")
	serial = getSerial(r"'/Serial Number/ {print $2}'",": ")

	url = "http://www-307.ibm.com/pc/support/site.wss/warrantyLookup.do?type=%s&serial=%s&country=897&iws=off&sitestyle=lenovo" % (type,serial)
	p1 = Popen(["curl","--silent",url],stdout=PIPE,universal_newlines=True)
	p2 = Popen(["tr","'>'","'\n'"], stdout=PIPE,stdin=p1.stdout, universal_newlines=True)
	for line in p2.stdout.readlines():
		lineA= line.split('<')
		line = lineA[0]

		isExpDate = isDate(line)
		if isExpDate:
			print("|%s|%s|%s|" % (type,serial,line))

def dellInfo():
	def isDate(isdate):
		if isdate.find('/') > 0 and isdate.find(' ') < 0 and isdate.find('dell') < 0:
			return True
		else:
			return False

	serial = getSerial(r"'/Serial Number/ {print $2}'",": ")
	
	##Use today's date to initialize these variables
	maxDate = currentDate
	startDate = currentDate

	url = "http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details?c=us&cs=RC956904&l=en&s=hied&servicetag=%s" % serial
	p1 = Popen(["curl","--silent",url],stdout=PIPE,universal_newlines=True)
	p2 = Popen(["tr","'>'","'\n'"], stdout=PIPE,stdin=p1.stdout, universal_newlines=True)
	for line in p2.stdout.readlines():
		lineA= line.split('<')
		line = lineA[0]

		isExpDate = isDate(line)
		if isExpDate:
			if datetimeStr(line) > maxDate:
				maxDate = datetimeStr(line)
			if datetimeStr(line) < currentDate:
				startDate = datetimeStr(line)
			if datetimeStr(line) > currentDate:
				#print("|%s|%s|%s|" % (serial,startDate.strftime("%Y-%m-%d"),maxDate.strftime("%Y-%m-%d")))
				return maxDate
				break

def hpInfo():
	def convertDate(dirtyDate):
		cleanDate = dirtyDate.split(' ')
		months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
		newDate = ""

		for month in months:
			if month == cleanDate[1]:
				cleanDate[1] = months.index(month) + 1
				newDate = "%s/%s/%s" % (cleanDate[1],cleanDate[0],cleanDate[2])
		return newDate

	def isDate(isdate):
		months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
		
		for month in months:
			if isdate.find(month) > 0:
				return True

		return False

	serial = getSerial(r"'/Serial Number/ {print $2}'",": ")
	sku =  getSerial(r"'/SKU/ {print $2}'",": ")

	##Use today's date to initialize these variables
	maxDate = currentDate
	startDate = currentDate

	url = "http://h20000.www2.hp.com/bizsupport/TechSupport/WarrantyResults.jsp?lang=en&cc=us&prodSeriesId=454811&prodTypeId=12454&sn=%s&pn=%s&country=US&nickname=&find=Display+Warranty+Information+" % (serial, sku)
	url = url + r"%C2%BB"
	p1 = Popen(["curl","--silent",url],stdout=PIPE,universal_newlines=True)
	p2 = Popen(["tr","'>'","'\n'"], stdout=PIPE,stdin=p1.stdout, universal_newlines=True)
	for line in p2.stdout.readlines():
		lineA= line.split('<')
		line = lineA[0]

		isExpDate = isDate(line)
		if isExpDate:
			line = convertDate(line)
			if datetimeStr(line) > maxDate:
				maxDate = datetimeStr(line)
			if datetimeStr(line) < currentDate:
				startDate = datetimeStr(line)
			if datetimeStr(line) > currentDate:
				print("|%s|%s|%s|%s|" % (serial,sku,startDate.strftime("%Y-%m-%d"),maxDate.strftime("%Y-%m-%d")))
				break
vendor = getVendor()
if vendor == "Dell":
	expDate = dellInfo()
elif vendor == "IBM":
	expDate = ibmInfo()
elif vendor == "HP":
	expDate = hpInfo()

deltaDate = expDate - currentDate
deltaDays = deltaDate.days
if currentDate > expDate:
	print "Critical -- Warranty expired", deltaDays, "days ago"
	raise SystemExit, CRITICAL
elif (deltaDate) < timedelta (days = warningThresh):
	print "Warning -- Warranty will expire in", deltaDays, " days"
	raise SystemExit, WARNING
elif (deltaDate) > timedelta (days = warningThresh):
	print "Ok -- Warranty will expire in", deltaDays, "days"
	raise SystemExit, OK
else:
	print "Unknown -- Cannot retreive information"
	raise SystemExit, UNKNOWN
