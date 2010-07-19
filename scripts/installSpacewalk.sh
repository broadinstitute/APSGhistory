#!/bin/bash
# Simple script to install spacewalk
# 6/24/10

#Auto-set arch
BASEARCH=$(uname -i)

#obtain required repos
rpm -Uvh http://spacewalk.redhat.com/yum/1.0/RHEL/5/$BASEARCH/spacewalk-client-repo-1.0-2.el5.noarch.rpm
rpm -Uvh http://download.fedora.redhat.com/pub/epel/5/$BASEARCH/epel-release-5-3.noarch.rpm

#install the good stuff
yum -y install rhn-client-tools rhn-check rhn-setup rhnsd m2crypto yum-rhn-plugin osad

#register system on spacewalk
rhnreg_ks --serverUrl=http://vspacewalk.broadinstitute.org/XMLRPC --activationkey=1-CentOSBroad

yum clean all
yum -y upgrade
yum clean all
