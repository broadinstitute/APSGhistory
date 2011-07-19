#!/usr/bin/env python
from database import Database
from dmidecode import system
from random import randint
from socket import getfqdn
from sys import exit,stderr
from time import sleep

class SystemInfo(object):

	def __init__(self):
		if '0x0100' in system():
			key='0x0100'
		else:
			key='0x0001'

		self.SKU=system()[key]['data']['SKU Number']
		self.serial=system()[key]['data']['Serial Number']
		self.product_name=system()[key]['data']['Product Name']
		self.vendor=system()[key]['data']['Manufacturer']
		self.database=Database()

	def sethostinfo(self,warranty):
		sel_sqlcode='''SELECT hostname FROM warranty
			      WHERE hostname=%s and serialnum=%s and vendor=%s'''

		self.database.curs.execute(sel_sqlcode,(warranty['hostname'],
							warranty['serial'],warranty['vendor']))

		if len(self.database.curs.fetchall()) < 1:
			ins_sqlcode='''INSERT INTO warranty (hostname,SKU,system_type,serialnum,vendor)
				   VALUES(%s,%s,%s,%s,%s)'''

			try:
				self.database.curs.execute(ins_sqlcode,(warranty['hostname'],warranty['SKU'],
								warranty['type'],warranty['serial'],
								warranty['vendor']))
			except Exception, e:
				self.database.rollback(e)
			else:
				self.database.finish()

sleep(randint(0,1200))

server=SystemInfo()
vendor=server.vendor.lower()
type=server.product_name.split('[')[1][0:4] if vendor == "ibm" else server.product_name
serial=server.serial
SKU=server.SKU

warranty_info={'SKU':SKU if vendor == 'hp' else 'N/A','type':type,
               'serial':serial,'hostname':getfqdn(),'vendor':vendor}
server.sethostinfo(warranty_info)
