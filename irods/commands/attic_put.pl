#!/usr/bin/env perl

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

# directory where your rules files are
my $rulesLoc = '/home/radon00/irods/commands';
my $putRule = "$rulesLoc/broadAtticPut.ir";
my $mkdirRule = "$rulesLoc/broadAtticMkdir.ir";

# timing and statistics
my $num_files = 0;
my $num_dirs = 0;
my $num_bytes = 0;
my $start_ts;
my $end_ts;
my $errors = 0;
my %error_msgs = ();
my $symlinks = 0;

my %args;
getopts('c:e:f:htv', \%args);

if ($args{h}) {
    usage();
}

# if we're in test mode, go verbose
if ($args{t}) {
    $args{v} = 1;
}

my $scriptuser = getpwuid($<);
my $adminuser = isIrodsAdmin();

my $params;
if ($args{f}) {
    open(PARAMS, $args{f})
    	or die "Can't open parameter file $arg{f}: $!";
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

my $destResc = 'archive1';
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

print "Putting files in $destColl on resource $destResc\n";
print "Files will have an expiry date of $expiry.\n" if $args{v};

$start_ts = time();

my $dir;
foreach $dir (@ARGV) {
    find({ wanted => \&put_to_archive, no_chdir => 1 }, abs_path($dir));
}

$end_ts = time();

my $elapsed = $end_ts - $start_ts;
$elapsed = 1 if $elapsed eq 0;
my $num_mb = $num_bytes / (1024.0 * 1024.0);
print "Transfer statistics:\n";
print "\tnumber of directories : $num_dirs\n";
print "\tnumber of files       : $num_files\n";
printf "\tnumber of megabytes   : %.2f\n", $num_mb;
printf "\telapsed time          : %dh:%02dm:%02ds (%d secs)\n",
    int($elapsed/(60*60)), ($elapsed/60)%60, $elapsed%60, $elapsed;
printf "\toverall throughput    : %.2f MB/sec\n", $num_mb / $elapsed;
print "\tnumber of errors      : $errors\n";
print "\tnumber of symlinks    : $symlinks\n";

exit 0;


sub put_to_archive {
    my $st_info = lstat($_);
    if (not $st_info) {
	print STDERR "ERROR: cannot stat $File::Find::name: $!\n";
	$errors++;
	return;
    }

    if (S_ISLNK($st_info->mode)) {
        print STDERR "WARNING: file $File::Find::name is a symlink ... ignoring.\n";
	$symlinks++;
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
	my $srcDir = escape_chars($_);
	$metadata .= "%broadSourceDirectory=$srcDir";
	print "Creating collection $newObj\n" if $args{v};
	print "irule -F $mkdirRule $newObj $expiry $metadata $user $owner $group $groupmode $pubmode\n" if $args{t};
	my @out =`irule -F $mkdirRule $newObj $expiry $metadata $user $owner $group $groupmode $pubmode` if not $args{t};
	if ($?) {
            $errors++;
	    $error_msgs{"$destColl/$destObj"} = join ' ', @out;
            print @out;
	    return;
        }
	$num_dirs++;
    }
    elsif (S_ISREG($st_info->mode)) {
	my $srcDir = escape_chars(dirname($_));
	my $srcFile = escape_chars(basename($_));
	$metadata .= "%broadSourceDirectory=$srcDir";
	$metadata .= "%broadSourceFilename=$srcFile";
	my $mb = ($st_info->size/(1024.0*1024.0));
	printf("Copying file %s (%.2f MB) to %s (%s)\n", "$srcDir/$srcFile", $mb, $newObj, $destResc) if $args{v};
	print "irule -F $putRule $srcDir/$srcFile $destResc $newObj $expiry $metadata $user $owner $group $groupmode $pubmode\n" if $args{t};
	my $pre_ts = time();
	@out = `irule -F $putRule $srcDir/$srcFile $destResc $newObj $expiry $metadata $user $owner $group $groupmode $pubmode` if not $args{t};
	if ($?) {
            $errors++;
            $error_msgs{"$destColl/$destObj"} = join ' ', @out;
            print @out;
	    return;
        }
	my $post_ts = time();
	if ($args{v}) {
	    my $secs = $post_ts - $pre_ts;
	    $secs = 1 if $secs eq 0;
	    my $rate = $mb/$secs;
	    printf("Transferred %.2f MB in %s (%.2f MB/sec)\n",
		   $mb, format_interval($secs), $rate);
	}
	$num_files++;
	$num_bytes += $st_info->size;
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
    # map user 'root' to iRODS user 'irods'
    $username = 'irods' if $username eq 'root';

    my $groupname = getgroupname($st_info->gid);

    # Parse out the file modes and translate to iRODS permissions
    my $groupmode;
    if ($groupname eq 'root') {
        # special case for root group ... just make no group permission
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

%userlist = {};
sub getusername {
    my ($uid) = @_;
    
    if (!defined($userlist{$uid})) {
	$userlist{$uid} = getpwuid($uid);
    }
    return $userlist{$uid};
}

%grouplist = {};
sub getgroupname {
    my ($gid) = @_;
    
    if (!defined($grouplist{$gid})) {
	$grouplist{$gid} = getgrgid($gid);
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
    die "Usage: $0 [-htv] [-e YYYY-MM-DD[.hh:mm:ss]] [-c destColl] [-f paramFile] localFile|localDir ...
Options are:
  -c destColl - the destination collection path in iRODS where files
       will be copied into. Default is the current iRODS collection
       (shown with ipwd).
  -e expiryDate - a date/time string of the form YYYY-MM-DD.hh:mm:ss
       that defines the date after which the files in the archive
       maybe be purged. If not provided, the default expiry date
       will be the date today plus $default_expiry_period days. If a
       date value is provided it can only be $max_expiry_period days
       from today. 
  -f paramFile - a file containing the the meta-data key/value pairs 
       that you'd like to associate with all the files being copied.
  -h   this message.
  -t   test mode. No iRODS commands will actually be executed.
  -v   verbose.\n";
}

