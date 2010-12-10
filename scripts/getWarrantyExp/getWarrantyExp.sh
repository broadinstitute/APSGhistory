#!/bin/bash

#$Id:$

#Nagios Status
UNKNOWN=-1
OK=0
WARNING=1
CRITICAL=2

die_unknown()
{
	local MESSAGE=$1
	case "$MESSAGE" in
		systemid)
			echo "UNKNOWN -- cannot retrieve system identification"
			;;
		vendor)
			echo "UNKNOWN -- cannot retrieve vendor information"
			;;
		IBMtype)
			echo "UNKNOWN -- cannot retrieve system type"
			;;
	esac

	exit $UNKNOWN
		
}
getSerial()
{
	local SERIAL=$(sudo /sysman/install/dmidecode/dmidecode-2.9/dmidecode -s system-serial-number)
	[ "$?" -ne 0 ] && die_unknown systemid || echo $SERIAL
}
getVendor()
{
	local VENDOR=$(sudo /sysman/install/dmidecode/dmidecode-2.9/dmidecode -s system-manufacturer)
	[ "$?" -ne 0 ] && die_unknown vendor || echo $VENDOR
}
getIBMType()
{
	local TYPE=$(sudo /sysman/install/dmidecode/dmidecode-2.9/dmidecode -s system-product-name | cut -f2 -d[)
	[ "$?" -ne 0 ] && die_unknown IBMtype || echo "${TYPE:0:4}"
}
dateToEpoch()
{
        local DATE="$1"
        echo "$(echo "$(date -d $DATE +%s)")"
}
epochToDate()
{
        local EPOCH="$1"
        echo "$(date -d @${EPOCH} +%F)"
}
isDate()
{
	local STRING="$1"

	if date -d "$@" >/dev/null 2>&1;then
		return 0
	else
		return 1
	fi			
}
IBMInfo()
{
	local TYPE=$(getIBMType)
	local SERIAL=$SYS_SERIAL
	local URL="http://www-307.ibm.com/pc/support/site.wss/warrantyLookup.do?type=$TYPE&serial=$SERIAL&country=897&iws=off&sitestyle=lenovo"
	local PAGE="$(curl -o - --silent "$URL" | sed -e "s/<[^>]*>/\n/g"  | egrep "^(19|20)[0-9][0-9][- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$")"

	for LINE in $PAGE; do
		isDate "$LINE"

		if [ "$?" -eq 0 ]; then
			date -d "$LINE" +%F
		fi	
	done
}
DellInfo()
{
	local SERIAL=$SYS_SERIAL
	local EXP_DATE=0
	local URL="http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details?c=us&cs=RC956904&l=en&s=hea&servicetag=$SERIAL"
	 #Remove Tags and Grep Dates
	local PAGE="$(curl -o - --silent "$URL" | sed -e "s/<[^>]*>/\n/g" | egrep "^(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](20[0-9][0-9])$")"

	for LINE in $PAGE; do
		isDate "$LINE"

		if [ "$?" -eq 0 ]; then 
			if [ $EXP_DATE -lt $(dateToEpoch "$LINE") ]; then
				EXP_DATE="$(dateToEpoch "$LINE")"
			fi
		fi
	done
	
	echo "$(epochToDate $EXP_DATE)"
		
}
HPInfo()
{
	local SERIAL=$SYS_SERIAL
	local SKU="$(sudo /sysman/install/dmidecode/dmidecode-2.9/dmidecode | awk -F: '/SKU/ {print $2}' | cut -f2 -d' ')"
	local EXP_DATE=0
	local URL="http://h20000.www2.hp.com/bizsupport/TechSupport/WarrantyResults.jsp?lang=en&cc=us&prodSeriesId=454811&prodTypeId=12454&sn=$SERIAL&pn=$SKU&country=US&nickname=&find=Display+Warranty+Information+%C2%BB"
	local PAGE="$(curl -o - --silent "$URL" | sed -e "s/<[^>]*>/\n/g" | egrep "^(0[1-9]|[12][0-9]|3[01])[- /.]([A-Za-z]++)[- /.](19|20)[0-9][0-9]" | tr ' ' '-')"
	
	for LINE in $PAGE; do
		isDate "$LINE"

		if [ "$?" -eq 0 ]; then
			if [ $EXP_DATE -lt $(dateToEpoch "$LINE") ]; then
				EXP_DATE="$(dateToEpoch "$LINE")"
			fi
		fi
	done

	echo "$(epochToDate $EXP_DATE)"
}
SYS_SERIAL=$(getSerial)
SYS_VENDOR=$(getVendor)
case "$SYS_VENDOR" in
	IBM)
		echo "$(IBMInfo)"
		;;
	"Dell Inc.")
		echo "$(DellInfo)"
		;;
	HP)
		echo "$(HPInfo)"
		;;
	*)
		echo "$SYS_VENDOR"
		exit $UNKNOWN
		;;
esac
