#!/usr/bin/env perl

use DBI;
use DBD::mysql;
use Getopt::Std;

use vars qw($opt_d $opt_t);

my $DEBUG =1;
my $DRYRUN=0;

##
## Process command-line options
##
getopt('dt');
unless (defined $opt_d and defined $opt_t) {
  warn "usage: $0 -d directory -t timestamp";
  exit;
}
$opt_d =~ s,/$,,;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT * FROM stat_type";
my $sth = $dbh->prepare($sql);

$sth->execute();
while (my $ref = $sth->fetchrow_hashref()) {
  $type{$ref->{'name'}} = $ref->{'id'};
}

my $checked = $opt_t;

my $fsid;
($fsid = $opt_d) =~ s,.*$opt_t/,,;
##
## Find files to upload
##
opendir DP, "$opt_d" or die "could not read $opt_d: $!";
my @csv = grep /[0-9]\.csv/, readdir DP;
closedir DP;

my $atime = 0;
my $valcnt;
my $dirid;
for my $f (@csv) {
  ($dirid = $f) =~ s/\.csv//;
  my $uid = undef;
  my $hist = 0;
  my ($tid, $sumcnt, $sumval, $maxcnt, $maxval);
  my $blob = undef;
  open FP, "$opt_d/$f" or die "could not read $f: $!";
  print "Processing $f...\n";
  $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$fsid AND dirid=$dirid AND latest=1";
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  $sql = "DELETE FROM fsstat WHERE fsid=$fsid AND dirid=$dirid AND checked=$checked";
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  while (<FP>) {
    chomp;
    /histogram/ and do {
      die "missing type for $_" unless defined $type{$_};
      $tid = $type{$_};
      next;
    };
    /^bucket/ and do {
      $hist = 1;
      $maxval = $maxcnt = -1;
      $sumval = $sumcnt = 0;
      next;
    };
    /^\d/ and do {
      $blob = defined $blob ? $blob . ":$_" : $_;
      my @f = split /,/;
      $maxcnt = $f[2] > $maxcnt ? $f[2] : $maxcnt;
      $maxval = $f[3] > $maxval ? $f[3] : $maxval;
      $sumcnt += $f[2];
      $sumval += $f[3];
      next;
    };
    /stats for user (\d+)/ and do {
      $uid = $1;
      next;
    };
    /--------/ and do {
      $uid = undef;
      next;
    };
    /^$/ and do {
      next unless $hist;
      next unless $sumcnt;		# Skip if count==0;
      unless ($tid == 1 or $tid == 2 or $tid == 11 or $tid == 13 or $tid == 15) {
        next;
      }
      if (defined $uid) {
        $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram)";
        $sql .= " VALUES ($fsid,$dirid,$checked,1,$uid,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
      } else {
        $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram)";
        $sql .= " VALUES ($fsid,$dirid,$checked,1,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
      }
      print STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      $hist = 0;
      $blob = undef;
    };
  }
  close FP;
}
