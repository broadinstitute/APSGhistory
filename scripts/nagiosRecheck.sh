#!/bin/bash
#https://systems.broadinstitute.org/nagios/cgi-bin/cmd.cgi?cmd_typ=96&host=node1574&force_check
#https://systems.broadinstitute.org/nagios/cgi-bin/cmd.cgi?cmd_typ=17&host=node1606$force_check

#Functions
startDate(){
        local START_DATE=$(date -d @$(date +%s)  "+%x %H:%M:%S" | sed -e 's/\//-/g')
        echo $START_DATE
}

#Arg Variable Block
HOST=$1
USER=$2

#Password Input
stty -echo
read -p "Password: " PASSW; echo 
stty echo

#App Variables
NAGIOS_URL="https://systems.broadinstitute.org/nagios/cgi-bin/cmd.cgi"

curl -u $USER:$PASSW -d "cmd_typ=96&cmd_mod=2&host=$HOST&start_time=$(startDate)&force_check&&btnSubmit=Commit" "$NAGIOS_URL"
curl -u $USER:$PASSW -d "cmd_typ=17&cmd_mod=2&host=$HOST&start_time=$(startDate)&force_check&&btnSubmit=Commit" "$NAGIOS_URL"
