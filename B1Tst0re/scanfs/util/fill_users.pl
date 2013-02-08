#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT DISTINCT(uid) FROM fsstat WHERE uid NOT IN (SELECT uid FROM users)";

my $sth = $dbh->prepare($sql);
my $nr = $sth->execute();

my $sql;
while (my $ref=$sth->fetchrow_hashref()) {
  my $uid = $ref->{'uid'};
  my $line = `ypmatch $uid passwd.byuid 2>/dev/null`;
  if ($line) {  
    my ($username,$gecos);
    ($username, $gecos) = (split /:/, $line)[0,4];
    $sql = "INSERT INTO users (uid,username,gecos) VALUES ('$uid','$username','$gecos')";
  } else {
    $sql = "INSERT INTO users (uid) VALUES ($uid)";
  }
  print "$sql\n";
  $dbh->do($sql);
}
exit;
