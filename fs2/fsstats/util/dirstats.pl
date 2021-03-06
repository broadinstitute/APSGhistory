#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my $PRG = "/util/bin/perl /sysman/scratch/matter/sandbox/fsstats/mystats";
my $DIR = "/broad/hptmp/matter/wgas_20090423";
my $DEBUG = 1;
my $DRYRUN = 0;
my $SLEEP = 4;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306;mysql_server_prepare=1";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql;

$sql = qq{SELECT dirid FROM subdir WHERE fsid=? AND name=?};
my $dq = $dbh->prepare($sql);

$sql = qq{SELECT MAX(dirid) FROM subdir WHERE fsid=?};
my $iq = $dbh->prepare($sql);

$sql  = "SELECT u.blocks, u.used, u.available ";
$sql .= "FROM fsusage u ";
$sql .= "WHERE fsid = ? ";
$sql .= "AND checked = ";
$sql .= "(SELECT MAX(checked) ";
$sql .= "FROM fsusage ";
$sql .= "WHERE fsid=? ";
$sql .= "AND checked < ";
$sql .= "(SELECT checked FROM fsstat ";
$sql .= "WHERE fsid=? AND dirid IS NULL AND uid IS NULL AND type=2 AND latest=1))";
my $tq = $dbh->prepare($sql) or die $sql;
print "$sql\n";

$sql  = "SELECT u.blocks, u.used, u.available, f.id, f.mount, SUBSTRING_INDEX(f.path, ':', 1) server ";
$sql .= "FROM filesystem f, fsusage u ";
$sql .= "WHERE f.deprecated IS FALSE ";
$sql .= "AND u.fsid = f.id ";
$sql .= "AND u.checked = (SELECT MAX(checked) FROM fsusage) ";
$sql .= "ORDER BY RAND() ";

print STDERR "$sql\n" if $DEBUG;

my $sth = $dbh->prepare($sql);
$sth->execute();
my $n=0;
while (my $ref = $sth->fetchrow_hashref()) {
  my $id = $ref->{'id'};
  unless ($id == 943 or $id == 944 or $id == 945 or $id == 946 or $id == 947 or $id == 948 or $id == 1377 or $id == 1662) {
    next;
  }
  my $mount = $ref->{'mount'};
  my $server = $ref->{'server'};
  my $res = "";
  my $queue;
  if (   $server =~ /bromine/ or $server =~ /hydrogen/ 
      or $server =~ /krypton/  or $server =~ /neon/ 
      or $server =~ /oxygen/  or $server =~ /radon/ 
      or $server =~ /xenon/ ) {
    $res = "-R \"rusage[${server}_io=7]\"";
  } else {
    $res = "";
    $res = "-R \"rusage[bromine_io=5]\"";
  }
  if ($mount =~ m,/seq/trace, or $mount =~ m,/seq/project,) {
#    $queue = "classic";
    $queue = "broad";
  } else {
    $queue = "broad";
  }
  ##
  ## Has this filesystem changed since last time we looked?
  ##
  $tq->execute($id,$id,$id) or die "tq";
  if ($tq->rows()) {
    print "checking $id\n";
    my $lref = $tq->fetchrow_hashref();
    print "$ref->{'blocks'}    == $lref->{'blocks'}\n";
    print "$ref->{'used'}      == $lref->{'used'}\n";
    print "$ref->{'available'} == $lref->{'available'}\n";
    if ($ref->{'blocks'}    == $lref->{'blocks'} and
        $ref->{'used'}      == $lref->{'used'}   and
        $ref->{'available'} == $lref->{'available'}) {
      print "$mount appears unchanged. Skipping.\n";
      next;
    }
  }
  $iq->execute($id) or die "id";
  my $maxid = ($iq->fetchrow())[0];
  unless (defined $maxid ) {	
    $sql = qq{INSERT INTO subdir(fsid,dirid,name) VALUES($id,0,'.')};
    print $sql,"\n" if $DEBUG;
    $dbh->do($sql);
    $maxid = 0;
  }
  mkdir "$DIR/${id}", 0755 or die "could not mkdir ${id}: $!";
  my $cmd = "$PRG -1 -o $DIR/${id}/${id}.0.csv \"$mount\"";
  $cmd = "bsub -q $queue -o $DIR/${id}/${id}.0.out $res " . $cmd;
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd\n` unless $DRYRUN;
  $cmd = "find $mount -maxdepth 1 -mindepth 1 -type d -not -name '.' -not -name '.snapshot'";
  open FIND, "$cmd |" or die "could not run find on $mount: $!";
  while (<FIND>) {
    my $sd;
    chomp;
    ($sd = $_) =~ s,^.*/,,;
    $dq->execute($id,$sd);    
    if ($dq->rows()) {
      $dirid = ($dq->fetchrow_array())[0];
    } else {
      $maxid++;
      $dirid = $maxid;
      $sql = qq{INSERT INTO subdir(fsid,dirid,name) VALUES ($id,$dirid,'$sd')};
      print $sql,"\n" if $DEBUG;
      $dbh->do($sql);
    }
    
#  next if $mount =~ /solexaproc/;
#  next if $mount =~ /wgas\d/;
  my $cmd = "$PRG -o $DIR/${id}/${id}.${dirid}.csv \"$mount/$sd\"";
  $cmd = "bsub -q $queue -o  $DIR/${id}/${id}.${dirid}.out $res " . $cmd;
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd\n` unless $DRYRUN;
  }
  sleep $SLEEP;
}

