#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT mount FROM filesystem WHERE id=?";
my $sth = $dbh->prepare($sql);

opendir DP, "stats" or die "could not read stats directory: $!";

my @csv = grep /\.csv/, readdir DP;

closedir DP;

my %stats;
my $s1,$s2;
my $fsid;
for my $file (@csv) {
  ($fsid = $file) =~ s/\.csv//;
  $sth->execute($fsid);
  my @r = $sth->fetchrow_array();
  my $mount = $r[0];
  next if $mount =~ m|/slxa|;
  next if $mount =~ m|/seq/project|;
  next if $mount =~ m|/seq/trace|;
  print "processing $file ($mount).";
  open FP, "stats/$file" or die "could not read $file: $!";
  while (<FP>) {
    chomp;
    last if /^histogram,atime \(KB/;
  }
  while (<FP>) {
    last if /^bucket/;
  }
  while (<FP>) {
    chomp;
    last if /^$/;
    my @f = split /,/;
    next if $f[0] < 0;
    my $k = "$f[0]-$f[1]";
    $stats{$k} += $f[2];
    $s1 += $f[2];
  }
  print "...done\n";
}

for my $key (sort {substr($b,index($b,"-")) <=> substr($a,index($a,"-"))} keys %stats) {
  printf "$key,%.2f\n", $stats{$key}/1000000000;
  $s2 += $stats{$key};
}
print "Here: $s1, $s2\n";
