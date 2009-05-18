#!/bin/bash
# Use lftp to update our mirror

# LFTP options
LFTP="/usr/bin/lftp"
DST="/broad/data/ncbi/mirror/db"
SRC="ftp://ftp.ncbi.nih.gov/blast/db"
CMD="mirror"
OPTIONS="-e -a -v -L --loop "
# -c Continue tranfers of possible
# -e Delete local files if not present on remote site
# -a same as --allow-chown --allow-suid --no-umask, e.g. archive mode
# -L get symlinks as files
# --loop  Keep looping over files until mirror is complete.

# Make sure DST exists and is writeable. 
if ! [[ -d $DST && -w $DST ]]; then
  echo "$DST not found, attempting to create it."
  if ! mkdir -p $DST; then
    echo "Unable to create $DST."
    exit 1
  fi
fi

# Make sure this only ever runs as the apsg user.
MYUID=`id -u`
if [[ $MYUID != "3816" ]]; then
  echo "This script must be ran as user apsg."
  exit 3
fi

# Pipe script to lftp that sets it's at-exit
# command to the updatedb script so that 
# the update starts as soon as the mirror 
# finishes.
cat << EOF | $LFTP
mirror $OPTIONS $SRC $DST
EOF

echo "/broad/data/ncbi/scripts/ncbi-update-db.sh" | at "6:00pm Sunday"

