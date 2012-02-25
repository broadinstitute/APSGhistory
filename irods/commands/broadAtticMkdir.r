broadimkdir {
  acBroadCollCreateWithAttrs(*rodsPath, *expiryDate, *params, *outstatus);
  acBroadAddACLs(*rodsPath, *user, *owner, *group, *groupMode, *pubMode);
}
INPUT *rodsPath=$, *expiryDate=$, *params=$, *user=$, *owner=$, *group=$, *groupMode=$, *pubMode=$
OUTPUT ruleExecOut

# Adds a file to the system with the following parameters
#
# calls acBroadCollCreateWithAttrs and acBroadAddACLs from broad.irb file
#
# Input parameters : 
#     rodsPath        - String - data object path in iRODS
#	expiryDate	- String - date file expires in YYYY-MM-DD.hh:mm:ss format
#     paramString	- String - list of % separated key=value pairs, e.g. key=value1%key2=value2
#     user            - String - user running irule
#     owner           - String - user to set as object owner
#     group           - String - object group
#     groupMode       - String - group permissions
#     pubMode         - String - permissions for 'public' group
#
# Invocation example 	: irule -F broadAtticPut.ir /zone1/home/rods/testDir 2011-01-01 giles=day%chris=smith giles csmith ugroup write read
