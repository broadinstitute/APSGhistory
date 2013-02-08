#!/usr/bin/env perl

use warnings;

use DBI;
use DBD::mysql;


my $VERBOSE=1;
my $DRYRUN=0;

my $CIFSDF = '/sysman/scratch/storage/thumper_cifsdf.txt';

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

#$sql = "SELECT id, path FROM filesystem WHERE cifsonly is true and deprecated is false and (mount like '\\\\\\\\thumper%' escape '|' or mount like '\\\\\\\\sunexa%' escape '|')";
$sql = "SELECT id, path FROM filesystem WHERE export in (0,2) and deprecated is false and (path like 'thumper%' or path like 'sunexa%')";
print "$sql\n" if $VERBOSE;
$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
unless (defined $nr and $nr > 0) {
  printf STDERR "Query returned no CIFS-only filesystems.\n";
  exit 1;
}
my %fsid;
while (my @row = $sth->fetchrow_array()) {
  $fsid{$row[1]} = $row[0];
}
open FP, "$CIFSDF" or die "could not open $CIFSDF: $!";

while (<FP>) {
  chomp;
  my @f = split/:\s+/, $_, 2;
  my $host = $f[0];
  @f = split /\s+/, $f[1];
  next unless defined $f[5];
  my $tpath = "$host:$f[5]";
  next unless defined $fsid{$tpath};
  my $p= $f[4];
  $p =~ s/%//;
  $sql = "INSERT INTO fsusage VALUES($fsid{$tpath},$when,$f[1],$f[2],$f[3],$p)";
  print "$sql\n" if $VERBOSE;
  $dbh->do($sql) unless $DRYRUN;
}
