#!/usr/bin/env python

import sys
import os
import string
import getopt
import pxssh

hostspecs = {}
allhosts = []
hosts = []
cmd = ''
interactive = False

def Usage(message="Help"):
    print message
    print "Usage: runaround2 [-a|--all] [-I] [-h|--host hostname[,hostname]] [-H|--keyword keyword] [-x|--host-exclude hostname[,hostname]] [-X|--keyword-exclude keyword] command"
    sys.exit()

def Init():
    global hosts
    global cmd
    global interactive

    # Get arguments
    try:
        opts,args = getopt.getopt(sys.argv[1:],"aIe:h:H:x:X:q:", 
                    ['all', 'hosts=', 'keyword=', 'hosts-exclude=', 
                    'keyword-exclude='])
    except (NameError, getopt.GetoptError):
        Usage("Error parsing command line arguments.")

    # Check command line options
    if not args:
        cmd = " 'uptime' "
    else:
        cmd = " '" + string.join(args," ") + "'"

    for opt in opts:
        optname,optval = opt

        # -a|--all  include all known hosts
        if optname == "-a" or optname == "--all":
            hosts = hostspecs.keys()

        # -I  Interactive
        if optname == "-I":
            interactive = True

        # -h|--hosts  host1,host2,host3,... (include hosts)
        elif optname == "-h" or optname == "--hosts":
            hosts.extend(string.split(optval,","))
            hosts = list(set(hosts))
            for host in hosts:
                if not allhosts.count(host):
                    hosts.remove(host)
                    print host, " not valid, is it disabled in runaround.conf?"

        # -H|--keyword  keyword (include hosts)
        elif optname == "-H" or optname == "--keyword":
            newhosts = []
            for host in allhosts:
                try:
                    if hostspecs[host].count(optval):
                        newhosts.append(host)
                except KeyError:
                    print host, " not valid, is it disabled in runaround.conf?"
                    continue
            hosts.extend(newhosts)
            hosts = list(set(hosts)) 

        # -x|--hosts-exclude  host1,host2,host3,... (exclude hosts)
        elif optname == "-x" or optname == "--hosts-exclude":
            removehosts = string.split(optval,",")
            for rmhost in removehosts:
                try:
                    hosts.remove(rmhost)
                except ValueError:
                    continue

        # -X|--keyword-exclude   keyword (exclude hosts)
        elif optname == "-X" or optname == "--keyword-exclude":
            removehosts = []
            for host in hosts:
                try:
                    if hostspecs[host].count(optval):
                        removehosts.append(host)
                except KeyError:
                    print host, " not valid, is it disabled in hosts.conf?"
                    continue
            for rmhost in removehosts:
                try:
                    hosts.remove(rmhost)
                except ValueError:
                    continue

        # -q (quiet, no output except for command output)
        elif optname == "-q":
            quiet = 1
            
        # Bad option or argument encountered
        else:
            Usage()

    if len(hosts) == 0:
        Usage("Empty host list.")

# Get the host db from it's file.
execfile('hostdb.conf')
allhosts = hostspecs.keys()

# Parse the options
Init()

username = os.environ['USER']
if username == 'root':
    prompt = '#'
else:
    prompt = '$'

sessions = {}
for host in hosts:
    session = pxssh.pxssh()
    print "Connecting to ", host, " as ", username, " looking for prompt: ", prompt
    session.login(host + ".broad.mit.edu", username, '', 'ansi', prompt)
    sessions[host] = session
    print "Connected."

while True:
    sys.stdout.write("\nmssh> ")
    line = sys.stdin.readline()
    for session in sessions.keys():
        sessions[session].sendline(line)
        sessions[session].prompt()
        print "=======================" + session + "========================="
        print sessions[session].after

for session in sessions:
    session.logout()

