#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = qq{select username from users where username = ?};
my $sth = $dbh->prepare($sql);

open FP, "ypcat passwd|" or die;
while (<FP>) {
  my @f = split /:/;
  my $uname = $dbh->quote($f[0]);
  my $gecos = $dbh->quote($f[4]);
  my $nr = $sth->execute($f[0]);
  next if $nr > 0;
  print "Hmm $uname ($nr)\n";
  my $sql = "INSERT INTO users (uid,username,gecos) VALUES ($f[2],$uname,$gecos)";
  print "$sql\n";
#  $dbh->do($sql);
}
close FP;
exit;
