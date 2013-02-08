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
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = <<SQL;
SELECT distinct(gid)
FROM filesystem
WHERE deprecated IS FALSE
AND parent IS NULL
ORDER BY gid
SQL
my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
my @gids;
while (my $ref = $sth->fetchrow_hashref()) {
  push @gids,$ref->{'gid'};
}

$sql = <<SQL;
SELECT s.histogram, g.name
FROM grp g, fsstat s
INNER JOIN filesystem f ON s.fsid = f.id
WHERE f.gid = ?
AND f.gid=g.id
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest IS TRUE
AND s.dirid IS NULL
AND s.uid IS NULL
AND s.type = 15
SQL

$sth = $dbh->prepare($sql);

my @k = ("0,0","2,4","4,8","8,16","16,32","32,64","64,128","128,256","256,512",
           "512,1024","1024,2048","2048,4096","4096,8192","8192,16384");


for my $gid (@gids) {
  next unless $gid;
  my $nr  = $sth->execute($gid);
  my $name;
  my %dat;
  while (my $ref = $sth->fetchrow_hashref()) {
    $name = $ref->{'name'};
    $hist = $ref->{'histogram'};
    my @lines = split /:/, $hist;
    for my $line (@lines) {
      my @f = split /,/, $line;
#      my $key = "$f[0],$f[1]";
      my $key = $ind{$f[0]};
      my $val = $f[2];
      $dat{$key} += $val*1E-9;
    }
  }
  print "$name\n";
  for my $key (sort {$a<=>$b} keys %lab) {
    my $val = defined $dat{$key} ? $dat{$key} : 0;
    printf "%s,%.2f\n", $lab{$key},$val;
  }
}
 
