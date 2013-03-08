#!/usr/bin/env perl 

use warnings;

use DBI;
use DBD::mysql;
use vars qw($dsn $dbuser $dbpw);

require '/broad/B1Tst0re/scanfs/dbconnect.pl';

my $DRYRUN=1;
my $VERBOSE=1;

##
## Get list of filesystems to look at
##
my @maps;
my $cmd = "ypcat auto.master | awk '{print \$1}'";
open(CMD, "$cmd |") or die "Unable to run $cmd: $!\n";
while (<CMD>) {
	chomp;
	push @maps, $_
}

for my $map (@maps) {
  $cmd = "ypcat -k $map | awk '{print \$1}'";
  ($dir = $map) =~ s/auto\.//;
  open(CMD, "$cmd |") or die "Unable to run $cmd: $!\n";
  while (<CMD>) {
	chomp;
	push @filesys, "/$dir/$_";
  }
}

##
## Initiate DB connection
##
my $dbh = DBI->connect($dsn, $dbuser, $dbpw);

##
## Get list of fsids
##
my %fsid;
my $sql = "SELECT * FROM filesystem";
my $sth = $dbh->prepare($sql);
$sth->execute;
while (my $ref = $sth->fetchrow_hashref()) {
    next unless defined $ref->{'mount'};
    my $key = $ref->{'mount'} . "::" . $ref->{'path'};
    $fsid{$key} = $ref->{'id'};
}

##
## Get time and round to nearest GMT midnight 
##
$when = int(time()/86400+0.5) * 86400;


foreach my $filesys (sort @filesys) {

	my ($path,$blks,$used,$avail,$cap,$mount);

	my $df = "df -k $filesys | tr -d % | tail -n +2";
        my $line;
        eval {
          my $success = 1;
          local $SIG{ALRM} = sub {$success = 0};
          alarm 20;
	  open DF, "$df | "  or die "Unable to run $df: $!\n";
	  $line = join " ", <DF>;
          chomp $line;
          close DF;
          alarm 0;
          return $success;
        } or do {
          print STDERR "df of $filesys timed out. Skipping.\n";
          next;
        };
	($path,$blks,$used,$avail,$cap,$mount) = split /\s+/, $line;
        print STDERR "skipping $filesys\n" and next unless $path;
        my $key  = $mount . "::" . $path;
        if ($key =~ /automount/) {
          warn "Here: $filesys $key ($line)";
          sleep 10;
          next;
        }
        my $fsid = defined $fsid{$key} ? $fsid{$key} 
                                       : getfsid($dbh, $mount, $path);
        die "unknown fsid" unless $fsid;
        print "$fsid: $path [$mount]\n" if $VERBOSE;
        my $sql = "DELETE FROM fsusage WHERE fsid=$fsid AND checked=$when";
        if ($DRYRUN) {
          print "$sql\n";
        } else {
          $dbh->do($sql);
        }
        $sql = "INSERT INTO fsusage(fsid,checked,blocks,used,available,capacity) VALUES ($fsid,$when,$blks,$used,$avail,$cap)";
        if ($DRYRUN) {
          print "$sql\n";
        } else {
          $dbh->do($sql);
        }
	sleep 7;
}

exit;

sub getfsid {
  my $dbh   = shift;
  my $mount = shift;
  my $path  = shift;

  my $sql = qq{SELECT id FROM filesystem where mount="$mount" and path="$path"};
  my $sth = $dbh->prepare($sql);

  $sth->execute;
  if ($sth->rows) {
    my $ref = $sth->fetchrow_hashref();
    return $ref->{'id'};
  }
  $sql = sprintf("INSERT INTO filesystem (mount, path) VALUES (%s, %s)",
                 $dbh->quote($mount), $dbh->quote($path));
  print "Found new filesystem: $mount ($path)\n";
  $dbh->do($sql) unless $DRYRUN;
  return getfsid($dbh,$mount,$path);
}
