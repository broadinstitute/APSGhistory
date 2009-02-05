set JAVA_OPTS=%JAVA_OPTS% -Xms128m -Xmx256m -Dfile.encoding=UTF-8

rem Checks if the JAVA_HOME has a space in it (can cause issues)
SET _marker=%JAVA_HOME: =%
IF NOT "%_marker%" == "%JAVA_HOME%" ECHO JAVA_HOME "%JAVA_HOME%" contains spaces. Please change to a location without spaces if this causes problems.