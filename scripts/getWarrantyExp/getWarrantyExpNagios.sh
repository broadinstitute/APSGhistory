#!/bin/bash

CURRENT_DATE="$(echo "$(date +%s)/86400" | bc)"

#Nagios Status
UNKNOWN=-1
OK=0
WARNING=1
CRITICAL=2

while getopts "w:" flag; do
	WARNING_LEVEL=$OPTARG
done

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
dateToDays()
{
	local DATE="$1"
	echo "$(echo "$(date -d $DATE +%s)/86400" | bc)"
}
getSerial()
{
	local SERIAL=$(dmidecode -s system-serial-number)
	[ "$?" -ne 0 ] && die_unknown systemid || echo $SERIAL
}
getVendor()
{
	local VENDOR=$(dmidecode -s system-manufacturer)
	[ "$?" -ne 0 ] && die_unknown vendor || echo $VENDOR
}
getIBMType()
{
	local TYPE=$(dmidecode -s system-product-name | cut -f2 -d[)
	[ "$?" -ne 0 ] && die_unknown IBMtype || echo "${TYPE:0:4}"
}
isDate()
{
	local STRING="$1"

	case "$SYS_VENDOR" in
		IBM)
			if [ "${#STRING}" -eq 10 ] && [ "$(expr index "$STRING" "-")" -eq 5 ] && [ "$(expr index "${STRING:6:4}" "-")" -eq 2 ]; then
				return 0
			else
				return 1
			fi
			;;
		"Dell Inc.")
			if [[ "${#STRING}" -lt 8 || "$(expr index "$STRING" "\\")" -gt 0 ]]; then
				return 1
			elif [[ "${#STRING}" -eq 8  && "$(expr index "$STRING" "/")" -eq 2 ]]; then
				return 0
			elif [[ "${#STRING}" -eq 9  && "$(expr index "$STRING" "/")" -eq 3 ]]; then
				return 0
			elif [[ "${#STRING}" -eq 9 && "$(expr index "${STRING:3:6}" "/")" -eq 2 ]]; then
				return 0
			elif [[ "${#STRING}" -eq 10  && "$(expr index "$STRING" "/")" -eq 3 ]]; then
				return 0
			else
				return 1
			fi
			;;
	esac
}
splitString()
{
	OIFS=$IFS
	IFS=';' read -ra ADDR <<< "$1"

	IFS=$OIFS
	echo ${STRING[1]}
}
IBMInfo()
{
	local TYPE=$(getIBMType)
	local SERIAL=$SYS_SERIAL

	local URL="http://www-307.ibm.com/pc/support/site.wss/warrantyLookup.do?type=$TYPE&serial=$SERIAL&country=897&iws=off&sitestyle=lenovo"
	local PAGE="$(curl -o - --silent "$URL" | tr '>' '\n' | tr '<' '\n')"
	for LINE in $PAGE; do
		isDate "$LINE"

		if [ "$?" -eq 0 ]; then
			echo "$LINE"
		fi	
	done
}
DellInfo()
{
	local SERIAL=$SYS_SERIAL

	local EXP_DATE=0

	local URL="http://support.dell.com/support/topics/global.aspx/support/my_systems_info/details?c=us&cs=RC956904&l=en&s=hied&servicetag=$SERIAL"
	local PAGE="$(curl -o - --silent "$URL" | tr '>' '\n' | tr '<' '\n')"
	for LINE in $PAGE; do
		isDate "$LINE"

		if [ "$?" -eq 0 ]; then 
			EXP_DATE="$(dateToDays "$LINE")"
			if [ $EXP_DATE -gt $(dateToDays "$LINE") ]; then
				$EXP_DATE=$LINE
			fi
		fi
	done

	echo "$EXP_DATE"
		
}
SYS_SERIAL=$(getSerial)
SYS_VENDOR=$(getVendor)
case "$SYS_VENDOR" in
	IBM)
		EXPIRE_DATE=$(dateToDays "$(IBMInfo)")
		;;
	"Dell Inc.")
		EXPIRE_DATE="$(DellInfo)"
		;;
esac

DELTA_DAYS=$(($EXPIRE_DATE - $CURRENT_DATE))
if [ $DELTA_DAYS -lt 0 ]; then
	echo "Critical -- Warranty Expired ${DELTA_DAYS#-} days ago"
	exit $CRITICAL
elif [ $DELTA_DAYS -lt $WARNING_LEVEL ]; then
	echo "Warning -- Warranty will expire in $DELTA_DAYS days"
	exit $WARNING
elif [ $DELTA_DAYS -gt $WARNING_LEVEL ]; then
	echo "OK -- Warranty will expire in $DELTA_DAYS days"
	exit $OK
else
	echo "UNKNOWN -- Cannot Retrieve Information"
	exit $UNKNOWN
fi
