#!/bin/bash

#Functions
startDate(){
        local START_DATE=$(date -d @$(date +%s)  "+%x %H:%M:%S" | sed -e 's/\//-/g')
        echo $START_DATE
}

# Here we define Usage -- define once, print many
USAGE="Usage: `basename $0` \$HOSTS \$USER"

# error codes as defined in /usr/include/sysexits.h
E_OK=0                  # successful termination
E_USAGE=64              # command line usage error 
E_NOINPUT=66            # cannot open input
E_NOHOST=68             # host not found
E_UNAVAILABLE=69        # service unavailable

if [ "x$1" = "x-u" ]; then
        USER=$2
        shift
        shift
else
        USER=$(printenv USER)
fi

#Password Input
stty -echo
read -p "Password: " PASSW; echo 
stty echo

#App Variables
NAGIOS_URL="https://systems.broadinstitute.org/nagios/cgi-bin/cmd.cgi"

while [ $# -ge 1 ]; do
	curl -u $USER:$PASSW -d "cmd_typ=96&cmd_mod=2&host=$HOST&start_time=$(startDate)&force_check&&btnSubmit=Commit" "$NAGIOS_URL"
	curl -u $USER:$PASSW -d "cmd_typ=17&cmd_mod=2&host=$HOST&start_time=$(startDate)&force_check&&btnSubmit=Commit" "$NAGIOS_URL"
        shift
done
