#!/bin/bash

#Functions
startDate(){
	local START_DATE=$(date -d @$(($(date +%s) + 60)) "+%x %H:%M:%S" | sed -e 's/\//-/g')
	echo $START_DATE
}

endDate(){
	local END_DATE=$(date -d @$(($(date +%s) + $((MINUTES*60)))) "+%x %H:%M:%S" | sed -e 's/\//-/g')
	echo $END_DATE
}

#Arg Variable Block
HOST=$1
USER=$2
ACTION=$(echo $3 | tr '[:upper:]' '[:lower:]')
MINUTES=$4
if [[ $# -lt 3 ]]; then
	echo "Usage:"
	echo "hush_new.sh \$HOST \$USER \$ACTION"
	exit 1
elif [[ $# -gt 3 && $3 != 'downtime' ]]; then
	echo "Usage:"
	echo "hush_new.sh \$HOST \$USER \$ACTION"
	exit 1
elif [[ $# -eq 3 && $3 = 'downtime' ]]; then
	echo "Usage:"
	echo "hush_new.sh \$HOST \$USER \$ACTION \$MINUTES"
	exit 1
fi

#Password Input
stty -echo
read -p "Password: " PASSW; echo 
stty echo

#App Variables
NAGIOS_URL="https://systems.broadinstitute.org/nagios/cgi-bin/cmd.cgi"
if [ -z $MINUTES ]; then
	MINUTES=1
fi

case $ACTION in
	disable)
		curl -u $USER:$PASSW -d "cmd_typ=29&cmd_mod=2&host=$HOST&&btnSubmit=Commit" "$NAGIOS_URL"
		;;
	enable)
		curl -u $USER:$PASSW -d "cmd_typ=28&cmd_mod=2&host=$HOST&&btnSubmit=Commit" "$NAGIOS_URL"
		;;
	downtime)
		curl -u $USER:$PASSW -d "cmd_typ=86&cmd_mod=2&host=$HOST&com_author=$USER&com_data=automatic downtime entry&minutes=$MINUTES&fixed=1&start_time=$(startDate)&end_time=$(endDate)&&btnSubmit=Commit" "$NAGIOS_URL"
		curl -u $USER:$PASSW -d "cmd_typ=55&cmd_mod=2&host=$HOST&com_author=$USER&com_data=automatic downtime entry&minutes=$MINUTES&fixed=1&start_time=$(startDate)&end_time=$(endDate)&&btnSubmit=Commit" "$NAGIOS_URL"
		;;
	*)
		echo "$ACTION not supported. Options are:"
		echo -e "* disable -- Disables Notifications\n* enable -- Enables Notifications\n* downtime -- Sets Downtime"
		;;
esac
