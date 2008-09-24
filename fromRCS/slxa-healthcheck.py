#!/util/bin/python

import site
site.addsitedir('/broad/tools/lib/python2.4/site-packages/')

import cx_Oracle,os,pytz,smtplib,sys
from datetime import datetime,timedelta
from email.MIMEText import MIMEText

utc = pytz.utc
local = pytz.timezone('US/Eastern')
output_fmt = '%Y-%m-%d %H:%M:%S %Z%z'

the_time = datetime.utcnow().replace(microsecond=0,tzinfo=utc)
exp_time = timedelta(hours=2)
slop_time = timedelta(minutes=5)

#ignore_these = ['SL-XAN','SL-XAR']
ignore_these = ['']

from_addr = 'apsg@broad.mit.edu'
to_addr = 'solexa-alerts@broad.mit.edu'

# from http://aspn.activestate.com/ASPN/Cookbook/Python/Recipe/137270
def ResultIter(cursor, arraysize=1000):
    'An iterator that uses fetchmany to keep memory usage down'
    while True:
        results = cursor.fetchmany(arraysize)
        if not results:
            break
        for result in results:
            yield result

orcl = cx_Oracle.connect('slxasync/c0piiRn2pr@seqprod')
curs = orcl.cursor()

messagelines = []

# decks check - last state update recent enough?
curs.execute("""SELECT deck_name, state_check_last
             FROM decks
             WHERE state != 'ignore'
             ORDER BY deck_name""")

for row in ResultIter(curs):
    (deck,d_check) = row
    if deck in ignore_these:
        continue
    try:
        d_check = d_check.replace(tzinfo=utc)
    except AttributeError:
        continue
    if d_check - slop_time > the_time:
        messagelines.append("%s: deck check in the future (%s)" %
                            (deck,d_check.astimezone(local)))
    d_check_age = the_time - d_check
    if d_check_age > exp_time:
        messagelines.append("%s: deck not checked in %s (since %s)" % (
            deck,d_check_age,d_check.astimezone(local)))

if messagelines:
    messagelines.append("--------------------------------")

# any job in PENDING is one that has been detected but not started syncing
# this is a warning sign since this can only happen when we are behind
curs.execute("""SELECT deck_name,run_name,state,log_last_changed
                FROM runs ORDER BY deck_name,log_last_changed""")

for row in ResultIter(curs):
    (deck,run,r_state,r_lastchg) = row
    if deck in ignore_these:
        continue
    try:
        r_lastchg = r_lastchg.replace(tzinfo=utc)
    except AttributeError:
        continue
    r_lastchg_age = the_time - r_lastchg
    if r_lastchg - slop_time > the_time:
        messagelines.append("%s: %s log change in the future (%s)" % (
            deck,run,r_lastchg.astimezone(local)))
    if r_lastchg_age > exp_time and r_state != 'complete' \
           and r_state != 'ignore':
        messagelines.append("%s: %s is %s aged %s (last chg %s)" % (
            deck,run,r_state,r_lastchg_age,r_lastchg.astimezone(local)))
    if r_state == 'pending':
        curs.execute("SELECT state FROM decks WHERE deck_name = :d",
                     d=deck)
        d_state = curs.fetchone()
        if d_state != ('running',):
            messagelines.append("%s: %s is %s" % (deck,run,r_state))

if messagelines:
    msg = MIMEText("\n".join(messagelines))
    msg['Subject'] = 'Solexa sync WARNING'
    msg['To'] = to_addr
    msg['From'] =from_addr
    s = smtplib.SMTP()
    s.connect('smtp.broad.mit.edu',587)
    s.sendmail(from_addr, [to_addr], msg.as_string())
    s.close()
