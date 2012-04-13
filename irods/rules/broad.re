#
# This file contains the rules that implement the policies
# needed for the Broad archive system. Since these rules are read
# before the "built-in" iRODS rules (from core.irb), they can 
# override the ones in core.irb. Be careful though! If a rule here
# fails, a rule from core.irb can be run, whether or not this is
# the intention of the rule writer. So if necessary, rules can be 
# commented out in core.irb if needed (see acSetRescSchemeForCreate
# for example). 
#

#
# Disable file deletion from the archive
#
# Don't allow regular users to delete objects from any of the archive
# resources. Local admins can delete files from the archive. 
# Magic number '5' comes from lib/core/include/rodsUser.h
# and is the LOCAL_PRIV_USER_AUTH value of authFlag.
acDataDeletePolicy {
 ON(($rescName like "archive*")
    && ($privClient < "5")
    && ($userNameClient != "cgaadm") 
    && ($userNameClient != "dvoet")) {
  msiDeleteDisallowed;
 }
}

#
# Turn off the "Trash Can"
#
# Since only administrative users will be removing objects, and
# only according to expiration policies, deleted files will not
# be transferred to the Trash Can.
acTrashPolicy {
  msiNoTrashCan; 
}

#
# Strict ACL checking
#
# Make sure that ACLs are honoured when browsing the namespace. 
# Users must have at least "read" permission to icd into, and ils
# collections and see the files.
acAclPolicy {
  msiAclPolicy("STRICT"); 
}

# Force the use of the archive groups, archive1 and archive2
#
# Users must use one of the resource groups 'archive1' or 'archive2'
# when creating objects so that the system can properly balance files
# and manage unavailable resources. Currently, the placement of an object 
# within resource group is random, but this could be changed if
# desired (see options described in core.irb). 'archive1' is preferred
# for users to use, with 'archive2' kept as a "mirror".
#
# For this rule to work properly, all acSetRescSchemeForCreate 
# rules were commented out in core.re.
#
acSetRescSchemeForCreate {
  #msiSetNoDirectRescInp("archive_3_1%archive_3_2%archive_3_3%archive_3_4%archive_3_5%archive_3_6");
  msiSetNoDirectRescInp("knox28%knox29");
  #msiSetDefaultResc("archive3","preferred");
  msiSetDefaultResc("knox","preferred");
  msiSetRescSortScheme("random"); 
}

acSetRescSchemeForRepl {
  msiSetNoDirectRescInp("knox28%knox29");
  msiSetDefaultResc("knox","preferred");
  msiSetRescSortScheme("random"); 
}

#
# Rules for managing the ingest of files into the archive
#
# We want to implement the following workflow:
#  - calculate checksum before transferring file (iput -k)
#  - transfer file annotating file with checksum as meta-data
#  - calculate checksum on server and verify
#  * at this point (if no errors) the file in the archive is a true copy
#  - stage a replica to be created at a future time (allowing iput to finish)
#  - after replication, verify the checksums of the replica. If problems
#    flag an error (email to user, admin, etc)
#  # at this point the file is replicated in the archive as a true copy
#

# Post-put processing. The main workflow for adding files.
#
# This rule is fired for every file that's placed into the archive.
# It will get the current date/time, add that as an attribute to the
# file, and then delays the execution of a workflow to checksum the
# file and make a replica.
#
# Two rules are needed, one for each archive group, so that the
# replica can go to the other group than the one that the iput goes to.
#
# OLD STYLE -- acPostProcForPut|$rescGroupName == archive1|acBroadGetChksum($dataId,*sum)##msiGetIcatTime(*humanDate,null)##msiHumanToSystemTime(*humanDate,*timestamp)##acAddMetadataFromString(now,$objPath,broadEntryDate=*humanDate%broadEntryTimestamp=*timestamp%broadChecksum=*sum,-d)##delayExec(<PLUSET>1s</PLUSET>,msiDataObjRepl($objPath,destRescName=archive2++++verifyChksum=,*replstatus), msiWriteRodsLog(*** acPostProcForPut failure to replicate to archive2, nop))|msiWriteRodsLog(*** acPostProcForPut failure to replicate to archive2 2, nop)
# OLD STYLE -- acPostProcForPut|$rescGroupName == archive2|acBroadGetChksum($dataId,*sum)##msiGetIcatTime(*humanDate,null)##msiHumanToSystemTime(*humanDate,*timestamp)##acAddMetadataFromString(now,$objPath,broadEntryDate=*humanDate%broadEntryTimestamp=*timestamp%broadChecksum=*sum,-d)##delayExec(<PLUSET>1s</PLUSET>,msiDataObjRepl($objPath,destRescName=archive1++++verifyChksum=,*replstatus), msiWriteRodsLog(*** acPostProcForPut failure to replicate to archive1, nop))|msiWriteRodsLog(*** acPostProcForPut failure to replicate to archive1 2, nop)

# With the new knox resource group, the replication isn't required.
acPostProcForPut {
 ON($rescGroupName == "knox") {
  acBroadGetChksum($dataId,*sum);
  msiGetIcatTime(*humanDate,"null");
  msiHumanToSystemTime(*humanDate,*timestamp);
  acAddMetadataFromString("now",$objPath,
        "broadEntryDate=*humanDate%broadEntryTimestamp=*timestamp%broadChecksum=*sum","-d");
 }
}

acBroadGetChksum(*dataId,*Sum) {
  acGetIcatResults("dataobjinfo","DATA_ID = '*dataId'",*List);
  foreach(*Item in *List) {
    msiGetValByKey(*Item,"DATA_SIZE",*size);
    if (*size <= "0") {
      assign(*Sum,"none");
    } 
    else {
      msiGetValByKey(*Item,"DATA_CHECKSUM",*origSum);
      if (*origSum == "") {
        msiDataObjChksum($objPath,"verifyChksum=",*newSum);
        assign(*Sum,*newSum);
      } 
      else {
        assign(*Sum,*origSum);
      }
    }
  }
}

#
# By default, acPostProcForPut is not called for bulk updates, but we
# will set the acBulkPutPostProcPolicy so that it is called for each
# file, since this workflow is key for the operation of the archive.
acBulkPutPostProcPolicy {
  msiSetBulkPutPostProcPolicy("on");
}

#
# These rules manipulate metadata AVUs and are used by workflows in
# the other rules
#

# acAddMetadataFromString : 
#   Adds metadata to an irods Object, from a keyval string (i.e. : KEY=VALUE)
#
# Input parameters :
#       Action    - String - now | delay | expiry | delayExpiry
#       rodsPath  - String - irods content path
#       KVString  - String - keyval string
#       objType	  - String - object type, can be -d for data object, -R for
#                            resource, -C for collection, or -u for user
#
# the "expiry" and "delayExpiry" use cases are special and take a human 
# readble date in the params which is converted to a system date and 
# stored in broadExpiryDate 
#
# BE WARNED - these functions will add multiples of the same attribute 
#             if one already exists!!!
#
acAddMetadataFromString(*Action,*rodsPath,*KVString,*objType) {
  ON(*Action == "now") {
    msiString2KeyValPair(*KVString,*KVPair);
    msiAssociateKeyValuePairsToObj(*KVPair,*rodsPath,*objType);
  }
  ON(*Action == "delay") {
    delay("<PLUSET>1m</PLUSET>") {
      msiString2KeyValPair(*KVString,*KVPair);
      msiAssociateKeyValuePairsToObj(*KVPair,*rodsPath,*objType);
    }
  }
}


# acAddMetadataWithExpiryFromString : 
#      Adds metadata to an irods Object with the expiry date. This basically 
#      does the same as the acBroadObjPutWithAttrs rule, but assumes that 
#      the object has already been created and is thus just adding attributes.
#      The attributes are added in delay mode
#
# Input parameters :
#       Action    - String - now | delay | expiry | delayExpiry
#       rodsPath  - String - irods content path
#       KVString  - String - keyval string
#       humanDate - String - date the files expire in 2001-01-30 format
#       objType	  - String - object type, can be -d for data object, -R for
#                            resource, -C for collection, or -u for user
#
# The "expiry" and "delayExpiry" use cases are special and takes a human 
# readble date in the params which is converted to a system date and 
# stored in broadExpiryDate
#
# BE WARNED - these functions will add multiples of the same attribute 
#             if one already exists!!!
#
acAddMetadataWithExpiryFromString(*Action,*rodsPath,*KVString,*humanDate,*objType) {
  ON(*Action == "delayExpiry") {
    delay("<PLUSET>1m</PLUSET>") {
      msiString2KeyValPair(*KVString,*KVPairs);
      msiAssociateKeyValuePairsToObj(*KVPairs,*rodsPath,*objType);
      msiHumanToSystemTime(*humanDate, *secondsDate);
      acConvertToInt(*secondsDate);
      assign(*KVString2,"broadExpiryDate=*humanDate%broadExpiryTimestamp=*secondsDate");
      msiString2KeyValPair(*KVString2,*KVPairs2);
      msiAssociateKeyValuePairsToObj(*KVPairs2,*rodsPath,*objType);
    }
  }
}

# end metadata AVU rules

# actions to add objects with attributes

# acBroadObjPutWithAttrs : 
#    puts an object into the irods repository with associated metadata. 
# Input parameters :
#     rodsPath      - String - irods content path
#     localFilePath - String - input file path on filesystem
#     resource      - String - resource to put it in
#     expiryDate    - String - date in format YYYY-MM-DD
#     params        - String - % separated list of params, 
#                              e.g. param1=giles%param2=day
#
# calls msiDataObjUnlink if it fails
#
acBroadObjPutWithAttrs(*rodsPath, *localFilePath, *resource, *expiryDate, *params, *outstatus) {
  msiDataObjPut(*rodsPath, *resource, 
                "localPath=*localFilePath++++numThreads=4++++verifyChksum=", 
                *outstatus);
  msiHumanToSystemTime(*expiryDate, *expirySeconds);
  acConvertToInt(*expirySeconds);
  assign(*metastring, "broadExpiryDate=*expiryDate%broadExpiryTimestamp=*expirySeconds%*params");
  acAddMetadataFromString("now", *rodsPath, *metastring, "-d");
}

acBroadCollCreateWithAttrs(*rodsPath, *expiryDate, *params, *outstatus) {
  msiCollCreate(*rodsPath, "0", *outstatus);
  msiHumanToSystemTime(*expiryDate, *expirySeconds);
  acConvertToInt(*expirySeconds);
  assign(*metastring, "broadExpiryDate=*expiryDate%broadExpiryTimestamp=*expirySeconds%*params");
  acAddMetadataFromString("now", *rodsPath, *metastring, "-C");
}

acBroadAddACLs(*rodsPath,*user,*owner,*group,*groupMode,*pubMode) {
  if(*user != *owner) {
    msiSetACL("default","own",*owner,*rodsPath);
  }
  if(*groupMode != "null") {
    msiSetACL("default",*groupMode,*group,*rodsPath);
  }
  if(*pubMode != "null") {
    msiSetACL("default",*pubMode,"public",*rodsPath);
  }
}


# end object creation rules

# auditing section

# acBroadCheckForExpiredFiles(*Condition, *Days)
# check for all files that will expire in X days (86400s) from now using AVUs
#
# Input parameters :
#  Condition   - String - sql expression to limit search, 
#                         e.g. COLL_NAME = '/zone1/home/rods' 
#  Days	     - String - number of weeks to look in advance for expiries
#
acBroadCheckForExpiredFiles(*Condition, *Days) {
  msiGetIcatTime(*Time, "unix");
  acConvertToInt(*Time);
  assign(*expireTime, *Time + (*Days * 86400) );
  writeLine("serverLog", "From acBroadCheckForExpiredFiles: time = *Time *expireTime");
  acGetIcatResults("expire", "META_DATA_ATTR_NAME = 'broadExpiryTimestamp' AND META_DATA_ATTR_VALUE < '*expireTime' AND *Condition", *List);
  foreach(*Item in *List) {
    msiDataObjUnlink(*Item, *Status);
    msiGetValByKey(*Item, "DATA_NAME", *D);
    msiGetValByKey(*Item, "COLL_NAME", *C);
    msiGetValByKey(*Item, "META_DATA_ATTR_VALUE", *E);
    msiGetValByKey(*Item, "DATA_REPL_NUM", *R);
    writeLine("stdout", "In *Days days will delete *C/*D replica *R because its expiry date is *E");
  }
}

# acBroadDeleteExpiredFiles(*Condition,*Days)
# deletes files that expire in X days (86400s) from now using AVUs
#
# Input parameters :
# 	  Condition   - String - sql expression to limit search, 
#                                e.g. COLL_NAME = '/zone1/home/rods'  
# 	  Days	     - String - number of weeks to look in advance for expiries
#
# because the sql query returns a row for each replicate we limit this 
# call to just finding replicate 0 as msiDataObjUnlink will take care of
# deleting replicates for us
#
# XXX there is an issue with this rule, because it specifically looks for data_repl_num = 0
acBroadDeleteExpiredFiles(*Condition, *Days) {
  msiGetIcatTime(*Time, "unix");
  acConvertToInt(*Time);
  assign(*expireTime, *Time + (*Days * 86400) );
  writeLine("serverLog", "From acBroadDeleteExpiredFiles: time = *Time *expireTime");
  acGetIcatResults("expire", "META_DATA_ATTR_NAME = 'broadExpiryTimestamp' AND META_DATA_ATTR_VALUE < '*expireTime' AND DATA_REPL_NUM = '0' AND *Condition", *List);
  foreach(*Item in *List) {
    msiDataObjUnlink(*Item, *Status);
    msiGetValByKey(*Item, "DATA_NAME", *D);
    msiGetValByKey(*Item, "COLL_NAME", *C);
    msiGetValByKey(*Item, "META_DATA_ATTR_VALUE", *E);
    writeLine("stdout", "Object *C/*D deleted because expiry date is *E");
  }
}

# end auditing rules

#
# Various miscellaneous rules
#

#
# some acGetIcatResults rules (i.e. query the icat database)
#
acGetIcatResults(*Action,*Condition,*GenQOut) {
  ON(*Action == "dataobjinfo") {
    msiMakeQuery("DATA_EXPIRY, DATA_NAME, DATA_REPL_NUM, DATA_REPL_STATUS, DATA_CHECKSUM, DATA_ID, DATA_SIZE",
                 *Condition, *Query);
    msiExecStrCondQuery(*Query, *GenQOut);
  }
  ON(*Action == "replica") {
    msiMakeQuery("DATA_EXPIRY, DATA_NAME, COLL_NAME, DATA_REPL_NUM, DATA_REPL_STATUS, DATA_CHECKSUM, DATA_ID, DATA_SIZE", 
                 *Condition, *Query);
    msiExecStrCondQuery(*Query, *GenQOut);
  }
  ON(*Action == "expire") {
    msiMakeQuery("COLL_NAME, DATA_NAME, DATA_ID, META_DATA_ATTR_NAME, META_DATA_ATTR_VALUE, DATA_EXPIRY, DATA_REPL_NUM", 
                 *Condition, *Query);
    msiExecStrCondQuery(*Query, *GenQOut);
  }
}

# Set default number of threads for transfers
#
# This rule sets the maximum number of threads that a transfer will
# use. A client can request less, but not more than this. The default
# value in core.re is 16, but 8 seems to work better in the Broad network
acSetNumThreads {
  msiSetNumThreads("default","8","default");
}

#
# Set concurrent delayed rule executions
#
# This rule can be used to increase the concurrency of the
# rule engine when processing delayed execution rules. Specifically
# this will increase the throughput of archive replications for
# the Broad attic. The 'default' is 1, and the max is 4.
acSetReServerNumProc {
  msiSetReServerNumProc("4");
}

# EOF
