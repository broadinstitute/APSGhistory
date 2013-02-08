#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT checked,fsid FROM fsstat ORDER by fsid, checked DESC";
my $sth = $dbh->prepare($sql);

$sth->execute();
my $fsid=-1;
my $chck;
while (my $ref = $sth->fetchrow_hashref()) {
  next if ($ref->{'fsid'} == $fsid);
  $fsid = $ref->{'fsid'};
  print "Update fsid $fsid\n";
  $chck = $ref->{'checked'};
#  $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$fsid AND checked<$chck";
#  $dbh->do($sql);
  $sql = "UPDATE fsstat SET latest=1 WHERE fsid=$fsid AND checked=$chck";
  $dbh->do($sql);
}
exit;
