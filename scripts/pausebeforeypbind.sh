#!/bin/bash

# Create pause service.

cat << EOF > /etc/init.d/pause
#!/bin/sh
#
### BEGIN INIT INFO
# Provides:       pause
# Required-Start: \$network 
# Default-Start:  3 5
# Default-Stop:   0 1 6
# Description:    Insert a pause in system startup
### END INIT INFO

if [ -e /etc/rc.d/init.d/functions ]; then
    . /etc/rc.d/init.d/functions
fi

SLEEP=/bin/sleep
LOGGER=/usr/bin/logger
SLEEPINTERVAL=60
RETVAL=0

case "\$1" in
   start)
      echo -n "Pausing for a brief interval: "
      [ -f \$SLEEP ] || exit 1

      \$LOGGER "Sleeping for \$SLEEPINTERVAL during startup."
      \$SLEEP \$SLEEPINTERVAL
      RETVAL=\$?
      echo
	;;

  stop)
      echo -n "Ok, if you instist I will pretend to stop pausing: "
      killproc gmond
      RETVAL=\$?
      echo
	;;

  restart|reload)
   	\$0 stop
   	\$0 start
   	RETVAL=\$?
	;;
  status)
   	echo "Seriously. You want the *status* of a service called 'pause'. Think about it." 
   	RETVAL=\$?
	;;
  *)
	echo "Usage: \$0 {start|stop|restart|status}"
	exit 1
esac

exit \$RETVAL
EOF

chmod a+x /etc/init.d/pause

# Modify ypbind to depend on pause.
perl -pi -e 's/^# Required-Start.*$/\# Required-Start: \$pause \$remote_fs \$portmap/g' /etc/init.d/ypbind

# Turn on pause
chkconfig pause on

# Have SuSE update teh rc.d scripts.
insserv


