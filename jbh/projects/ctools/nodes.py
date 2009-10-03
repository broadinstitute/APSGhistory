import re
from netaddr import *

class NetworkInterface:
    def __init__(self, mac, ipaddr = None, hostname = None, cnames = [], ipaliases = []):
        # Define data structures for a Network Interface
        # Create a new EUI object even if passed an EUI object
        self.mac = EUI(mac.__str__())

        # Primary IP address
        if ipaddr is None:
            self.ipaddr = None
        else:
            self.ipaddr = IPAddress(ipaddr)

        # Hostname
        self.hostname = hostname

        # CNAME Aliases
        self.cnames = cnames

        # IP Aliases
        self.ipaliases = []
#        for ipalias in ipaliases:
#            self.ipaliases.append(IPAddress(ipalias))

    def __repr__(self):
        return "|".join([str(self.mac), str(self.ipaddr), str(self.hostname)])
#, ','.join(self.cnames)])

class Node:
    def __init__(self, vendorid, chassisid = None, slot = None):
        # Define data structures for a Node
        # Unique Vendor ID for node. Usually service 
        self.vendorid = vendorid
        # ChassisID if in chassis
        self.chassisid = chassisid
        # Slot if Node is in a chassis
        self.slot = slot
        # Dictionary of ethernet devices
        self.ethernet = {}


    def __repr__(self):
        mystr = self.vendorid + "|" + str(self.slot)
        for nic in self.ethernet.keys():
            mystr += "\n\t" + nic + "\t" + str(self.ethernet[nic])
        return mystr

    def powerman_node(self):
        # Return a string of the form: node "vendorid" "chassisid" "slot"
        mystr = 'node "%s" "%s" "%d"' % ( self.vendorid, self.chassisid, self.slot )
        return mystr

    def powerman_aliases(self):
        # Return a list of strings of the form: alias "aliasname" "vendorid"
        # or return empty list if there are no aliases.
        myaliases = []
        for nic in self.ethernet.keys():
            if self.ethernet[nic].hostname:
                myaliases.append('alias "%s" %s"' % ( self.ethernet[nic].hostname, self.vendorid ))
                for cname in self.ethernet[nic].cnames:
                    myaliases.append('alias "%s" %s"' % ( cname, self.vendorid ))
        return myaliases

    # Functions to aid in inserting data.
    def setvendorid(self, id):
        if self.vendorid is not None:
            print "WARNING: Resetting vendorid", self.vendorid, "to", id
        self.vendorid = id

    def setchassisid(self, chassisid):
        if self.chassisid is not None:
            print "WARNING: Resetting chassisid", self.chassisid, "to", chassisid
        self.chassisid = chassisid

    def setslot(self, slot):
        if self.slot is not None:
            print "WARNING: Resetting slot", self.slot, "to", slot
        self.slot = slot

    def addnic(self, name, mac, ipaddr = None, hostname = None, cnames = None, ipaliases = None):
        if name in self.ethernet.keys():
            print "ERROR: ", name, "already exists in ethernet list"
        else:
            self.ethernet[name] = NetworkInterface(mac, ipaddr, hostname, cnames, ipaliases)
    
    


