#!/usr/bin/env perl

use warnings;

use DBI;
use DBD::mysql;


my $VERBOSE=1;
my $DRYRUN=0;

our($dsn,$dbuser,$dbpw);
require 'dbconnect.pl';
##
## Initiate DB connection
##
my $dbh = DBI->connect($dsn, $dbuser, $dbpw);

my $sql = "SELECT MAX(checked) FROM fsusage";
my $sth = $dbh->prepare($sql);
my $nr = $sth->execute();
unless (defined $nr and $nr > 0) {
  printf STDERR "Query of fsusage failed.\n";
  exit 1;
}
my $when = ($sth->fetchrow_array())[0];

$sql = qq{SELECT ID,SUBSTR(path,11,LENGTH(path)) FROM filesystem WHERE export=2 AND deprecated IS FALSE AND path LIKE 'lightning:%'};
$sth = $dbh->prepare($sql);
$nr = $sth->execute();
die "No rows found" unless $nr > 0;
my %fs;
while (my @row = $sth->fetchrow_array()) {
  $fs{$row[1]} = $row[0];
}

my $SNMPCMD = 'snmpwalk -v 2c -c public -m /usr/share/snmp/mibs/SUN-AK-MIB.txt lightning sunAkMIB';

my (%n,%q,%u);
open SNMP, "$SNMPCMD |" or die "SNMP: $!";
while (<SNMP>) {
  chomp;
# SUN-AK-MIB::sunAkShareName.53 = STRING: pool1/Proteomics/silac
# SUN-AK-MIB::sunAkShareMountpoint.53 = STRING: /export/proteomics/silac
  /sunAkShareMountpoint\.(\d+) = STRING: (.*)/ and do {
    next unless defined $fs{$2};
    $n{$1} = $2;
    next;
  };
# SUN-AK-MIB::sunAkShareSizeB.53 = Counter64: 8246337099744
  /sunAkShareSizeB\.(\d+) = Counter64: (\d+)/ and do {
    next unless defined $n{$1};
    $q{$1} = int($2/1024 + 0.5);
    next;
  };
# SUN-AK-MIB::sunAkShareUsedB.53 = Counter64: 6615812513520
  /sunAkShareUsedB\.(\d+) = Counter64: (\d+)/ and do {
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

# SUN-AK-MIB::sunAkShareAvailableB.53 = Counter64: 1630524586224
}
