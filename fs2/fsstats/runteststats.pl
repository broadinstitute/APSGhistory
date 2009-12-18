#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my $PRG = "/util/bin/perl /sysman/scratch/matter/sandbox/fsstats/teststats";
my $DIR = "/broad/hptmp/matter/allstats_20081021";
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
  my $server = $ref->{'server'};
  my $res = "";
  my $queue;
  if (   $server =~ /nitrogen/ or $server =~ /sunexa/ 
      or $server =~ /thumper/  or $server =~ /helium/ 
      or $server =~ /iodine/ ) {
    $res = "";
  } else {
    $res = "-R \"rusage[${server}_io=8]\"";
  }
  if ($mount =~ m,/seq/trace, or $mount =~ m,/seq/project,) {
    $queue = "classic";
  } else {
    $queue = "broad";
  }
  my $cmd = "\'$PRG $mount > $DIR/${id}.csv\'";
  $cmd = "bsub -q $queue -o /dev/null " . $cmd;
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd\n`;
  sleep $SLEEP;
}

