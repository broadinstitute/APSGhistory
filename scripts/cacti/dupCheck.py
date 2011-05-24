#!/usr/bin/env python
import MySQLdb,re,smtplib
from email.MIMEText import MIMEText
from getpass import getuser

class DB:
	def __init__(self):
		self.userName=configDict['database_username']
		self.server=configDict['database_hostname']
		self.passwd=configDict['database_password']
		self.database=configDict['database_default']

mailList="ali@broadinstitute.org frans@broadinstitute.org teixeira@broadinstitute.org".split()
configFile="/etc/cacti/db.php"
pattern=re.compile("[;$' ]")
configDict={}
resultsDict={}
smtpServer='smtp.broadinstitute.org'

FILE=open(configFile,'r')
for line in FILE:
	if not re.match("\$",line): continue
	fields = pattern.sub('',line).split('=')
	configDict[fields[0]]=fields[1].rstrip()

db=DB()
conn=MySQLdb.connect(host=db.server,user=db.userName,passwd=db.passwd,db=db.database)
cursor=conn.cursor()
sqlCode="""SELECT host.hostname AS HostName,graph_tree.name FROM
(
	SELECT graph_tree.name AS TreeName,host.hostname AS HostName,count(host.hostname) AS HostCount FROM graph_tree
        INNER JOIN graph_tree_items ON graph_tree_items.graph_tree_id=graph_tree.id
        INNER JOIN host ON graph_tree_items.host_id=host.id
        GROUP BY HostName
        HAVING ( HostCount > 1)
) AS tree_counts
JOIN host ON tree_counts.HostName=host.hostname
JOIN graph_tree_items ON host.id=graph_tree_items.host_id
JOIN graph_tree ON graph_tree_items.graph_tree_id=graph_tree.id
ORDER BY HostName;"""
cursor.execute(sqlCode)
rows=cursor.fetchall()

for row in rows:
	(host,tree)=row
	if not resultsDict.has_key(host): resultsDict[host]=[]
	resultsDict[host].append(tree)

count=len(resultsDict)
if count == 0: sys.exit(0)

output=("%s host(s) in DB %s/%s with duplicates:" % (count,db.server,db.database))

for key in sorted(resultsDict.keys()):
	output="%s\n\t%s has entries in:" % (output,key)
	for value in resultsDict[key]:
		output="%s\n\t\t%s" % (output,value)

msg=MIMEText(output)
msg['Subject']="Cacti Duplicate Check"
msg['From']=getuser()
msg['To']=mailList

send=smtplib.SMTP(smtpServer)
send.sendmail(msg['From'],msg['To'],msg.as_string())
send.quit()
