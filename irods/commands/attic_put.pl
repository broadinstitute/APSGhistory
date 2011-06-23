#!/usr/bin/env perl

use strict;

use Getopt::Std;
use File::Find;
use File::stat;
use Fcntl ':mode';
use Time::localtime;
use Time::Local;
use Cwd 'abs_path';
use File::Basename;

# Expiry parameters:
#
# default expiry period is set here in days
# (setting to 1 year plus some buffer time)
my $default_expiry_period = 365 + 60;
#
# max expiry period in days - can't set expiry longer than this
# (5 years ... can override by modifying iRODS meta-data directly)
my $max_expiry_period = 365 * 5;

# directory where the rules files are
my $rulesLoc = '/home/radon00/irods/commands';
my $putRule = "$rulesLoc/broadAtticPut.ir";
my $mkdirRule = "$rulesLoc/broadAtticMkdir.ir";

# iRODS resources where files should be placed. The 
# archive1 resource group is composed of a number of
# thumpers, and has rules to auto-replicate to a second
# resource group (archive2)
my $destResc = 'archive1';

# timing and statistics
my $num_files = 0;
my $num_files_exist = 0;
my $num_dirs = 0;
my $num_dirs_exist = 0;
my $num_bytes = 0;
my $num_links = 0;
my %symlinks = ();
my $start_ts;
my $end_ts;
my $num_errors = 0;
my %error_msgs = ();

# for managing collection ACLs in the post-processing function
my %collection_owner = ();
my %collection_acl = ();
my %collection_name = ();

# support the exclusion of certain file/directory names using
# perl regex patterns contained in a file. At pre-defined patterns
# here to make them default.
my @exclude_patterns = ("core");
my %excluded_files = ();
my $num_excluded = 0;

my %args;
getopts('c:e:f:hrtvx:', \%args);

if ($#ARGV eq -1 or $args{h}) {
    usage();
}

# if we're in test mode, go verbose
if ($args{t}) {
    $args{v} = 1;
}

my $scriptuser = getpwuid($<);
my $adminuser = isIrodsAdmin();

#
# Add meta-data key/value pairs from the parameter file
# that are to be added to every object ingested into iRODS.
#
my $params;
if ($args{f}) {
  open(PARAMS, $args{f})
    or die "Can't open parameter file $args{f}: $!";
  while (<PARAMS>) {
    chop;
    if (split(/=/) ne 2) {
      print "Parameters must be of the form 'key=value'. '$_' ignored\n";
      next;
    }
    $params .= '%' if $params;
    $params .= $_;
  }
  close(PARAMS);
}

#
# Check the provided expiry date. Set a default if none specified.
#
my $expiry = $args{e};
if ($expiry) {
  # check if the input expiry data format is correct
  # should be 'YYYY-MM-DD[.hh:mm:ss]'
  my ($h, $m, $s);
  if ($expiry !~ /^(\d{4})-(\d{2})-(\d{2})(\.(\d{2}):(\d{2}):(\d{2}))?$/) {
    print STDERR "Expiry date should be in the form YYYY-MM-DD[.hh:mm:ss]\n";
    usage();
  }
  if ($4) {
    $h = $5;
    $m = $6;
    $s = $7;
  }
  else {
    $expiry .= ".00:00:00";
    $h = 0;
    $m = 0;
    $s = 0;
  }
  # check if it's within the maximum expiry limit
  my $expiry_seconds = timelocal($s, $m, $h, $3, $2 - 1, $1);
  if (($expiry_seconds - time()) > ($max_expiry_period * 24 * 60 * 60)) {
    print STDERR "Expiry data must not be longer than $max_expiry_period days from today.\n";
    usage();
  }
}
else {
  # by default, expiry will be set to today + $default_expiry_period 
  my $expiry_seconds = time() + ($default_expiry_period * 24 * 60 * 60);
  my $expiry_tm = localtime($expiry_seconds);
  $expiry = sprintf("%4d-%02d-%02d.%02d:%02d:%02d", 
                    $expiry_tm->year+1900, $expiry_tm->mon+1, $expiry_tm->mday,
                    $expiry_tm->hour, $expiry_tm->min, $expiry_tm->sec);
}

#
# Check for the destination collection. The default will be
# the user's iRODS home collection.
#
my $destColl;
if ($args{c}) {
  $destColl = $args{c};
}
else {
  chop($destColl = `ipwd`);
}
if ($destColl =~ /^*\/$/) {
  chop($destColl);
}
my @output = `ils $destColl 2>&1`;
if ($?) {
  print "Collection $destColl does not exist. The destination collection\n";
  print "must exist and must be writeable by the user invoking the script.\n";
  exit 1;
}

#
# Read a file containing perl regexp patterns of files to
# exclude from the ingest. 
if ($args{x} and open(EXCLUDE, $args{x})) {
  while (<EXCLUDE>) {
    chop;
    push(@exclude_patterns, $_);
  }
  close(EXCLUDE);
}

print "Putting files in $destColl on resource $destResc\n";
print "Files will have an expiry date of $expiry.\n" if $args{v};

$start_ts = time();

my $dir;
foreach $dir (@ARGV) {
  find({ wanted => \&put_to_archive, 
         postprocess => \&postprocess_dir,
         preprocess => \&exclude_entries,
       }, abs_path($dir));
}

$end_ts = time();

my $elapsed = $end_ts - $start_ts;
$elapsed = 1 if $elapsed eq 0;
my $num_mb = $num_bytes / (1024.0 * 1024.0);
print "\nTransfer statistics:\n";
print "\tnumber of directories : $num_dirs ($num_dirs_exist already in iRODS)\n";
print "\tnumber of files       : $num_files ($num_files_exist already in iRODS)\n";
printf "\tnumber of megabytes   : %.2f\n", $num_mb;
printf "\telapsed time          : %dh:%02dm:%02ds (%d secs)\n",
  int($elapsed/(60*60)), ($elapsed/60)%60, $elapsed%60, $elapsed;
printf "\toverall throughput    : %.2f MB/sec\n", $num_mb / $elapsed;
print "\tnumber excluded       : $num_excluded\n";
print "\tnumber of symlinks    : $num_links\n";
print "\tnumber of errors      : $num_errors\n";
if ($num_excluded) {
  print "\nList of files and directories excluded by exclusion patterns:\n";
  foreach my $excluded (keys %excluded_files) {
    print "\t$excluded\n";
  }
}
if ($num_links) {
  print "\nList of encountered symlinks:\n";
  foreach my $symlink (keys %symlinks) {
    print "\t$symlink\n";
  }
}
if ($num_errors) {
  print "\nList of errors:\n";
  foreach my $file (keys %error_msgs) {
    print "\t$file\n";
    print "\t\t$error_msgs{$file}"; 
  }
}

exit 0;

sub postprocess_dir {

  if (defined $collection_name{$File::Find::dir}) {
    $ENV{clientUserName} = $collection_owner{$File::Find::dir} if $adminuser;
    print "ichmod $collection_acl{$File::Find::dir} public $collection_name{$File::Find::dir}\n" if $args{t};
    my @out = `ichmod $collection_acl{$File::Find::dir} public $collection_name{$File::Find::dir} 2>&1` if not $args{t};
    if ($?) {
      $num_errors++;
      $error_msgs{$File::Find::dir} = join "\t\t", @out;
    }
  }

  if ($args{r}) {
    print "Removing directory $File::Find::dir ... " if $args{v}; 
    if (defined $error_msgs{$File::Find::dir}) {
      print "earlier error creating this directory in iRODS, so not removed.\n" if $args{v};
    }
    elsif (not rmdir $File::Find::dir) {
      if ($! =~ /not empty/) {
        print "not empty, so not removed.\n" if $args{v};
      }
      else {
        print "\n";
        print STDERR "ERROR: could not remove directory: $!\n";
      }
    }
    else {
      print "done\n" if $args{v};
    }
  }
}

sub exclude_entries {
  my @file_list = ();
  my $name;
  my $pattern;

  foreach $name (@_) {
    my $match = "";
    foreach my $pattern (@exclude_patterns) {
      if ($name =~ m/^$pattern$/) {
        $match = $pattern;
        $excluded_files{"$File::Find::dir/$name"} = $pattern;
        $num_excluded++;
        last;
      }
    }
    if ($match eq "") {
      push(@file_list, $name);
    }
  }
  return @file_list;
}

sub put_to_archive {

  my $st_info = lstat($_);
  if (not $st_info) {
    $error_msgs{$File::Find::name} = "ERROR: cannot stat $File::Find::name: $!\n";
    $num_errors++;
    return;
  }

  if (not -r _) {
    $error_msgs{$File::Find::name} = "Cannot read file $File::Find::name ... ignoring.\n";
    $num_errors++;
    return;
  }
  
  if (S_ISLNK($st_info->mode)) {
    print STDERR "WARNING: file $File::Find::name is a symlink ... ignoring.\n" if $args{v};
    $num_links++;
    $symlinks{$File::Find::name} = 1;
    return;
  }
  
  my ($owner, $group, $groupmode, $pubmode)
    = get_acls_from_file_mode($st_info);
  
  # iRODS admin users can do operations as regular users
  # which makes sure the ownership ACLs are right
  # Otherwise, you need to tell the rules who is running
  # the script so that the rules can set the owner ACL
  # correctly.
  my $user;
  if ($adminuser) {
    $user = $owner;
    $ENV{clientUserName} = $owner;
  }
  else {
    $user = $scriptuser;
  }
  
  my $metadata = get_file_metadata($st_info);
  $metadata .= "%${params}" if $params;
  
  # Depending on where we are in the find, have to figure
  # out which bit of directory structure needs to be put in
  # the iRODS collection, and which (the prefix) is left out
  my $prefix = dirname($File::Find::topdir)."/";
  my $destObj = "$File::Find::name";
  $destObj =~ s/^$prefix//;
  my $newObj = escape_chars("$destColl/$destObj");
  
  if (S_ISDIR($st_info->mode)) {
    my $srcDir = escape_chars($File::Find::name);
    $metadata .= "%broadSourceDirectory=$srcDir";
    # we set the public ACL for the new collection to 'write' so that
    # there are no permissions issues creating sub-collections and files
    # owned by other users. This is set to the proper ACL in the 
    # post-processing hook
    $collection_name{$File::Find::name} = $newObj;
    $collection_owner{$File::Find::name} = $owner;
    $collection_acl{$File::Find::name} = $pubmode;
    print "Creating collection $newObj\n" if $args{v};
    print "irule -F $mkdirRule $newObj $expiry $metadata $user $owner $group $groupmode write\n" if $args{t};
    my @out =`irule -F $mkdirRule $newObj $expiry $metadata $user $owner $group $groupmode write 2>&1` if not $args{t};
    if ($?) {
      # Error code -809000 means the collection already exists ... not a problem
      my $rc = grep(/809000/, @out);
      if ($rc == 0) {
        $num_errors++;
        $error_msgs{$File::Find::name} = join "\t\t", @out;
      }
      else {
        $num_dirs_exist++;
      }
      return;
    }
    $num_dirs++;
  }
  elsif (S_ISREG($st_info->mode)) {
    my $srcDir = escape_chars(dirname($File::Find::name));
    my $srcFile = escape_chars(basename($File::Find::name));
    $metadata .= "%broadSourceDirectory=$srcDir";
    $metadata .= "%broadSourceFilename=$srcFile";
    my $mb = ($st_info->size/(1024.0*1024.0));
    printf("Copying file %s (%.2f MB) to %s (%s)\n", "$srcDir/$srcFile", $mb, $newObj, $destResc) if $args{v};
    print "irule -F $putRule $srcDir/$srcFile $destResc $newObj $expiry $metadata $user $owner $group $groupmode $pubmode\n" if $args{t};
    my $pre_ts = time();
    my @out = `irule -F $putRule $srcDir/$srcFile $destResc $newObj $expiry $metadata $user $owner $group $groupmode $pubmode 2>&1` if not $args{t};
    if ($?) {
      # Error code -312000 says iRODS won't overwrite without a force flag. I.e. file exists. Not a problem.
      my $rc = grep(/312000/, @out);
      if ($rc == 0) {
        $num_errors++;
        $error_msgs{$File::Find::name} = join "\t\t", @out;
      }
      else {
        $num_files_exist++;
      }
      return;
    }
    if ($args{v}) {
      my $secs = time() - $pre_ts;
      $secs = 1 if $secs eq 0;
      my $rate = $mb/$secs;
      printf("Transferred %.2f MB in %s (%.2f MB/sec)\n",
             $mb, format_interval($secs), $rate);
    }
    $num_files++;
    $num_bytes += $st_info->size;
    
    if ($args{r}) {
      print "Removing file $_...\n" if $args{v};
      unlink $_ or print STDERR "ERROR: could not unlink file: $!\n";
    }
  }
}

sub get_file_metadata {
  my ($st_info) = @_;
  my $ctime = localtime($st_info->ctime);
  my $mtime = localtime($st_info->mtime);
  my $metadata 
    = "broadUser=".getusername($st_info->uid)
      . "%broadUid=".$st_info->uid
      . "%broadGroup=".getgroupname($st_info->gid)
      . "%broadGid=".$st_info->gid
      . "%broadCreateTimestamp=".$st_info->ctime
      . "%broadCreateTime=".sprintf("%s-%s-%s.%s:%s:%s",
                                    $ctime->year+1900, 
                                    $ctime->mon+1,
                                    $ctime->mday,
                                    $ctime->hour,
                                    $ctime->min,
                                    $ctime->sec)
      . "%broadModifyTimestamp=".$st_info->mtime
      . "%broadModifyTime=".sprintf("%s-%s-%s.%s:%s:%s",
                                    $mtime->year+1900, 
                                    $mtime->mon+1,
                                    $mtime->mday,
                                    $mtime->hour,
                                    $mtime->min,
                                    $mtime->sec)
      . "%broadFileMode=".sprintf("%04o", S_IMODE($st_info->mode));
  
  return $metadata;
}

sub get_acls_from_file_mode {
  my ($st_info) = @_;

  my $username = getusername($st_info->uid);
  # if a username is not in NIS (and thus won't be in iRODS)
  # just map the user to iRODS user 'irods'
  $username = 'irods' if $username eq '__LOCAL__';
  
  my $groupname = getgroupname($st_info->gid);
  
  # Parse out the file modes and translate to iRODS permissions
  my $groupmode;
  if ($groupname eq '__LOCAL__') {
    # if the group owner is not in NIS (and thus not
    # in iRODS), just set no group permission
    $groupmode = 'null';
  }
  elsif ($st_info->mode & S_IWGRP) {
    $groupmode = 'write';
  }
  elsif ($st_info->mode & S_IRGRP) {
    $groupmode = 'read';
  }
  else {
    $groupmode = 'null';
  }
  
  # unix 'other' is like iRODS 'public'
  my $publicmode;
  if ($st_info->mode & S_IWOTH) {
    $publicmode = 'write';
  }
  elsif ($st_info->mode & S_IROTH) {
    $publicmode = 'read';
  }
  else {
    $publicmode = 'null';
  }
  
  return ($username, $groupname, $groupmode, $publicmode);
}

my %userlist = {};
sub getusername {
  my ($uid) = @_;
  my $user;
  my $out;
  if (!defined($userlist{$uid})) {
    $user = getpwuid($uid);
    $out = `ypmatch $user passwd`;
    if ($out =~ /^Can\'t match key/) {
      $user = '__LOCAL__';
    }
    $userlist{$uid} = $user;
  }
  return $userlist{$uid};
}

my %grouplist = {};
sub getgroupname {
  my ($gid) = @_;
  my $group;
  my $out;
  if (!defined($grouplist{$gid})) {
    $out = `ypmatch $gid group.bygid`;
    if ($out =~ /^Can\'t match key/) {
      $group = '__LOCAL__';
    }
    else {
      ($group) = split(':', $out, 2);
    }
    $grouplist{$gid} = $group;
  }
  return $grouplist{$gid};
}

sub format_interval {
  my ($secs) = @_;
  return sprintf ("%dh:%02dm:%02ds (%d secs)",
                  int($secs/(60*60)), ($secs/60)%60,
                  $secs%60, $secs);
}

sub isIrodsAdmin {
  my $is_admin = 0;
  open(I, "iuserinfo|")
    or die "Can't run iuserinfo: $!\n";
  while (<I>) {
    if (/^type: (\w+)$/) {
      if ($1 eq "rodsadmin") {
        $is_admin = 1;
        last;
      }
    }
  }
  close(I);
  return $is_admin;
}

sub escape_chars {
  my ($escaped_name) = @_;
  # We need to escape characters that might be interpreted by
  # the shell. Set of special characters is: ;&|><*?`$(){}[]!#
  # Also includes space.
  $escaped_name =~ s/ /\\ /g; # spaces
  $escaped_name =~ s/([;<>\*\|`&\$!#\(\)\[\]\{\}:'"])/\\$1/g; # special chars
  return $escaped_name;
}    

sub usage {
  my $cmd = basename($0);
  die "Usage: $cmd [-htv] [-e YYYY-MM-DD[.hh:mm:ss]] [-c destColl] [-f paramFile] [-x excludeFile] localFile|localDir ...
Options are:
  -c destColl - the destination collection path in iRODS where files
       will be copied into. Default is the calling user's home iRODS 
       collection.
  -e expiryDate - a date/time string of the form YYYY-MM-DD.hh:mm:ss
       that defines the date after which the files in the archive
       maybe be purged. If not provided, the default expiry date
       will be the date today plus $default_expiry_period days. If a
       date value is provided it can only be $max_expiry_period days
       from today. 
  -f paramFile - a file containing the the meta-data key/value pairs 
       that you'd like to associate with all the files being copied.
  -h   this message.
  -r   remove files and directories after successful ingest into
       the archive system. 
  -t   test mode. No iRODS commands will actually be executed.
  -v   verbose.
  -x excludeFile - a file containing patterns, in the form of perl 
       regular expressions (see 'perldoc perlre'), that indicate
       files and directories that should not be included in the ingest.
       Some patterns are pre-defined to be excluded, such as 'core'.
       Note that perl regular expressions are not quite the same as
       the ones in csh or sh. For example, the wildcard character
       '*', which matches any character 0 or more times when used in
       the shell, is done in perl with the expression '.*', which 
       says to match any character (indicated with '.'), 0 or more
       times (indicated with '*').\n";
}

