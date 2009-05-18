#!/bin/bash
# Use lftp to update our mirror

# LFTP options
LFTP="/usr/bin/lftp"
DST="/broad/data/ncbi/mirror/taxonomy"
SRC="ftp://ftp.ncbi.nih.gov//pub/taxonomy/"
TGT="/broad/data/taxonomy"

CMD="mirror"
OPTIONS="-e -a -v -L --loop -I '*.gz' -X '*diff*'"
# -c Continue tranfers of possible
# -e Delete local files if not present on remote site
# -a same as --allow-chown --allow-suid --no-umask, e.g. archive mode
# --loop  Keep looping over files until mirror is complete.

# Make sure DST exists and is writeable. 
if ! [[ -d $DST && -w $DST ]]; then
  echo "$DST not found, attempting to create it."
  if ! mkdir -p $DST; then
    echo "Unable to create $DST."
    exit 1
  fi
fi

# Make sure TGT exists and is writeable. 
if ! [[ -d $TGT && -w $TGT ]]; then
  echo "$TGT not found, attempting to create it."
  if ! mkdir -p $TGT; then
    echo "Unable to create $TGT."
    exit 1
  fi
fi

# Make sure this only ever runs as the apsg user.
MYUID=`id -u`
if [[ $MYUID != "3816" ]]; then
  echo "This script must be ran as user apsg."
  exit 3
fi

$LFTP -c "mirror $OPTIONS $SRC $DST"


# Update the taxonomy files.

# First, the .dmp single files.
for file in $DST/*.dmp.gz 
  do
    # Grab the filename for after gunzipping
    FILENAME=`basename $file | cut -f1,2 -d'.'`
    # Grab the name of the taxonomy whatever-it-is
    TNAME=`basename $file | cut -f1 -d'.'`
    echo "Checking $TNAME..."    
    if ! [[ -d $TGT/$TNAME ]]; then 
      # No directory, therefore it needs to be created.
      echo "Creating $TNAME."
      mkdir $TGT/$TNAME
      zcat $file > $TGT/$TNAME/$FILENAME
    elif [[ $file -nt $TGT/$TNAME/$FILENAME ]]; then
      # Download is newer, needs to be updated.
      echo "Updating $TNAME."
      zcat $file > $TGT/$TNAME/$FILENAME
    else
      echo "$TNAME appears to be up to date."
    fi
  done

# Next, the tar.gz archives.
for file in $DST/*.tar.gz
  do
    TNAME=`basename $file | cut -f1 -d'.'`   
    echo "Checking $TNAME..."    
    if ! [[ -d $TGT/$TNAME ]]; then 
      # no directory, needs to be created.
      echo "Creating $TNAME."
      mkdir $TGT/$TNAME;
      cd $TGT/$TNAME
      tar -xzf $file
      touch updated-timestamp
    elif [[ $file -nt `ls -1t $TGT/$TNAME/* | head -1` ]]; then
      # Download is newer, needs to be updated
      echo "Updating $TNAME."
      cd $TGT/$TNAME
      tar -xzf $file
      touch updated-timestamp
    else
      echo "$TNAME appears to be up to date."
    fi
  done


