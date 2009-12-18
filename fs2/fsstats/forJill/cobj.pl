#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql = <<SQL;
SELECT distinct(u.fsid),f.mount
FROM fsusage u
INNER JOIN filesystem f on f.id=u.fsid
WHERE f.deprecated IS FALSE
AND f.parent IS NULL
AND u.fsid > 0
AND u.checked = (select max(checked) from fsusage)
ORDER by u.blocks ASC
SQL

my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
my %fsids;
while (my @row = $sth->fetchrow_array()) {
  $fsids{$row[0]} = $row[1];
}

$sql = <<SQL;
SELECT s.sumval, s.uid, u.username, u.cobj
FROM fsstat s
INNER JOIN filesystem f ON s.fsid = f.id
INNER JOIN users u on s.uid=u.uid
WHERE f.id = ?
AND s.latest IS TRUE
AND s.dirid IS NULL
AND s.uid IS NOT NULL
AND s.type = 2
SQL

$sth = $dbh->prepare($sql);

for my $fsid (keys %fsids) {
  next unless $fsid;
  my %dat = ();
  my $ncobj = 0;
  my $total = 0;
  my $nr  = $sth->execute($fsid);
  while (my @row = $sth->fetchrow_array()) {
    my $sumval = $row[0];
    $total += $sumval;
    if ($row[3]) {
      my @c = split /\;/, $row[3];
      my $t = 0;
      for my $c (@c) {
        ($o,$p) = split /:/,$c;
        $t += $p;
      }
      my $fact = 100/$t;
      for my $c (@c) {
        ($o,$p) = split /:/,$c;
        $dat{$o} += $p*$fact*$sumval/100;
      }
    } else {
      $ncobj += $sumval;
    }
  }
  printf "%s (%.2fT):\n",$fsids{$fsid},$total*1E-9;
  for my $o (sort keys %dat) {
    printf "%d: %.1f%%\n", $o, $dat{$o}/$total*100;
  }
  printf "no cost object: %.1f%%\n\n", $ncobj/$total*100 if $total;
}
 
