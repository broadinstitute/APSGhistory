#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

open FP, "update.txt" or die "could not open update.txt: $!";

while (<FP>) {
  print;
  chomp;
  $dbh->do($_);
}
