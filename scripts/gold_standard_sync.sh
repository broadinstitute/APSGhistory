#!/bin/bash

# This is a wrapper for asperasync.sh so it plays nice in a cron job.
# It creates a lock so that only one sync can run at a time, and kills
# day-old instances of itself.

# sync this...
SOURCE=anonftp@ftp-private.ncbi.nlm.nih.gov:1000genomes

# ...to a directory of the same name under this directory:
TARGET=/broad/1KG/gold_standard
# (as opposed to like rsync, where you can have it actually sync to
# the other directory per se).

KEY=/opt/aspera/connect/etc/asperaweb_id_dsa.putty
LOCKFILE=$TARGET/1000genomes/sync.lock
TARGETRATE=200M

make_sure_we_are_alone() {
    if lockfile -r0 $LOCKFILE >/dev/null 2>&1
    # If we can get the lock, all is well.  Write our PID so we can be
    # killed later.
    then
	chmod +w $LOCKFILE
	echo $$ > $LOCKFILE
	chmod -w $LOCKFILE
	return

    # Otherwise, if it's a day old, steal it and kill the other
    # process.
    else
	OLDPID=`cat $LOCKFILE 2>/dev/null || true`
	if lockfile -r0 -l86400 $LOCKFILE >/dev/null 2>&1
	then
	    chmod +w $LOCKFILE
	    echo $$ > $LOCKFILE
	    chmod -w $LOCKFILE
	    echo "stole lock from old sync process $OLDPID; killing it now" >&2
	    [[ -z $OLDPID ]] || kill -TERM $OLDPID || sleep 5 && kill -KILL $OLDPID

	# Otherwise, if the other process is still around, we're done;
	# if it's dead, take the lock.  If the process is running as
	# another user, we'll get confused, so never do that (but only
	# the apsg user should have the rights to touch these files
	# anyway).
	else
	    if kill -0 $OLDPID
	    then
  	      exit 0
            else
              echo process $OLDPID has lock $LOCK >&2
	      echo unable to send it a signal, so assuming it is dead and stealing the lock >&2
	      set -e
	      rm $LOCKFILE
	      lockfile -r0 $LOCKFILE 
	      chmod +w $LOCKFILE
	      echo $$ > $LOCKFILE
	      chmod -w $LOCKFILE
	      return
            fi
	fi
    fi
}

cd $TARGET

make_sure_we_are_alone

</dev/null sh /local/aspera/bin/asperasync.sh $SOURCE $TARGET -i $KEY 2>&1 | logger -t '1000genomes-ascp-sync'

rm -f $LOCKFILE
