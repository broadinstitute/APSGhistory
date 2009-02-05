#!/bin/bash

CROWD_ANT=$PWD/apache-tomcat/tools/ant

chmod u+x $CROWD_ANT/bin/antRun
chmod u+x $CROWD_ANT/bin/ant

# ----- SET $ANT_HOME TO POINT TO $CROWD_ANT

OLD_ANT_HOME="$ANT_HOME"
export ANT_HOME="$CROWD_ANT"

OLD_CP=$CLASSPATH
unset CLASSPATH

"$CROWD_ANT/bin/ant" --noconfig -emacs  $@

# ----- RESETTING ENVIRONMENT VARIABLES

export ANT_HOME=$OLD_ANT_HOME
export CLASSPATH=$OLD_CP
