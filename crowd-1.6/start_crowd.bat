@echo off
rem -----------------------------------
rem Starting Atlassian Crowd 
rem -----------------------------------

set OLD_CATALINA_HOME=%CATALINA_HOME%

set CATALINA_HOME=%cd%\apache-tomcat
call apache-tomcat\bin\catalina.bat run

set CATALINA_HOME=%OLD_CATALINA_HOME%
