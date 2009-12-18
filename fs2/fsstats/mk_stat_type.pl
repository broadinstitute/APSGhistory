#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my %stat;
my $id = 0;
open FP, "wgas.csv" or die;
while (<FP>) {
  next unless /^histogram/;
  chomp;
  my $type = $_;
  next if defined $stat{$type};
  my $sql = "INSERT INTO stat_type (name) VALUES (\"$type\")";
  $dbh->do($sql);
  ++$id;
  $stat{$type} = $id;
}
close FP;
exit;
