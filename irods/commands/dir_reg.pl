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

# timing and statistics
my $num_files = 0;
my $num_dirs = 0;
my $num_bytes = 0;
my $num_links = 0;
my %symlinks = ();
my $start_ts;
my $end_ts;
my $num_errors = 0;
my %error_msgs = ();

# support the exclusion of certain file/directory names using
# perl regex patterns contained in a file.
my @exclude_patterns = ();
my %excluded_files = ();
my $num_excluded = 0;

my %args;
getopts('c:hRtvx:', \%args);

if ($#ARGV eq -1 or $args{h}) {
  usage();
}

# if we're in test mode, go verbose
if ($args{t}) {
  $args{v} = 1;
}

my $destResc;
if ($args{R}) {
  $destResc = $args{R};
}
else {
  $destResc = 'demoResc';
}

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

my @output = `ils $destColl 2>&1`;
if ($?) {
  # create the destination collection
  print "Creating the destination collection $destColl\n";
  @output = `imkdir -p $destColl 2>&1`;
  if ($?) {
    print "Could not create the destination collection $destColl\n";
    print @output;
    exit 1;
  }
}

print "Registering files in $destColl on resource $destResc\n";

$start_ts = time();

my $dir;
foreach $dir (@ARGV) {
  find({ wanted => \&reg_object,
         preprocess => \&exclude_entries,
       }, abs_path($dir));
}

$end_ts = time();

my $elapsed = $end_ts - $start_ts;
$elapsed = 1 if $elapsed eq 0;
my $num_mb = $num_bytes / (1024.0 * 1024.0);
print "\nRegistration statistics:\n";
print "\tnumber of directories      : $num_dirs\n";
print "\tnumber of files            : $num_files\n";
printf "\tnumber of megabytes        : %.2f\n", $num_mb;
printf "\telapsed time               : %dh:%02dm:%02ds (%d secs)\n",
    int($elapsed/(60*60)), ($elapsed/60)%60, $elapsed%60, $elapsed;
print "\tnumber of errors           : $num_errors\n";
print "\tnumber of symlinks         : $num_links\n";
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

sub reg_object {

  my $st_info = lstat($_);
  if (not $st_info) {
    print STDERR "ERROR: cannot stat $File::Find::name: $!\n";
    $num_errors++;
    return;
  }

  if (S_ISLNK($st_info->mode)) {
    print STDERR "WARNING: file $File::Find::name is a symlink ... ignoring.\n";
    $num_links++;
    $symlinks{$File::Find::name} = 1;
    return;
  }

  # Depending on where we are in the find, have to figure
  # out which bit of directory structure needs to be put in
  # the iRODS collection, and which (the prefix) is left out
  my $prefix = dirname($File::Find::topdir)."/";
  my $destObj = "$File::Find::name";
  $destObj =~ s/^$prefix//;
  my $newObj = escape_chars("$destColl/$destObj");
  
  if (S_ISDIR($st_info->mode)) {
    print "Creating collection $newObj\n" if $args{v};
    print "imkdir $newObj\n" if $args{t};
    my @out =`imkdir $newObj 2>&1` if not $args{t};
    if ($?) {
      # Error code -809000 means the collection already exists ... not a problem
      my $rc = grep(/809000/, @out);
      if ($rc == 0) {
        $num_errors++;
        $error_msgs{"$File::Find::name"} = join "\t\t", @out;
        return;
      }
    }
    $num_dirs++;
  }
  elsif (S_ISREG($st_info->mode)) {
    my $srcFile = escape_chars($File::Find::name);
    print "Registering file $srcFile at iRODS path $newObj\n" if $args{v};
    print "ireg -R $destResc -k $srcFile $newObj\n" if $args{t};
    my $pre_ts = time();
    my @out = `ireg -R $destResc -k $srcFile $newObj 2>&1` if not $args{t};
    if ($?) {
      $num_errors++;
      $error_msgs{$srcFile} = join "\t\t", @out;
      return;
    }
    my $post_ts = time();
    if ($args{v}) {
      my $secs = $post_ts - $pre_ts;
      $secs = 1 if $secs eq 0;
      print "Registered in $secs seconds.\n";
    }
    $num_files++;
    $num_bytes += $st_info->size;
  }
}

sub format_interval {
  my ($secs) = @_;
  
  return sprintf ("%dh:%02dm:%02ds (%d secs)",
                  int($secs/(60*60)), ($secs/60)%60,
                  $secs%60, $secs);
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
  die "Usage: $0 [-htv] [-R resource] [-c destColl] [-x excludeFile] localFile|localDir ...
Options are:
  -c destColl - the destination collection path in iRODS where files
       will be registered into. Default is the calling users iRODS 
       home collection.
  -R resource - the iRODS resource where the files will be registered into.
  -h   this message.
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

