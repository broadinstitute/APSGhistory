#!/util/bin/python

import sys

sys.path.append('/broad/tools/lib/python2.4/site-packages/')
import cx_Oracle,os,sys

# from http://aspn.activestate.com/ASPN/Cookbook/Python/Recipe/137270
def ResultIter(cursor, arraysize=1000):
    'An iterator that uses fetchmany to keep memory usage down'
    while True:
        results = cursor.fetchmany(arraysize)
        if not results:
            break
        for result in results:
            yield result

orcl = cx_Oracle.connect('slxasync/c0piiRn2@seqdel1')
curs = orcl.cursor()

if len(sys.argv) > 1:
    run = sys.argv[1].upper()
else:
    sys.exit('must provide run name on command line')

curs.execute("SELECT * FROM runs")

for row in ResultIter(curs):
    print row

print '---------------'

curs.execute('''DELETE FROM runs r WHERE r.run_name = :rname''',
             rname=run)
orcl.commit()

curs.execute("SELECT * FROM runs")

for row in ResultIter(curs):
    print row
