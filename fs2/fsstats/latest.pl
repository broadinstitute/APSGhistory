#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my $DEBUG  = 1;
my $DRYRUN = 0;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = <<SQL;
SELECT fsid, dirid, MAX(checked)
FROM fsstat 
GROUP BY fsid,dirid
SQL

my $sth = $dbh->prepare($sql);

my $nr = $sth->execute();
print STDERR "Found $nr rows\n" if $DEBUG;
while (my @r = $sth->fetchrow_array()) {
  if (defined $r[1]) {
    $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$r[0] AND dirid=$r[1] AND checked < $r[2]";
  } else {
    $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$r[0] AND dirid IS NULL AND checked < $r[2]";
  }
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  if (defined $r[1]) {
    $sql = "UPDATE fsstat SET latest=1 WHERE fsid=$r[0] AND dirid=$r[1] AND checked = $r[2]";
  } else {
    $sql = "UPDATE fsstat SET latest=1 WHERE fsid=$r[0] AND dirid IS NULL AND checked = $r[2]";
  }
  print STDERR "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
}
