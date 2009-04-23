#!/bin/bash

# Timestamp the backups
DATE=`date "+%Y%m%d%H%M%S"`

# Files to replace
FILES="bash_login bashrc cshrc"

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
echo "  2 - Use dotkit startup scripts. You may want"
echo "      to modify your .my.cshrc and/or .my.bash*" 
echo "      files to use dotkit functions."
echo
echo "  3 - Use dotkit-dev startup scripts. "
echo "      WARNING: This is development and is "
echo "               subject to rapid changes."
echo "  q - Quit."
echo 

# Collect response
read -p " (1,2,3,q): " RESPONSE

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
  * ) 
    echo "No change made."
    ;;
esac


