#!/usr/bin/env python
from decimal import Decimal
from math import ceil
from optparse import OptionParser
from subprocess import PIPE,Popen
from sys import argv,exit

nagios_codes = dict(OK=0, WARNING=1, CRITICAL=2, UNKNOWN=3)
inscript='/home/unix/matter/sandbox/irods/irods_archiveuse'

class Ddict(dict):
    def __init__(self, default=None):
        self.default = default

    def __getitem__(self, key):
        if not self.has_key(key): self[key] = self.default()
        return dict.__getitem__(self, key)

def usage():
    nagios_return('UNKNOWN', 'usage: %s -h host -w warning -c critical\n%s'%
    (format(argv[0]), test_list()))

def nagios_return(code, response):
    print(code + ": " + response)
    exit(nagios_codes[code])

share_dict=Ddict(dict)

parser = OptionParser()
parser.add_option('-s', '--share', dest='share')
parser.add_option('-c', '--critical', dest='critlevel')
parser.add_option('-w', '--warning', dest='warnlevel')

(options,args)=parser.parse_args()

# Check for required options
for option in ('share', 'critlevel','warnlevel'):
    if not getattr(options, option):
        nagios_return('CRITICAL', '- %s not specified' % option.capitalize())
        raise SystemExit, CRITICAL

share=options.share
warnlevel=int(options.warnlevel)
critlevel=int(options.critlevel)

output=Popen(inscript,stdout=PIPE).communicate()[0].replace('"','').split('\n')

for line in output:
    if share not in line: continue
    fields=line.split(':')
    if len(fields) < 3: continue
    if len(fields) > 3: nagios_return('UNKNOWN', '- field number mismatch')
    (share,type,size)=fields
    share_dict[share][type.replace('"','')]=size

free_percentage=Decimal(share_dict[share]['used'])/Decimal(share_dict[share]['total'])
free_percentage=int(ceil(free_percentage*100))
used_percentage=100-free_percentage

free_space=Decimal(share_dict[share]['total'])-Decimal(share_dict[share]['used'])

if used_percentage > warnlevel:
    nagios_return('OK','%s' % free_space + 
                    ' (%s' % used_percentage + '%) available')
elif warnlevel >= used_percentage >= critlevel:
    nagios_return('WARNING','%s' % free_space + 
                    ' (%s' % used_percentage + '%) available')
elif critlevel >= used_percentage:
    nagios_return('CRITICAL','%s' % free_space + 
                    ' (%s' % used_percentage + '%) available')
