#! /bin/bash

# Set CATALINA_HOME so tomcat's start script knows where it is
export CATALINA_HOME=./apache-tomcat

# Execute tomcat
exec apache-tomcat/bin/catalina.sh run
