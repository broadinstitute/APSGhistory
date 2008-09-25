#!/usr/bin/env python

from glob import glob
from re   import search
from os   import stat
from time import time

class SolexaRun:
	"data and images from a Solexa sequencer run"

	import cx_Oracle

	oracle = cx_Oracle.connect('slxasync/c0piiRn2pr@seqprod')

	def __init__(self, name,
	             deck = None, barcode = None,
	             images = None, data = None):

		self.name    = name

		parsed_name  = search('^(.*?)_(.*?)_(.*?)_(.*)$', name)

		self.deck    = deck    or parsed_name.group(2)
		self.barcode = barcode or parsed_name.group(4)
	
		def infer_images(deck, name):
			dirs = glob("/slxa/%s_images/transfer/mirror/%s" % (deck, name))

			if dirs: return dirs[0]
			else:    return None
			
		def infer_data  (deck, name):
			dirs = glob("/seq/solexaproc/%s/analyzed/%s"     % (deck, name))
			
			if dirs: return dirs[0]
			else:    return None

		self.data    = data    or infer_data  (self.deck, name)
		self.images  = images  or infer_images(self.deck, name)
		
	def image_status(self):
		"Can the images from the run be marked as expired?"

		LIFETIME = 60 * 60 * 24 * 14

		if not self.images: return 'missing'
		
		if stat(self.images).st_mtime + LIFETIME > time(): return 'fresh'

		return self.__dict__

if __name__ == "__main__":

	from sys import argv

	print [ SolexaRun(run_id).image_status() for run_id in argv[1:] ]
