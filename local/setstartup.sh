#!/bin/bash

# Timestamp the backups
DATE=`date "+%Y%m%d%H%M%S"`

# Files to replace
FILES="bash_login bashrc cshrc login"

# Where we keep templates.
SRCDIR="/broad/tools/NoArch/pkgs/local"

# Function to handle switching out files.
install () { # one argument, suffix of files to use
echo "Setting startup to $1."
for file in $FILES; do
    # Backup existing
    if [ -f ~/.$file ]; then 
        mv ~/.$file ~/.$file-$DATE
    fi
    # Copy new
    cp -f $SRCDIR/$file.$1 ~/.$file
done
}

# Display a menu
echo "Select an option:"
echo "  1 - Use classic startup scripts."
echo
echo "  2 - dotkit startup scripts. "
echo "      Remove/modify your .my.cshrc and/or .my.bash*"
echo "      scripts as this option will handle most env "
echo "      setup. If anything is missing, please email "
echo "      help@broad.mit.edu to request additions."
echo
echo "  3 - Use dotkit-dev startup scripts. "
echo "      Remove/modify your .my.cshrc and/or .my.bash* "
echo "      scripts as this option will handle most env "
echo "      setup. If anything is missing, please email "
echo "      help@broad.mit.edu to request additions."
echo "      WARNING: This is development and is "
echo "               subject to rapid changes."
echo 
echo "  4 - *NEW* Auto mode. Let the startup scripts do "
echo "      the Right Thing(tm) based on the host. This "
echo "      option will run dotkit (new) style startup "
echo "      on new style hosts (RHEL/centos 4/5) and "
echo "      classis style startup on older hosts (suse,"
echo "      solaris and redhat 9."
echo "  q - Quit."
echo 

# Collect response
read -p " (1,2,3,4,q): " RESPONSE

case "$RESPONSE" in
  "1" )
    install classic
    ;;
  "2" )
    install dotkit
    ;;
  "3" )
    install dotkit-dev
    ;;
  "4")
    install auto
    ;;
  * ) 
    echo "No change made."
    ;;
esac


