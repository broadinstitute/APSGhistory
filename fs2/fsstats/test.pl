#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = <<SQL;
select fsid, dirid 
from fsstat 
where checked = 1234313071
and latest=0
and uid is null
and type=2
SQL

my $sth = $dbh->prepare($sql);

$sql = <<SQL;
select count(*)
from fsstat 
where fsid = ?
and dirid = ?
and latest=1
and uid is null
and type=2
SQL

my $q = $dbh->prepare($sql);

my $nr = $sth->execute();
print STDERR "Found $nr rows\n";
my $n = 0;
while (my @r = $sth->fetchrow_array()) {
  $nr = $q->execute(@r);
  print STDERR "." unless ++$n%100;
  @a = $q->fetchrow_array();
  if ($a[0] > 0) {
    print "Here: ",join " ", @r, "\n";
  } else {
    $sql = "update fsstat set latest=1 where checked=1234313071 and fsid=$r[0] and dirid=$r[1]";
#    print "$sql\n";
    $dbh->do($sql);
  }
}
