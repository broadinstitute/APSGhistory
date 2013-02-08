#!/util/bin/perl -w

use DBI;
use DBD::mysql;

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
SELECT u.blocks, u.used, f.snapshot, f.tapebackup, f.diskbackup, g.name
FROM grp g, fsusage u
INNER JOIN filesystem f ON u.fsid = f.id
WHERE f.gid = ?
AND f.gid=g.id
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND u.checked = (SELECT max(checked) FROM fsusage)
SQL

my $sth = $dbh->prepare($sql);

my %data;

print "Group, Used/Allocated (TB), Backed up, Snapshotted, Snapshotted and backed up, Mirrored, Snapshotted and mirrored, No protection\n";
for my $gid (@gids) {
  next unless $gid;
  my $nr  = $sth->execute($gid);
  $data{'a'}{'s'} = 0;
  $data{'a'}{'t'} = 0;
  $data{'a'}{'d'} = 0;
  $data{'a'}{'st'} = 0;
  $data{'a'}{'sd'} = 0;
  $data{'a'}{'td'} = 0;
  $data{'a'}{'none'} = 0;
  $data{'u'}{'s'} = 0;
  $data{'u'}{'t'} = 0;
  $data{'u'}{'d'} = 0;
  $data{'u'}{'st'} = 0;
  $data{'u'}{'sd'} = 0;
  $data{'u'}{'none'} = 0;
  my $name;
  my $atotal = 0;
  my $utotal = 0;
  while (my $ref = $sth->fetchrow_hashref()) {
    $backup = $ref->{'snapshot'}+$ref->{'tapebackup'}+$ref->{'diskbackup'};
    my $exposed = $backup > 0 ? 0 : 1;
    $data{'a'}{'s'} += $ref->{'snapshot'}   * $ref->{'blocks'};
    $data{'a'}{'t'} += $ref->{'tapebackup'} * $ref->{'blocks'};
    $data{'a'}{'d'} += $ref->{'diskbackup'} * $ref->{'blocks'};
    $data{'a'}{'st'} += $ref->{'snapshot'} * $ref->{'tapebackup'}  * $ref->{'blocks'};
    $data{'a'}{'sd'} += $ref->{'snapshot'} * $ref->{'diskbackup'}  * $ref->{'blocks'};
    $data{'a'}{'none'} += $exposed * $ref->{'blocks'};
    $data{'u'}{'s'} += $ref->{'snapshot'}   * $ref->{'used'};
    $data{'u'}{'t'} += $ref->{'tapebackup'} * $ref->{'used'};
    $data{'u'}{'d'} += $ref->{'diskbackup'} * $ref->{'used'};
    $data{'u'}{'st'} += $ref->{'snapshot'} * $ref->{'tapebackup'}  * $ref->{'used'};
    $data{'u'}{'sd'} += $ref->{'snapshot'} * $ref->{'diskbackup'}  * $ref->{'used'};
    $data{'u'}{'none'} += $exposed * $ref->{'used'};
    $name = $ref->{'name'};
    $atotal += $ref->{'blocks'};
    $utotal += $ref->{'used'};
  }
  printf "%s (allocated), %.2f, %.2f, %.2f, %.2f, %.2f, %.2f, %.2f\n",
          $name, $atotal*1E-9, $data{'a'}{'s'}*1E-9, $data{'a'}{'t'}*1E-9, 
          $data{'a'}{'d'}*1E-9, $data{'a'}{'st'}*1E-9, $data{'a'}{'sd'}*1E-9,
          $data{'a'}{'none'}*1E-9;
  printf "%s (used), %.2f, %.2f, %.2f, %.2f, %.2f, %.2f, %.2f\n",
          $name, $utotal*1E-9, $data{'u'}{'s'}*1E-9, $data{'u'}{'t'}*1E-9, 
          $data{'u'}{'d'}*1E-9, $data{'u'}{'st'}*1E-9, $data{'u'}{'sd'}*1E-9,
          $data{'u'}{'none'}*1E-9;
}
 
