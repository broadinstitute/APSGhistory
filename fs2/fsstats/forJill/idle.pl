#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql = <<SQL;
SELECT id,mount
FROM filesystem f
WHERE deprecated IS FALSE
AND parent IS NULL
SQL

my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
my %fsids;
while (my @row = $sth->fetchrow_array()) {
  $fsids{$row[0]} = $row[1];
}

$sql = <<SQL;
SELECT checked,blocks,used
FROM fsusage
WHERE fsid=?
AND checked=(SELECT MAX(checked) FROM fsusage WHERE fsid=?)
SQL

my $lst = $dbh->prepare($sql);

$sql = <<SQL;
SELECT min(checked)
FROM fsusage
WHERE fsid=?
AND blocks=?
AND used=?
SQL

my $old = $dbh->prepare($sql);

for my $fsid (keys %fsids) {
  next unless $fsid;
  my $nr  = $lst->execute($fsid,$fsid);
  my @dat;
  @dat = $lst->fetchrow_array();
  $nr = $old->execute($fsid,$dat[1],$dat[2]);
  next unless $nr;
  @row = $old->fetchrow_array();
  if ($row[0] == $dat[0]) {
#    print "$fsids{$fsid} is not idle\n";
  } else {
    printf "%s has been idle for %d weeks\n",
           $fsids{$fsid}, int(($dat[0]-$row[0])/(7*86400)+0.5);
  }
}
