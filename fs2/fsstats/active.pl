#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT max(checked) FROM fsusage";
my $sth=$dbh->prepare($sql);
$sth->execute();

my $latest = ($sth->fetchrow_array())[0];

$sql = "SELECT max(checked) FROM fsusage WHERE checked < $latest";
$sth = $dbh->prepare($sql);
$sth->execute();

#my $prev = ($sth->fetchrow_array())[0];

$sql = "SELECT f.mount,f.path,u.fsid,u.used,u.blocks FROM fsusage u INNER JOIN filesystem f ON f.id=u.fsid WHERE u.checked = $latest";
$sth = $dbh->prepare($sql);
$sth->execute();

my %data;
my ($mount,$path, $fsid,$used,$blks);
while (($mount,$path,$fsid,$used,$blks) = $sth->fetchrow_array()) {
  $sql = "SELECT min(checked) from fsusage where fsid=$fsid and used=$used and blocks=$blks";
  my $fq = $dbh->prepare($sql);
  $fq->execute();
  my $last = ($fq->fetchrow_array())[0];
  printf "$mount ($path) unchanged for %.0f weeks\n", ($latest - $last)/(7*86400), "\n" unless $last == $latest;
   $used *= 1E-6;
#  print "$mount,$path,$used,$last\n" unless $last == $latest;
#  print "$mount,$path,$used,$last\n";
  $data{$fsid}{'mount'} = $mount;
  $data{$fsid}{'used'} = $used;
}
