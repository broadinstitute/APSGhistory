#!/bin/bash
# Script to convert output of CMC 'getmacaddress' command to MHL format
# Frans Lawaetz 8-17-2010

# $Id$

RAND=$RANDOM
IFS=$'\n'

if [ -z $1 ]
then
echo 'Usage: chassistomhl.sh <chassis_name>'
exit 1
fi

chassis_name=$(echo $1 | sed 's/brsa/ufarm/g')
if [[ $chassis_name != ufarm[0-9][0-9] ]]; then
	echo 'Invalid Chassis' && exit 1
fi

echo "What is the starting IP address for the PRODUCTION / VLAN32 interfaces? Example: 69.173.45.2"
 
until [[ $prodIP =~ 69\.173\.[0-9]+\.[0-9]+ ]]
  do
	read prodIP
done

echo What is the starting IP address for the BUILD interface? Example: 192.168.32.200
 
until [[ $buildIP =~ 192\.168\.[0-9]+\.[0-9]+ ]]
  do
	read buildIP
done


echo What is the starting IP address for the RAC interface? Example: 172.16.255.140
echo Remember the RAC IP addresses go from high to low.
 
until [[ $RACIP =~ 172\.16\.[0-9]+\.[0-9]+ ]]
  do
	read RACIP
done


echo "What is the starting node number?  Example: 1589"
until [[ $nodenumber =~ [0-9]+ ]]
do
 read nodenumber
done

#echo "Should I generate nagios entries as well? y/n"
#read nagios 
 

racslot=1
for i in `ssh service@$1 getmacaddress | grep Server- | tr [:upper:] [:lower:]`
do
 unset IFS
 prodmac=`echo $i | awk '{printf $5}'`
 buildmac=`echo $i | awk '{printf $4}'`
 racmac=`echo $i | awk '{printf $3}'`

 IFS=\.
 echo "$prodIP|-|${prodmac}|node${nodenumber}|-|unix_svr|g|runaround,linux,centos,centos-5,x86_64,7cc,nfshosts,$chassis_name|dell blade" >> /tmp/${RAND}.prod
 echo "$RACIP|-|$racmac|node${nodenumber}-rac|-|dhcpdevice|g|-|dell remote access controller" >> /tmp/${RAND}.rac
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

echo -e "\n\nFor addition to /etc/hosts on hal9000"
cat /tmp/${RAND}.build


