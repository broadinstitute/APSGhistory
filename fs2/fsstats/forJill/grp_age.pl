#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my %ind = (
           '0' => 1,
           '2' => 1,
           '4' => 1,
           '8' => 1,
           '16' => 2,
           '32' => 2,
           '64' => 3,
           '128' => 4,
           '256' => 5,
           '512' => 6,
           '1024' => 7,
           '2048' => 8,
           '4096' => 8,
           '8192' => 8
          );

my %lab = (
           1 => "< 1 week",
           2 => "1 week - 1 month",
           3 => "1 - 2 months",
           4 => "2 - 4 months",
           5 => "4 - 8 months",
           6 => "8 - 18 months",
           7 => "18 months - 3 years",
           8 => "> 3 years"
          );

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql = <<SQL;
SELECT distinct(f.gid),g.name
FROM filesystem f
INNER JOIN grp g on f.gid=g.id
WHERE deprecated IS FALSE
AND parent IS NULL
ORDER BY f.gid
SQL

my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
my %gids;
while (my @row = $sth->fetchrow_array()) {
  $gids{$row[0]} = $row[1];
}

$sql = <<SQL;
SELECT s.histogram,f.gid,t.id
FROM fsstat s
INNER JOIN filesystem f ON s.fsid = f.id
INNER JOIN server_type t on t.id=f.type
WHERE f.gid = ?
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest IS TRUE
AND s.dirid IS NULL
AND s.uid IS NULL
AND s.type = 15
SQL

$sth = $dbh->prepare($sql);

my %dat;
for my $gid (keys %gids) {
  next unless $gid;
  my $nr  = $sth->execute($gid);
  while (my @row = $sth->fetchrow_array()) {
    $hist = $row[0];
    my @lines = split /:/, $hist;
    for my $line (@lines) {
      my @f = split /,/, $line;
#      my $key = "$f[0],$f[1]";
      my $key = $ind{$f[0]};
      my $val = $f[2];
      my $type;
      if ($row[2] == 1 or $row[2] == 4) {
        $type = '$$$$$';
      } elsif ($row[2] == 2 or $row[2] == 5) {
        $type = '$';
      } else {
        $type = '$$$';
      }
      $dat{$row[1]}{$type}{$key} += $val*1E-9;
    }
  }
}
print "Group,Storage Cost";
for my $k (1..8) {
  print ",$lab{$k}";
}
print "\n";
for my $gid (keys %gids) {
  for my $tid (sort keys %{$dat{$gid}}) {
    print "$gids{$gid},$tid";
    for my $k (1..8) {
      my $val = defined $dat{$gid}{$tid}{$k} ? $dat{$gid}{$tid}{$k} : 0;
      print ",$val";
    }
    print "\n";
  }
}
 
