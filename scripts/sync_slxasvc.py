#!/usr/bin/env python

import site
site.addsitedir('/broad/tools/lib/python2.4/site-packages/')

import os
import sys
import cx_Oracle

from subprocess import *

basedir = '/slxa/servicedata'

ocsfile = '/broad/tools/etc/slxasync-connectstring'

def OracleConnectString(ocsfile):
    'Read an Oracle connect string from OCSFILE.'
    fp = open(ocsfile)
    ocs = fp.readline().strip()
    fp.close()
    if not '/' in ocs or not '@' in ocs:
        sys.exit("%s doesn't look like an Oracle connect string (from %s)"
                 % (ocs,ocsfile))
    return ocs

# from http://aspn.activestate.com/ASPN/Cookbook/Python/Recipe/137270
def ResultIter(cursor, arraysize=1000):
    'An iterator that uses fetchmany to keep memory usage down'
    while True:
        results = cursor.fetchmany(arraysize)
        if not results:
            break
        for result in results:
            yield result

orcl = cx_Oracle.connect(OracleConnectString(ocsfile))
curs = orcl.cursor()

curs.execute("""SELECT deck_name from decks
                where state != 'ignore'
                order by deck_name""")

for row in ResultIter(curs):
    deck = row[0]
    try:
        # want to use check_call, but that's only in 2.5
        retcode = call(["rsync","-a","--delete","%s::service/" % deck,
                        os.path.join(basedir,deck,'')])
        if retcode:
            print "retcode %s from deck %s" % (retcode,deck)
    except:
        print "couldn't rsync deck %s" % deck

