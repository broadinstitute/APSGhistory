#!/bin/bash

# Configuration
SRCDIR=/broad/data/ncbi/mirror/db
DSTDIR=/broad/data/blastdb
MIRDIR=/broad/data/ncbi/mirror/
FTPMIRROR=ftp://ftp.ncbi.nih.gov/blast/db

DATE=`date "+%s"`

LOCKFILE=${DSTDIR}/ncbiupdate.sh.lock

#####################################################
# unpackDB
# Function takes two arguments
# unpackDB databasename targetdir
# example: unpackDB env_nr /broad/data/blastdb/env_nr
#####################################################
function unpackDB () {
  echo "Unpacking $1 database to $2"
  DB=$1
  DBDIR=$2
  DBTEMP=${DBDIR}.$$.tmp

  # If this diretory exists then something went wrong
  if [ -e ${DBTEMP} ]; then
    echo "ERROR: ${DBTEMP} exists!"
    exit 2
  else
    mkdir -p ${DBTEMP} 
  fi

  # Unpack database files into temp folder
  pushd ${DBTEMP}
  for file in `find ${SRCDIR} -maxdepth 1 -name "${db}.*.tar.gz"`
    do 
      echo "Unpacking ${file}..."
      tar -xvzf ${file}
    done
  popd

  # Move old db out of the way if it exists
  if [ -e ${DBDIR} ]; then 
    mv ${DBDIR} ${DBDIR}-${DATE} 
    echo "rm -rf ${DBDIR}-${DATE}" | at now+3days
  fi

  # Move new db into place
  mv ${DBTEMP} ${DBDIR}
}

if [ -e $LOCKFILE ]; then
  echo "Lockfile detected, aborting unpacking databases."
  exit 2
fi

# Make sure this only ever runs as the apsg user.
MYUID=`id -u`
if [[ $MYUID != "3816" ]]; then
  echo "This script must be ran as user apsg."
  exit 3
fi

echo $$ > $LOCKFILE

# Prepare a list of databases
DBLIST=`find ${SRCDIR} -maxdepth 1 -name "*.tar.gz" -printf "%f\n" | cut -f1 -d. | sort -u`

# Unpack any new databases
for db in ${DBLIST}
  do
    DBPATH=${DSTDIR}/${db}
    
    # Get first file for this database.
    DBFILE=`find ${SRCDIR} -maxdepth 1 -name "${db}.*.tar.gz" | head -1`

    # Do update if needed.
    if [[ ! -d $DBPATH && -e $DBPATH ]]; then 
      echo "$DBPATH exists but is not a directory, skipping $db."
      continue
    elif [[ ! -d $DBPATH ]]; then
      echo "$DBPATH does not exist, creating new database $db."
    elif [[ ${DBFILE} -nt ${DBPATH} ]]; then
      echo "$db is being updated."
    else
      echo "$db does not need to be updated."
      continue
    fi
    
    unpackDB $db $DBPATH
  done

# List directories to be deleted.

# Clean up lockfile
rm $LOCKFILE

