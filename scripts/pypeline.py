#!/usr/bin/env python

from glob import glob
from time import time

import os, re

class SolexaRun:
	"data and images from a Solexa sequencer run"

	import cx_Oracle
	
	ocs_file = '/broad/tools/etc/seq20-connectstring'
 	oracle   = cx_Oracle.connect(open(ocs_file).readline().strip())

	def __init__(self, name, images = None, data = None):

		self.name    = name
		parsed_name  = re.search('^(.*?)_(.*?)_(.*?)_(.*)$', name)
		if not parsed_name: raise name
		deck         = parsed_name.group(2)

		self.images = images
		if not images:
			dirs = glob("/slxa/%s_images/transfer/mirror/%s" % (deck, name))
			if dirs: self.images = dirs[0]
			else:    raise 'images directory not found for run %s' % name
			
		recipes = glob('%s/Recipe*' % self.images)
		if not recipes:      raise "recipe not found for %s"       % name
		if len(recipes) > 1: raise "multiple recipes found for %s" % name
		
		read_type, no_cycles = None, None
		
		recipe = open(recipes[0])
		for line in recipe:
			rtm = re.search("<!--\s+Read Type: (.*)\s+-->", line)
			ncm = re.search("<!--\s+No\. Cycles: (\d+)\s+-->", line)
			if rtm: read_type = rtm.group(1)
			if ncm: no_cycles = int(ncm.group(1))
		recipe.close
		
		self.cycles = no_cycles
		self.paired = (read_type == "Paired End")

	def analysis_pending(self):
		"analysis directories that we care about that are not finished"

		def relevant(name):
			match = re.search('^C1-(\d+)_Firecrest.*_prodinfo$',
			 				  os.path.split(name)[-1])
			if not match: return False

			cycles = int(match.group(1))

			if (cycles == self.cycles):                       return True
			if (cycles == self.cycles * 2) and (self.paired): return True
		
		def pending(name):
			return not os.path.isfile("%s/finished.txt" % name)
			
		analyses = glob("%s/Data/C*_prodinfo" % self.images)
		
		return [ os.path.split(path)[-1]
				 for path in filter(relevant, filter(pending, analyses)) ]
		
	def image_status(self):
		"Can the images from the run be marked as expired?"

		if not self.images: return 'missing'

		pending = self.analysis_pending()

		LIFETIME = 60 * 60 * 24 * 14

		if pending: return 'waiting for analysis in %s' % ' '.join(pending)
		elif os.stat(self.images).st_mtime + LIFETIME > time(): return 'fresh'
		else: return 'expired'

if __name__ == "__main__":

	from sys import argv

	runs = [ SolexaRun(run_id) for run_id in argv[1:] ]

	for run in runs:
		print "%s: %s" % (run.images, run.image_status())
