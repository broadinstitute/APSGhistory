#!/bin/bash

# This script converts a SuSE server to get it's entire network 
# configuration from dhcp. You better have preconfigured mhl before 
# running this or it will reboot the node into oblivion and you'll
# have to go to the console or access over the 192.168 address on
# the build network to fix.

IFCONFIG=/sbin/ifconfig
# files to back up.
OLDCONFIG="/etc/HOSTNAME /etc/resolv.conf /etc/yp.conf /etc/defaultdomain /etc/ntp.conf /etc/sysconfig/network/dhcp /etc/hosts"

DATE=`date "+%s"`
BKUPDIR=/root/dhcpconfig-${DATE}

# Find the correct interface(s) to switch to dhcp
DHCPNICS=""
for nic in `${IFCONFIG} -a | awk '/^eth/ {print $1}'`
  do
    # Grab ipaddr so we can rule out the managment/build network nic
    IPADDR=`${IFCONFIG} $nic | awk '/inet addr:/ { print $2;}' | cut -d':' -f2`
    # Test if in Build Network
    if echo $IPADDR | egrep -q "18\.103\."; then
      DHCPNICS="${DHCPNICS}${nic} "
      OLDCONFIG="${OLDCONFIG} /etc/sysconfig/network/ifcfg-${nic}"
    fi
  done

# Make a backup of the old configuration
mkdir -p $BKUPDIR
for file in $OLDCONFIG
  do
    mv $file $BKUPDIR
  done

# Switch nic to dhcp
for nic in ${DHCPNICS}
  do
    NICCFG="DEVICE=${nic}\nSTARTMODE=onboot\nONBOOT=yes\nBOOTPROTO=dhcp\n"
    # Get MTU 
    NICCFG=${NICCFG}`${IFCONFIG} $nic | awk '/MTU/ {print $5}' | tr ':' '='`"\n"
    # Get any ethtool options that may be in use on this node.
    NICCFG="${NICCFG} "`egrep "ETHTOOL_OPTIONS" /etc/sysconfig/network/ifcfg-$nic`"\n" 

    echo -e $NICCFG > /etc/sysconfig/network/ifcfg-$nic
  done

# Generic /etc/hosts
cat << EOF > /etc/hosts
127.0.0.1       localhost
EOF

# Create a new dhcp client configuration, enable nis, ntp, resolv,conf and hostname
cat << EOF >/etc/sysconfig/network/dhcp
## Path:	Network/DHCP/DHCP client
## Description:	DHCP configuration tweaking
#
# Note: 
# To configure one or more interfaces for DHCP configuration, you have to
# change the BOOTPROTO variable in /etc/sysconfig/network/ifcfg-<interface> to
# 'dhcp' (and possibly set STARTMODE='onboot'). 
#
# Most of these options are used only by dhcpcd, not by the ISC dhclient (which 
# uses a config file).
#
# Most of the options can be overridden by setting them in the ifcfg-* files,
# too.

## Type:	string
## Default:	""
## ServiceRestart: network
#
# Which DHCP client should be used? 
# If empty, dhcpcd is tried, then dhclient 
# Other possible values:
# 	dhcpcd   (DHCP client daemon)
# 	dhclient (ISC dhclient)
DHCLIENT_BIN=""

## Type:	yesno
## Default:	no
#
# Start in debug mode? (yes|no)
# (debug info will be logged to /var/log/messages for dhcpcd, or to
# /var/log/dhclient-script for ISC dhclient)
#
DHCLIENT_DEBUG="yes"

## Type:	yesno
## Default:	no
#
# Should the DHCP client set the hostname? (yes|no)
# 
# When it is likely that this would occur during a running X session, 
# your DISPLAY variable could be screwed up and you won't be able to open
# new windows anymore, then this should be "no". 
#
# If it happens during booting it won't be a problem and you can 
# safely say "yes" here. For a roaming notebook with X kept running, "no"
# makes more sense. 
#
DHCLIENT_SET_HOSTNAME="yes"

## Type:	yesno
## Default:	yes
#
# Should the DHCP client modify /etc/resolv.conf at all? 
# If not, set this to "no". (The default is "yes") 
#
# resolv.conf will also stay untouched when MODIFY_RESOLV_CONF_DYNAMICALLY 
# in /etc/sysconfig/network/config is set to "no". 
#
DHCLIENT_MODIFY_RESOLV_CONF="yes"

## Type:	yesno
## Default:	yes
#
# Should the DHCP client set a default route (default Gateway) (yes|no)
#
# When multiple copies of dhcpcd run, it would make sense that only one
# of them does it. 
#
DHCLIENT_SET_DEFAULT_ROUTE="yes"

## Type:	yesno
## Default:	no
#
# Should the DHCP client modify the NTP configuration? (yes|no)
#
# If set to yes, /etc/ntp.conf is rewritten (and restored upon exit).
# If you don't want this, set this variable to "no". (The default is "no") 
#
DHCLIENT_MODIFY_NTP_CONF="yes"

## Type:	yesno
## Default:	no
#
# Should the DHCP client modify the NIS configuration? (yes|no)
#
# If set to yes, /etc/yp.conf is rewritten (and restored upon exit).
# If you don't want this, set this variable to "no". (The default is "no") 
#
DHCLIENT_MODIFY_NIS_CONF="yes"

## Type:	yesno
## Default:	yes
#
# Should the DHCP client set the NIS domainname? (yes|no)
# (if the server supplies the nis-domain option)
#
DHCLIENT_SET_DOMAINNAME="yes"

## Type:	yesno
## Default:	no
#
# When writing a new /etc/resolv.conf, should the DHCP client take an 
# existing searchlist and add it to the one derived from the DHCP server? 
# (yes|no)
#
DHCLIENT_KEEP_SEARCHLIST="no"

## Type:	integer
## Default:	""
#
# Lease time to request ( -l option)
#
# Specifies (in seconds) the lease that is suggested to the server. 
# The default is infinite. For a mobile computer you probably want to
# set this to a lower value.
#
DHCLIENT_LEASE_TIME=""

## Type:	integer
## Default:	999999
#
# (only dhcpcd does use this setting)
#
# You can set the timeout (dhcpcd will terminate after this time when it 
# does not get a reply from the server). 
#
# The default timeout of dhcpcd is 60 seconds. However, we'll set it to a 
# much longer time. dhcpcd will then run as a daemon in the background and
# broadcast a DHCPDISCOVER once in a while, trying to get a lease.
#
DHCLIENT_TIMEOUT="999999"

## Type:	integer
## Default:	""
#
# (only dhcpcd does use this setting)
#
# INIT-REBOOT timeout ( -z option)
#
# This timeout is specifically to control how long dhcpcd tries to reacquire
# a previous lease (init-reboot state), before it starts getting a new one. 
# Default: 10
#
DHCLIENT_REBOOT_TIMEOUT=""

## Type:	string
## Default:	AUTO
#
# specify a hostname to send ( -h option)
#
# specifies a string used for the hostname option field when dhcpcd sends DHCP
# messages. Some DHCP servers will update nameserver entries (dynamic DNS).
# Also, some DHCP servers, notably those used by @Home Networks, require the
# hostname option field containing a specific string in the DHCP messages from
# clients.
#
# By default the current hostname is sent ("AUTO"), if one is defined in 
# /etc/HOSTNAME. 
# Use this variable to override this with another hostname, or leave empty
# to not send a hostname.
#
DHCLIENT_HOSTNAME_OPTION=""

## Type:	string
## Default:	""
#
# specify a client ID ( -I option)
#
# Specifies a client identifier string. By default the hardware address of the
# network interface is sent as client identifier string, if none is specified
# here.
#
# Note that dhcpcd will prepend a zero to what it sends to the server. In the
# server configuration, you need to write the following to match on it:
#  option dhcp-client-identifier "\0foo";
#
DHCLIENT_CLIENT_ID=""

## Type:	string("dhcpcd dhclient")
## Default:	""
#
# specify a vendor class ID ( -i option)
#
# Specifies the vendor class identifier string.  dhcpcd uses the default vendor
# class identifier string (system name, system release, and machine type) if it
# is not specified.
#
DHCLIENT_VENDOR_CLASS_ID=""

## Type:	yesno
## Default:	no
#
# Send a DHCPRELEASE to the server (sign off the address)? (yes|no)
# This may lead to getting a different address/hostname next time an address
# is requested. But some servers require it.
#
DHCLIENT_RELEASE_BEFORE_QUIT="no"

## Type:	string
## Default:	""
#
# Run this script when the interface is brought up, down, or the IP address
# changes ( -c option)
#
# per default, /etc/sysconfig/network/scripts/dhcpcd-hook is run
#
DHCLIENT_SCRIPT_EXE=""

## Type:	yesno
## Default	yes
#
# Force dhcpcd to calculate UDP checksum on received packets. (yes|no)
# This corresponds to dhcpcd's -C option.
#
DHCLIENT_UDP_CHECKSUM="yes"

## Type:	string
## Default:	""
#
# additional options, e.g. "-B"
#
DHCLIENT_ADDITIONAL_OPTIONS=""

## Type:	integer
## Default:	0
#
# Some interfaces need time to initialize. Add the latency time in seconds
# so these can be handled properly. Should probably set per interface rather than here.
#
DHCLIENT_SLEEP="0"

## Type:	integer
## Default:	5
#
# When the DHCP client is started at boot time, the boot process will stop
# until the interface is successfully configured, but at most for
# DHCLIENT_WAIT_AT_BOOT seconds.
#
DHCLIENT_WAIT_AT_BOOT="30"
EOF


