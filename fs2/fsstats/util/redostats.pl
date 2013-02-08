#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my %redo;
open FP, "redolist.csv" or die ":$!";
while (<FP>) {
  chomp;
  $redo{$_} = 1;
}

my $PRG = "/util/bin/perl /sysman/scratch/matter/sandbox/fsstats/mystats";
my $DEBUG = 1;
my $SLEEP = 20;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql;
$sql  = "SELECT f.id, f.mount, SUBSTRING_INDEX(f.path, ':', 1) server ";
$sql .= "FROM filesystem f, fsusage u ";
$sql .= "WHERE u.canonical_fsid IS NULL ";
$sql .= "AND u.fsid = f.id ";
$sql .= "AND u.checked = (SELECT MAX(checked) FROM fsusage) ";
$sql .= "ORDER BY RAND() ";

print STDERR "$sql\n" if $DEBUG;

my $sth = $dbh->prepare($sql);
$sth->execute();
my $n=0;
while (my $ref = $sth->fetchrow_hashref()) {
#  last if ++$n > 5;
  my $id = $ref->{'id'};
  my $mount = $ref->{'mount'};
  next unless defined $redo{$mount};
  my $server = $ref->{'server'};
  my $res = "";
  if (   $server =~ /nitrogen/ or $server =~ /sunexa/ 
      or $server =~ /thumper/  or $server =~ /helium/ 
      or $server =~ /iodine/ ) {
    $res = "";
  } else {
    $res = "-R \"rusage[${server}_io=10]\"";
  }
  next if $mount =~ /solexaproc/;
  next if $mount =~ /wgas\d/;
  my $cmd = "$PRG -c /local/scratch/${id}.ckpt -o nstats/${id}.csv $mount";
  $cmd = "bsub -o stats/${id}.out $res " . $cmd;
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd\n`;
  sleep $SLEEP;
}

