#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my $DEBUG=1;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql = "SELECT DISTINCT(checked) FROM fsusage";
my $sth = $dbh->prepare($sql);
my @dates;
$sth->execute();
while (my $ref = $sth->fetchrow_hashref()) {
  push @dates, $ref->{'checked'};
}

for my $date (@dates) {

$sql=<<"SQL";
SELECT u.fsid, u.blocks, u.used, f.mount mount, f.path path, u.canonical_fsid
FROM fsusage u
INNER JOIN filesystem f on f.id = u.fsid
WHERE checked=$date
AND u.canonical_fsid IS NULL
SQL

  my $sth = $dbh->prepare($sql);
  $sth->execute();

  my %paths = ();
  my %mnts = ();
  my %blks = ();
  my %used = ();
  while (my $ref = $sth->fetchrow_hashref()) {
    $paths{$ref->{'fsid'}} = $ref->{'path'};
    $mnts{$ref->{'fsid'}} = $ref->{'mount'};
    $blks{$ref->{'fsid'}} = $ref->{'blocks'};
    $used{$ref->{'fsid'}} = $ref->{'used'};
  }

  $sth = $dbh->prepare($sql);
  $sth->execute();
  while (my $ref = $sth->fetchrow_hashref()) {
    my $fsid = $ref->{'fsid'};
    my $path = $ref->{'path'};
    my $mnt  = $ref->{'mount'};
    my $base = $path;
    $base =~ s|(/[^/]+)/.*|$1|;
    my $blks  = $ref->{'blocks'};
    my $used  = $ref->{'used'};
    my $cid  = $ref->{'canonical_fsid'};
    for my $p (sort {$a<=>$b} keys %paths) {
      next if $p <= $fsid;
      if ($paths{$p} eq $path) {
        print "found $path ($fsid <-> $p) ($mnt <-> $mnts{$p})\n" if $DEBUG;
        if ($mnt =~ m|/broad/| and $mnts{$p} =~ m|/seq/|) {
          $sql = "UPDATE fsusage SET canonical_fsid=$p WHERE fsid=$fsid AND checked=$date";
        } else {
          $sql = "UPDATE fsusage SET canonical_fsid=$fsid WHERE fsid=$p AND checked=$date";
        }
        print "$sql\n" if $DEBUG;
#        $dbh->do($sql);
        next;
      }
      if ($paths{$p} =~ m|^$path/|) {
        print "found $path ($fsid <-> $p) ($path <-> $paths{$p})\n" if $DEBUG;
        $sql = "UPDATE fsusage SET canonical_fsid=$fsid WHERE fsid=$p AND checked=$date";
        print "$sql\n" if $DEBUG;
#        $dbh->do($sql);
      }
      if ($paths{$p} =~ m|^$base/| and $path =~/nitrogen/  and $blks{$p} == $blks and $used{$p} == $used) {
        print "found $path ($fsid <-> $p) ($path <-> $paths{$p}) ($base)\n" if $DEBUG;
        $sql = "UPDATE fsusage SET canonical_fsid=$fsid WHERE fsid=$p AND checked=$date";
        print "$sql\n" if $DEBUG;
#        $dbh->do($sql);
      }
    }
  }
}
