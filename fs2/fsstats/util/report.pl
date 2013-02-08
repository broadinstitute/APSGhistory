#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = <<SQL;
SELECT distinct(fsid)
FROM fsstat s
INNER JOIN filesystem f on s.fsid=f.id
WHERE latest=1
AND fsid>0
AND f.deprecated IS FALSE
AND f.parent IS NULL
ORDER BY f.mount
SQL

my $qry = <<SQL2;
SELECT s.fsid, f.mount, s.uid,u.username,u.gecos, g.name, max(sumval)
FROM grp g, fsstat s
INNER JOIN users u ON s.uid = u.uid
INNER JOIN filesystem f ON s.fsid = f.id
WHERE s.fsid = ?
AND s.type = 2
AND s.latest = 1
AND s.uid>0
AND f.gid=g.id
AND dirid IS NULL
GROUP BY s.uid
ORDER by max(sumval) DESC
SQL2
my $qh = $dbh->prepare($qry);

my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
print "There: $nr\n";
while (my $ref = $sth->fetchrow_hashref()) {
  my $fsid = $ref->{'fsid'};
  $nr  = $qh->execute($fsid);

  $uref = $qh->fetchrow_hashref();
#  print "skipping $fsid\n" and next unless defined $uref->{'mount'};
  next unless defined $uref->{'mount'};
#  printf "%s: %s (%s)\n", $uref->{'mount'}, $uref->{'gecos'}, $uref->{'name'};
  $user = defined $uref->{'username'} ? $uref->{'username'} : $uref->{'uid'};
  printf "%s, %s\n", $uref->{'mount'}, $user;
}
