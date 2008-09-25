#!/usr/bin/env python

from glob import glob
from re   import search

class SolexaRun():
	"data and images from a Solexa sequencer run"

	def __init__(self, name, deck = None, images = None, data = None):
	
		def infer_deck(name):
			return search('^(.*?)_(.*?)_(.*?)_(.*)$', name).group(2)
	
		def infer_images(deck, name):
			return glob("/slxa/%s_images/transfer/mirror/%s" % (deck, name))
			
		def infer_data(deck, name):
			return glob("/seq/solexaproc/%s/analyzed/%s"     % (deck, name))
			
		self.name   = name
		self.deck   = deck   or infer_deck(name)
		self.data   = data   or infer_data(deck, name)
		self.images = images or infer_images(deck, name)
		
	def status(self):
		return self.__dict__

if __name__ == "__main__":

	from sys import argv

	print [ SolexaRun(run_id).status() for run_id in argv[1:] ]
