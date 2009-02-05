@echo off

set OLD_ANT_HOME=%ANT_HOME%
set ANT_HOME=apache-tomcat\tools\ant

set OLD_CLASSPATH=%CLASSPATH%
set CLASSPATH=%ANT_HOME%\lib\xmltask-v1.14.jar

call %ANT_HOME%\bin\ant -emacs %1 %2 %3 %4 %5 %6 %7 %8 %9

set ANT_HOME=%OLD_ANT_HOME%
set CLASSPATH=%OLD_CLASSPATH%
