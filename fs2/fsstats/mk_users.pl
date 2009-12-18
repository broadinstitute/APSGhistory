#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

open FP, "ypcat passwd|" or die;
while (<FP>) {
  my @f = split /:/;
  my $uname = $dbh->quote($f[0]);
  my $gecos = $dbh->quote($f[4]);
  my $sql = "INSERT INTO users (uid,username,gecos) VALUES ($f[2],$uname,$gecos)";
  $dbh->do($sql);
}
close FP;
exit;
