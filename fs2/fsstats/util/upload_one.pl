#!/util/bin/perl -w

use DBI;
use DBD::mysql;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my $sql = "SELECT * FROM stat_type";
my $sth = $dbh->prepare($sql);

$sth->execute();
while (my $ref = $sth->fetchrow_hashref()) {
  $type{$ref->{'name'}} = $ref->{'id'};
}

#my $STATDIR = "/sysman/scratch/matter/sandbox/fsstats/stats";

#opendir DP, "$STATDIR" or die "could not read $STATDIR: $!";
#my @csv = grep /[1-9]\.csv/, readdir DP;
#closedir DP;

my $atime = 0;
my (%cnt, $valcnt);
for my $f (@ARGV) {
  my $fsid;
  ($fsid = $f) =~ s/\.csv//;
  $fsid =~ s/.*\///;
  my $uid = undef;
  my $hist = 0;
  my ($tid, $sumcnt, $sumval, $maxcnt, $maxval);
  my $blob = undef;
  open FP, "$f" or die "could not read $f: $!";
  my $checked = (stat "$f")[9];
  print "Here: $checked\n";
  print "Processing $f...\n";
  $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$fsid AND latest=1";
  $dbh->do($sql);
  while (<FP>) {
    chomp;
    /histogram/ and do {
      die "missing type for $_" unless defined $type{$_};
      $tid = $type{$_};
      $maxval = $maxcnt = -1;
      $sumval = $sumcnt = 0;
      next;
    };
#    /count,(\d+),/ and do {
#      $cnt = $1;
#      $maxval = $maxcnt = -1;
#      $sumval = $sumcnt = 0;
#      next;
#    };
    /^bucket/ and do {
      $hist = 1;
    };
    /^\d/ and do {
      $blob = defined $blob ? $blob . ":$_" : $_;
      my @f = split /,/;
      $maxcnt = $f[2] > $maxcnt ? $f[2] : $maxcnt;
      $maxval = $f[3] > $maxval ? $f[3] : $maxval;
      $sumcnt += $f[2];
      $sumval += $f[3];
      next;
    };
    /stats for user (\d+)/ and do {
      $uid = $1;
      next;
    };
    /--------/ and do {
      $uid = undef;
      next;
    };
    /^$/ and do {
      next unless $hist;
      next unless $sumcnt;		# Skip if count==0;
      if (defined $uid) {
        $sql = "INSERT INTO fsstat (fsid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram)";
        $sql .= " VALUES ($fsid,$checked,1,$uid,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
      } else {
        $sql = "INSERT INTO fsstat (fsid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram)";
        $sql .= " VALUES ($fsid,$checked,1,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
      }
      print "$sql\n";
      $dbh->do($sql);
      $hist = 0;
      $blob = undef;
    };
  }
  close FP;
}
