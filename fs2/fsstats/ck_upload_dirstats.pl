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

my $STATDIR = "/sysman/scratch/matter/sandbox/fsstats/stats_20081119";
my $checked = (stat "$STATDIR/")[9];
$checked = 1227160896;

my $cmd = "find $STATDIR/ -mindepth 1 -maxdepth 1 -type d -not -name '.' -not -name '.snapshot'";
open FH, "$cmd |" or die "could not run find: $!";
my @fs;
while (<FH>) {
  chomp;
  push @fs, $_;
}
close FH;


my $fsid;
for my $dir (@fs) {
  ($fsid = $dir) =~ s,.*/,,;
  opendir DP, "$dir" or die "could not read $dir: $!";
  my @csv = grep /[0-9]\.csv/, readdir DP;
  closedir DP;

  my $atime = 0;
  my  $valcnt;
  for my $f (@csv) {
    my $dirid;
    if ($f eq "$fsid.csv") {
      $dirid = undef;
    } else {
      $f =~ m/(\d+)\.(\d+)\.csv/;
      die "something amiss: $1 != $fsid" unless $1 == $fsid;
      $dirid = $2;
    }
    my $uid = undef;
    my $hist = 0;
    my ($tid, $sumcnt, $sumval, $maxcnt, $maxval);
    my $blob = undef;
#  my $checked = (stat "$STATDIR/$f")[9];
#  print "Here: $checked\n";
#    print "Processing $f...\n";
    if (defined $dirid) {
      $sql = "SELECT checked FROM fsstat WHERE latest=1 AND fsid=$fsid AND dirid=$dirid and type=2 and uid is NULL";
    } else {
      $sql = "SELECT checked FROM fsstat WHERE latest=1 AND fsid=$fsid AND dirid is NULL and type=2 and uid is NULL";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute();
    my $t = ($sth->fetchrow_array())[0];
    ##
    ## Skip if it doesn't need to be updated
    ##
    next if defined $t and $t >= $checked;
#    do {
#      $t = defined $t ? $t : "null";
#      $d = defined $dirid ? $dirid : "null";
#      warn "would update: fsid=$fsid, dirid=$d, ($t < $checked)\n";
#    };
    
    open FP, "$dir/$f" or die "could not read $f: $!";
    if (defined $dirid) {
      $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$fsid AND dirid=$dirid AND latest=1";
    } else {
      $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$fsid AND latest=1 and dirid is NULL";
    }
    $dbh->do($sql);
    while (<FP>) {
      chomp;
      /histogram/ and do {
        die "missing type for $_" unless defined $type{$_};
        $tid = $type{$_};
        next;
      };
#      /count,(\d+),/ and do {
#        $maxval = $maxcnt = -1;
#        $sumval = $sumcnt = 0;
#        next;
#      };
      /^bucket/ and do {
        $hist = 1;
        $maxval = $maxcnt = -1;
        $sumval = $sumcnt = 0;
        next;
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
          if (defined $dirid) {
            $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram)";
            $sql .= " VALUES ($fsid,$dirid,$checked,1,$uid,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
          } else {
            $sql = "INSERT INTO fsstat (fsid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram)";
            $sql .= " VALUES ($fsid,$checked,1,$uid,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
          }
        } else {
          if (defined $dirid) {
            $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram)";
            $sql .= " VALUES ($fsid,$dirid,$checked,1,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
          } else {
            $sql = "INSERT INTO fsstat (fsid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram)";
            $sql .= " VALUES ($fsid,$checked,1,$tid,$sumcnt,$sumval,$maxcnt,$maxval,\"$blob\")";
          }
        }
        print "$sql\n";
        $dbh->do($sql);
        $hist = 0;
        $blob = undef;
      };
    }
    close FP;
  } 
}
