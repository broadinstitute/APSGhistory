#!/usr/bin/env perl

use warnings;

use DBI;
use DBD::mysql;


my $VERBOSE=1;
my $DRYRUN=0;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=bitstore;host=apsgdb04;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT MAX(checked) FROM fsusage";
my $sth = $dbh->prepare($sql);
my $nr = $sth->execute();
unless (defined $nr and $nr > 0) {
  printf STDERR "Query returned no CIFS-only filesystems.\n";
  exit 1;
}
my $when = ($sth->fetchrow_array())[0];

$sql = qq{SELECT ID,SUBSTR(path,7,LENGTH(path)) FROM filesystem WHERE export=2 AND deprecated IS FALSE AND path LIKE 'argon:%'};
$sth = $dbh->prepare($sql);
$nr = $sth->execute();
die "No rows found" unless $nr > 0;
my %fs;
while (my @row = $sth->fetchrow_array()) {
  $fs{$row[1]} = $row[0];
}

my $SNMPCMD = 'snmpwalk -v 2c -c public -m /usr/share/snmp/mibs/ISILON-MIB.txt argon quotaTable';

my (%n,%q,%u);
open SNMP, "$SNMPCMD |" or die "SNMP: $!";
while (<SNMP>) {
  chomp;
  /quotaPath\.([^.]+)\.\d+ = STRING: (.*)/ and do {
    next unless defined $fs{$2};
    $n{$1} = $2;
  };
  /quotaHardThreshold\.([^.]+)\.\d+ = Counter64: (.*)/ and do {
    next unless defined $n{$1};
    $q{$1} = int($2/1024 + 0.5);
  };
  /quotaUsage\.([^.]+)\.\d+ = Counter64: (.*)/ and do {
    next unless defined $n{$1};
    $fsid = $fs{$n{$1}};
    $used = int($2/1024 + 0.5);
    $blks  = $q{$1};
    $avail = $blks-$used;
    $pct = int($used/$blks*100);
    $sql = qq{INSERT INTO fsusage VALUES($fsid,$when,$blks,$used,$avail,$pct)};
    print "$sql\n" if $VERBOSE;
    $dbh->do($sql) unless $DRYRUN;
  };
}
