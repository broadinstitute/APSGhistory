#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql = <<SQL;
SELECT distinct(f.gid), g.name
FROM filesystem f
INNER JOIN grp g ON f.gid=g.id
WHERE deprecated IS FALSE
AND parent IS NULL
ORDER BY gid
SQL
my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();
my %gids;
while (my $ref = $sth->fetchrow_hashref()) {
  $gids{$ref->{'gid'}} = $ref->{'name'};
}

$sql = <<SQL;
SELECT u.blocks, u.used, f.snapshot, f.tapebackup, f.diskbackup
FROM fsusage u
INNER JOIN filesystem f ON u.fsid = f.id
WHERE f.gid = ?
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND u.checked = (SELECT max(checked) FROM fsusage)
SQL

$sth = $dbh->prepare($sql);

my %data;

print "Group, Allocated (TB), Used (TB), Snapshotted, Snapshotted but not backed up, No deletion protection, Mirrored, Backed up, No DR protection\n";
for my $gid (keys %gids) {
  next unless $gid;
  my $nr  = $sth->execute($gid);
  $ads=0; #snapshots
  $adb=0; #tape no snapshots
  $adn=0; #none
  $drm=0; #mirror
  $drb=0; #tape
  $drn=0; #snapshots no tape
  $utotal=0; #total used
  $atotal=0; #total allocated
  while (my $ref = $sth->fetchrow_hashref()) {
    $backup = $ref->{'snapshot'}+$ref->{'tapebackup'}+$ref->{'diskbackup'};
    $blks = $ref->{'blocks'}; 
    $atotal += $ref->{'blocks'};
    $utotal += $ref->{'used'};
    if ($backup == 0) {
      $adn += $blks;
      $drn += $blks;
      next;
    }
    if ($ref->{'diskbackup'} > 0) {
      $drm += $blks;
      $ads += $blks unless $ref->{'snapshot'} > 0;
    }
    if ($ref->{'snapshot'} > 0) {
      $ads += $blks;
      $drn += $blks unless $ref->{'tapebackup'} > 0;
      next;
    }
    if ($ref->{'tapebackup'} > 0) {
      $adb += $blks;
      $drb += $blks;
    } 
  }
  printf "%s, %.2f, %.2f, %.2f, %.2f, %.2f, %.2f, %.2f, %.2f\n",
          $gids{$gid}, $atotal*1E-9, $utotal*1.E-9,
          $ads*1E-9, $adb*1E-9, $adn*1E-9, $drm*1E-9, $drb*1E-9, $drn*1E-9;
}

print "Group, Number of NFS file system, Number of distinct data owners, Number of role users, Number of users with gids, Number with cobjs\n";
$sth = $dbh->prepare($sql);
for my $gid (keys %gids) {
  next unless $gid;
  print "$gids{$gid}";
 
$sql = <<SQL;
SELECT count(distinct(f.id)), count(distinct(s.uid))
FROM fsstat s
INNER JOIN filesystem f on s.fsid = f.id
WHERE f.gid = $gid
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest=1
AND s.type=2
AND s.uid>0
AND s.dirid is NULL
SQL

  $sth = $dbh->prepare($sql);
  $sth->execute();
  while (my @ref = $sth->fetchrow_array()) {
    for (@ref) {
      print ",$_";
    }
  }


$sql = <<SQL;
SELECT count(distinct(s.uid))
FROM fsstat s
INNER JOIN filesystem f on s.fsid = f.id
INNER JOIN users u on s.uid=u.uid
WHERE f.gid = $gid
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest=1
AND s.type=2
AND s.uid>0
AND u.role IS TRUE
AND s.dirid is NULL
SQL

  $sth = $dbh->prepare($sql);
  $sth->execute();
  while (my @ref = $sth->fetchrow_array()) {
    for (@ref) {
      print ",$_";
    }
  }

$sql = <<SQL;
SELECT count(distinct(s.uid))
FROM fsstat s
INNER JOIN filesystem f on s.fsid = f.id
INNER JOIN users u on s.uid=u.uid
WHERE f.gid = $gid
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest=1
AND s.type=2
AND s.uid>0
AND u.role IS FALSE
AND u.gid IS NOT NULL
AND s.dirid is NULL
SQL

  $sth = $dbh->prepare($sql);
  $sth->execute();
  while (my @ref = $sth->fetchrow_array()) {
    for (@ref) {
      print ",$_";
    }
  }
$sql = <<SQL;
SELECT count(distinct(s.uid))
FROM fsstat s
INNER JOIN filesystem f on s.fsid = f.id
INNER JOIN users u on s.uid=u.uid
WHERE f.gid = $gid
AND f.deprecated IS FALSE
AND f.parent IS NULL
AND s.latest=1
AND s.type=2
AND s.uid>0
AND u.role IS FALSE
AND u.cobj IS NOT NULL
AND s.dirid is NULL
SQL


  $sth = $dbh->prepare($sql);
  $sth->execute();
  while (my @ref = $sth->fetchrow_array()) {
    for (@ref) {
      print ",$_";
    }
  }
  print "\n";
}

