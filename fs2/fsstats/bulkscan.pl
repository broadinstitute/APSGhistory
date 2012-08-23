#!/usr/bin/env perl

use DBI;
use DBD::mysql;
use warnings;

my $DEBUG=1;

unless (defined $ENV{'LSF_CLUSTER_NAME'}) {
  print STDERR "You muse \'use LSF\' before running this. (Did you \`sudo -E\`?)\n";
  exit 1;
}

##
## Initiate DB connection
##
my ($dsn,$dbh);
$dsn = "DBI:mysql:database=bitstore;host=apsgdb04;port=3306";
$dbh = DBI->connect($dsn, "bitstore_ro", "25emZ*wid");

my ($sql, $sth, $nr);
##
## Get list of filesystems to look at
##
$sql = qq{SELECT id FROM filesystem WHERE acct>1 AND parent IS NULL AND deprecated IS FALSE};
$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
print STDERR "Found $nr filesystems to scan\n" if $DEBUG;
while (my $fsid = ($sth->fetchrow_array())[0]) {
  my $cmd = "/home/radon00/matter/sandbox/fsstats/scanfs.pl -v --force-update -f $fsid";
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd`;
}
exit;

