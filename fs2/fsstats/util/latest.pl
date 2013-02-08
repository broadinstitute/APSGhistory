#!/usr/bin/env perl

use DBI;
use DBD::mysql;
use warnings;

my $DEBUG  = 1;
my $DRYRUN = 0;
require 'dbconnect.pl';
##
## Initiate DB connection
##
my $dbh = DBI->connect($dsn, $dbuser, $dbpw);

my $sql = <<SQL;
select a.fsid, a.delta, a.checked
from
(select fsid, max(checked)-min(checked) as 'delta', max(checked) as 'checked'
from fsstat
where latest=1
group by 1) as a
where a.delta > 0
order by a.delta desc
SQL

my $sth = $dbh->prepare($sql);

my $nr = $sth->execute();
print STDERR "Found $nr rows\n" if $DEBUG;
while (my @r = $sth->fetchrow_array()) {
  $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$r[0] AND checked < $r[2]";
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  $sql = "UPDATE fsstat SET latest=1 WHERE fsid=$r[0] AND checked = $r[2]";
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  my $cmd = "./combine.pl -v -f $r[0]";
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd` unless $DRYRUN;
}
