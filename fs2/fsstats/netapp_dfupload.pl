#!/usr/bin/env perl

use warnings;

use DBI;
use DBD::mysql;


my $VERBOSE=0;
my $DRYRUN=0;

my $CIFSDF = '/sysman/scratch/storage/netapp_cifsdf.txt';

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=bitstore;host=apsgdb04;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");


my $sql = "SELECT MAX(checked) FROM fsusage";
my $sth = $dbh->prepare($sql);
my $nr = $sth->execute();
die unless (defined $nr and $nr > 0);
my $when = ($sth->fetchrow_array())[0];

$sql = "SELECT id, path, export FROM filesystem WHERE path=?";
print "$sql\n" if $VERBOSE;
$sth = $dbh->prepare($sql);

open FP, "$CIFSDF" or die "could not open $CIFSDF: $!";
my $head = <FP>;
while (<FP>) {
  chomp;
  my @f = split/\|/;
  my $nr = $sth->execute($f[5]);
  if (defined $nr and $nr > 0) {
    my @row = $sth->fetchrow_array();
    next unless defined $row[2] and $row[2]==2; # Skip unless cifs only
    my $fsid = $row[0];
    $sql = "INSERT INTO fsusage VALUES($fsid,$when,$f[1],$f[2],$f[3],$f[4])";
    print "$sql\n" if $VERBOSE;
    $dbh->do($sql) unless $DRYRUN;
  } else {
    ($mount = $f[0]) =~ s/\\/\\\\/g;
    if($f[5] =~ /radon:/ or $f[5] =~ /krypton:/) {
      $sql = "INSERT INTO filesystem(mount,path,export,gid,sscid,type,tapebackup) VALUES('$mount','$f[5]',2,23,23,1,1)";
    } else {
      $sql = "INSERT INTO filesystem(mount,path,export,type,tapebackup) VALUES('$mount','$f[5]',2,1,1)";
    }
    printf STDERR "$sql\n";
  }
}
