#!/bin/bash
# Script to convert output of CMC 'getmacaddress' command to MHL format
# Frans Lawaetz 8-17-2010

# $Id: chassistomhl.sh 1851 2011-02-22 23:24:05Z ali $

RAND=$RANDOM
IFS=$'\n'

if [ -z $1 ]
then
echo 'Usage: hpchassistomhl.sh <chassis_name>'
exit 1
fi

echo "What is the starting node number?  Example: 1589"
until [[ $nodenumber =~ [0-9]+ ]]
do
 read nodenumber
done

IPLIST="$(grep -w node$nodenumber /sysman/install/broad/master.host.listing)"
prodIPtmp=$(echo "$IPLIST" | egrep '10\.200\.(9[6-9]|10[0-9]|111)\.[0-9]+'|awk -F\| '{print $1}' | tr -d '#')
if [[ $prodIPtmp == "" ]]; then prodIPtmp=$(echo "$IPLIST" | egrep '69\.173\.[0-9]+\.[0-9]+'|awk -F\| '{print $1}' | tr -d '#'); fi
buildIPtmp=$(echo "$IPLIST" | egrep '192\.168\.[0-9]+\.[0-9]+' | awk -F\| '{print $1}' | awk '{print $2}')
racIPtmp=$(echo "$IPLIST" | egrep '172\.16\.[0-9]+\.[0-9]+' | awk -F\| '{print $1}')

chassis_name=$1

echo "What is the starting IP address for the PRODUCTION / VLAN32 interfaces? Example: 69.173.45.2 [$prodIPtmp]"
 
until [[ ($prodIP =~ 69\.173\.[0-9]+\.[0-9]+) || ($prodIP =~ 10\.200\.(9[6-9]|10[0-9]|111)\.[0-9]+) ]]
  do
	read prodIP
        if [[ $prodIP == "" ]]; then prodIP=$prodIPtmp; fi
done

echo "What is the starting IP address for the BUILD interface? Example: 192.168.32.200 [$buildIPtmp]"
 
until [[ $buildIP =~ 192\.168\.[0-9]+\.[0-9]+ ]]
  do
	read buildIP
        if [[ $buildIP == "" ]]; then buildIP=$buildIPtmp; fi
done


echo "What is the starting IP address for the RAC interface? Example: 172.16.255.140 [$RACIP]"
echo Remember the RAC IP addresses go from high to low.
 
until [[ $RACIP =~ 172\.16\.[0-9]+\.[0-9]+ ]]
  do
	read RACIP
        if [[ $RACIP == "" ]]; then RACIP=$racIPtmp; fi
done



#echo "Should I generate nagios entries as well? y/n"
#read nagios 
 

racslot=1
for racslot in {1..16}
do
 unset IFS
 i=( $(ssh Administrator@brsahp01a show server info $racslot 2>/dev/null | awk -F ': ' '/Ethernet MAC/ || /MAC Address/  {print $2}' | tr -d ' ') )
 buildmac=$(echo ${i[0]})
 prodmac=$(echo ${i[1]})
 racmac=$(echo ${i[2]})

 IFS=\.
 echo "$prodIP|-|${prodmac}|node${nodenumber}|-|unix_svr|g|runaround,linux,centos,centos-5,x86_64,7cc,nfshosts,$chassis_name|hp blade" >> /tmp/${RAND}.prod
 echo "$RACIP|-|$racmac|node${nodenumber}-rac|-|dhcpdevice|g|-|hp remote access controller" >> /tmp/${RAND}.rac
 echo "#xCAT# $buildIP|${buildmac}|node${nodenumber}|dell,farm,all|||" >> /tmp/${RAND}.build

 ((racslot++))
  
#echo -e "define host{\nuse\t\tnonprod-blade\n\thost_name\t\tnode${nodeumber}\n\taddress\t\tnode${nodenumber}.broadinstitute.org\n\talias\t\t${prodIP}\n\tparents\t\t


	# Split out the IP address into an array
	
	unset IFS
	prearray=`echo $prodIP | sed 's/\./ /g'`
	prodarray=($prearray)
	prearray=`echo $RACIP | sed 's/\./ /g'`
	racarray=($prearray)
	prearray=`echo $buildIP | sed 's/\./ /g'`
	buildarray=($prearray)

	IFS=\.

	if [[ ${prodarray[3]} -eq 255 ]]
 	then
 		((prodarray[2]++))
 		prodarray[3]=0
 		prodIP="${prodarray[*]}"
		echo PRODIP is $prodIP
	else
		((prodarray[3]++))
 		prodIP="${prodarray[*]}"
	fi

	if [[ ${buildarray[3]} -eq 255 ]]
 	then
 		((buildarray[2]++))
 		buildarray[3]=0
 		buildIP="${buildarray[*]}"
	else 
 		((buildarray[3]++))
 		buildIP="${buildarray[*]}"
	fi


	if [[ ${racarray[3]} -eq 0 ]]
 	then
 		((racarray[2]--))
 		racarray[3]=255
 		RACIP="${racarray[*]}"
	else 
 		((racarray[3]--))
 		RACIP="${racarray[*]}"
	fi

((nodenumber++))

done

echo -e "\n\nFor addition to master.host.listing:"
cat /tmp/${RAND}.prod

echo -e "\n\nFor addition to master.host.listing - RAC section:"
# Sort so that we get the "reverse" direction we want
cat /tmp/${RAND}.rac | sort

echo -e "\n\nFor addition to  master.host.listing - xCAT section:"
cat /tmp/${RAND}.build


