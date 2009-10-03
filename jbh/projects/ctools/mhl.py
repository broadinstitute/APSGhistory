import re
from netaddr import *

class MhlInfo:
    def __init__(self):
        self.hostname = None
        self.ipaddr = None
        self.aliases = []

    def __repr__(self):
        return "|".join([self.hostname, self.ipaddr, ','.join(self.aliases)])

    def sethostname(self, hostname):
        if self.hostname is None:
            self.hostname = hostname
        else:
            print "ERROR: Attempted to replace hostname", self.hostname, "with", hostname

    def setipaddr(self, ipaddr):
        if self.ipaddr is None:
            self.ipaddr = ipaddr
        else:
            print "ERROR: Attempted to replace IP address", self.ipaddr, "with", ipaddr

    def addalias(self, alias):
        self.aliases.append(alias)


def buildmhldict ():
    mhlfile = open("//sysman/install/broad/master.host.listing", 'r')
    mhlraw = mhlfile.readlines()
    mhlfile.close()

    commentre = re.compile("^#.*$") 
    macre = re.compile("([a-fA-F0-9]{2}[:|\-]?){6}")
    ipre = re.compile("^(\d{1,3}\.){3}\d{1,3}")
    emptyre = re.compile("^\s*$")

    mhldict = {}

    for line in mhlraw:
        if not commentre.match(line) and not emptyre.match(line):
            (ip, sip, mac, namelist, ttl, type, location, dhcpoptions, comment) = line.lower().split("|")

            if mac is not None and macre.match(mac):
                macaddr = EUI(mac)
                mhldict[macaddr] = MhlInfo()
                names = namelist.split(',')
                mhldict[macaddr].sethostname(names[0])
                for a in names[1:]:
                    mhldict[macaddr].addalias(a)
                mhldict[macaddr].setipaddr(ip)

    return mhldict


if __name__ == "__main__":
    import sys
    mhldict = buildmhldict()
    for entry in mhldict.keys():
       print entry, mhldict[entry]
