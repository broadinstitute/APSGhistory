#!/util/bin/perl -w

use DBI;
use DBD::mysql;
use Getopt::Long;


my $PRG = "/util/bin/perl /sysman/scratch/matter/sandbox/fsstats/mystats";
my $TMP = "/broad/hptmp/matter";
my $DRYRUN = 0;
my $SLEEP = 0;
my $MAX_SIZE = 1E9;

##
## Process command-line options
##
my ($opt_f,$opt_d,$opt_t,$opt_v,$opt_q);
$opt_f = $opt_d = $opt_t = $opt_v = $opt_q = undef;
my $force = '';
GetOptions(
           "f=s" => \$opt_f,
           "d=i" => \$opt_d,
           "t=i" => \$opt_t,
           "v" => \$DEBUG,
           "q=s" => \$opt_q,
           "force-update" =>\$force
          );
unless (defined $opt_f) {
  warn "usage: $0: -f {filesystem|fsid} <-t timestamp> <-d dirid>";
  exit 1;
}

unless (defined $opt_t) {
  my $t = time();
  # round to nearest GMT midnight 
  $opt_t = int($t/86400+0.5) * 86400;
}

my ($fsid,$dirid);

$dirid = $opt_d if defined $opt_d;

##
## Initiate DB connection
##
my ($dsn,$dbh);
$dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
$dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my ($sql, $sth, $nr);

##
## Look up file system
##
if ($opt_f =~ m,^/,) {
  $sql = qq{SELECT id,mount FROM filesystem WHERE mount='$opt_f' AND deprecated IS FALSE};
} else {
  $sql = qq{SELECT id,mount FROM filesystem WHERE id=$opt_f AND deprecated IS FALSE};
}
print STDERR "$sql\n" if $DEBUG;
$sth = $dbh->prepare($sql) or print $dbh->err;
$nr  = $sth->execute();
if ($nr > 0) {
  ($fsid,$mount)  = $sth->fetchrow_array();
  print "Scanning $mount (fsid $fsid)\n";
} else {
  die "No mount found for $opt_f";
}

##
## Has file system changed recently?
##
$sql  = <<SQL;
SELECT u.blocks, u.used, u.available, f.id, f.mount, 
SUBSTRING_INDEX(f.path, ':', 1) server
  FROM fsusage u INNER JOIN filesystem f ON u.fsid=f.id
  WHERE u.fsid=?
  AND u.checked = (SELECT MAX(checked) FROM fsusage)
SQL

print STDERR "$sql\n" if $DEBUG;
$sth = $dbh->prepare($sql);
$nr  = $sth->execute($fsid);
my ($server,$blks,$used,$avail);
if ($nr > 0) {
  my $ref = $sth->fetchrow_hashref();
  $server = $ref->{'server'};
  $blks   = $ref->{'blocks'};
  $used   = $ref->{'used'};
  $avail  = $ref->{'available'};
} else {
  die "could not retreive file system entry";
}
  
$sql = <<SQL;
SELECT u.blocks, u.used, u.available
  FROM fsusage u 
  WHERE fsid = ? 
  AND checked =
    (SELECT MAX(checked)
       FROM fsusage 
       WHERE fsid=?
       AND checked < 
         (SELECT MAX(checked)
            FROM fsstat
            WHERE fsid=? 
            AND dirid IS NULL 
            AND uid IS NULL 
            AND type=2 
            AND latest=1
         )
    )
SQL
$sth = $dbh->prepare($sql) or die $sql;
$nr  = $sth->execute($fsid,$fsid,$fsid);
if ($nr > 0) {
  my $ref = $sth->fetchrow_hashref();
  if ($blks  == $ref->{'blocks'} and
      $used  == $ref->{'used'}   and
      $avail == $ref->{'available'}) {
        print STDERR "$mount appears unchanged. ";
        if ($force) {
          print STDERR "Update forced.\n\n";
        } else {
          print STDERR "Skipping. (Use --force-update to override.)\n";
          exit;
        }
  }
} else {
  warn "could not retrieve historical info for $fsid";
}

##
## Find directory entry if necessary
##
my $dirclause;
my $level;
if (defined $opt_d) {
  $dirclause = "AND parent=$dirid";
  $sql = qq{SELECT name,level,parent FROM subdir WHERE fsid=$fsid AND dirid=$dirid AND deprecated IS FALSE};
  print STDERR "$sql\n" if $DEBUG;
  $sth = $dbh->prepare($sql);
  $nr = $sth->execute();
  if ($nr > 0) {
    ($dir,$level,$parent) = $sth->fetchrow_array();
    my @d;
    while ($level > 0) {
      push @d, $dir;
      $sql = qq{SELECT name,level,parent FROM subdir WHERE fsid=$fsid AND dirid=$parent AND deprecated IS FALSE};
      print STDERR "$sql\n" if $DEBUG;
      $sth = $dbh->prepare($sql);
      $nr = $sth->execute();
      die "recursion problem" unless $nr > 0;
      ($dir,$level,$parent) = $sth->fetchrow_array();
    }
    if ($#d >=0 ) {
      $dir = join "/",$mount, reverse @d, $dir;
    } else {
      $dir = "$mount/" . $dir;
    }
    unless (-d $dir) {
      die "Cannot find $dir";
    }
  } else {
    die "No directory entry for $dirid=$opt_d fsid=$fsid";
  }
} else {
  $dirclause = "AND parent IS NULL";
  $dir = $mount;
  $level = 0;
}

##
## Find all subdirectories in DB
##
$sql = qq{SELECT dirid,name FROM subdir WHERE fsid=$fsid AND dirid > 0 AND deprecated IS FALSE $dirclause};
$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
my %dbdir;
my %olddir;
if ($nr > 0) {
  while (my @row = $sth->fetchrow_array()) {
    $dbdir{$row[1]}  = $row[0]; 	# Key = name
    $olddir{$row[0]} = $row[1];		# Key = dirid
  }
} else {
  warn "no subdirectories in DB for fsid=$fsid";
}

##
## Find all top-level directories in directory specified
##
$cmd = "find $dir -noleaf -maxdepth 1 -mindepth 1 -type d -not -name '.' -not -name '.snapshot'";
print STDERR "$cmd\n" if $DEBUG;
open FIND, "$cmd |" or die "could not run find on $mount: $!";
my (@newdir, @olddir);
while (<FIND>) {
  chomp;
  s/^($dir\/)//;
  if (defined $dbdir{$_}) {
    delete $olddir{$dbdir{$_}};
  } else {
    push @newdir, $_;
  }
}
##
## Mark deprecated directories in DB and delete from to-scan list
##
for my $d (keys %olddir) {
  delete $dbdir{$olddir{$d}};
  $sql = qq{UPDATE subdir SET deprecated=1 WHERE fsid=$fsid AND dirid=$d};
  print "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  ##
  ## If parent is gone, children should be too
  ##
  $sql = qq{SELECT dirid FROM subdir WHERE fsid=$fsid AND parent=$d};
  print "$sql\n" if $DEBUG;
  $sth = $dbh->prepare($sql);
  $nr  = $sth->execute();
  while (defined $nr and $nr > 0) {
    my @child;
    while (my @row = $sth->fetchrow_array()) {
      my $c = $row[0];
      push @child, $c;
      $sql = qq{UPDATE subdir SET deprecated=1 WHERE fsid=$fsid AND dirid=$c};
      print "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      # Look for grandchildren
      my $in = join ",",@child;
      $sql = qq{SELECT dirid FROM subdir WHERE fsid=$fsid AND parent in ($in)};
      print "$sql\n" if $DEBUG;
      $sth = $dbh->prepare($sql);
      $nr  = $sth->execute();
      @child = ();
    }
  }

  $sql = qq{UPDATE subdir SET deprecated=1 WHERE fsid=$fsid AND parent=$d};
  print "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
}
##
## Insert any new directories into DB and add to to-scan list
##
my $maxdirid;
if ($#newdir>=0) {
  $sql = qq{SELECT MAX(dirid) FROM subdir WHERE fsid=$fsid};
  $sth = $dbh->prepare($sql);
  $nr  = $sth->execute();
  if ($nr > 0) {
    $maxdirid = ($sth->fetchrow_array())[0];
  } else {
    die "something amiss reading subdir table";
  }
}
for my $d (@newdir) {
  $maxdirid++;
  my $newlev = $level + 1;
  if (defined $opt_d) {
    $sql = qq{INSERT INTO subdir(fsid,dirid,parent,level,name,deprecated) VALUES ($fsid,$maxdirid,$opt_d,$newlev,} . $dbh->quote($d) . qq{,0)};
  } else {
    $sql = qq{INSERT INTO subdir(fsid,dirid,name,deprecated) VALUES ($fsid,$maxdirid,} . $dbh->quote($d). qq{,0)};
  }
  print "$sql\n" if $DEBUG;
  $dbh->do($sql) unless $DRYRUN;
  $dbdir{$d} = $maxdirid;
}
##
## Now %dbdir contains all directories to be scanned, and all entries
## in subdir table are up-to-date.
##
## If any of these directories have been subscanned before, I guess we
## have to do so again.
##
## If any of these directories were larger than, say, 1TB last time
## we looked, those should get subscanned as well.
##
my $queue = defined $opt_q ? $opt_q : "broad";
my $cmd;
my $job;
my $extdep;
for my $d (keys %dbdir) {
  $dirid = $dbdir{$d};
  $sql = qq{SELECT dirid FROM subdir WHERE fsid=$fsid AND parent=$dirid AND deprecated IS FALSE};
  print STDERR "$sql\n" if $DEBUG;
  $sth = $dbh->prepare($sql);
  $nr  = $sth->execute();
  if ($nr > 0) {
    ##
    ## Yes, we have been subscanned before. Submit me.
    ##
    $job = "scanfs_${fsid}_${dirid}";
    $cmd = "$0 -t $opt_t -f $opt_f -d $dirid";
    $cmd .= " -v" if $DEBUG;
    $cmd .= " --force-update" if $force;
#    $cmd = "bsub -q $queue -J $job -o /dev/null $cmd";
    print STDERR "$cmd\n" if $DEBUG;
    print `$cmd\n` unless $DRYRUN;
    delete $dbdir{$d};
    next; 
  }
  $sql = qq{SELECT sumval FROM fsstat WHERE fsid=$fsid AND dirid=$dirid AND type=2 AND uid IS NULL AND latest=1};
  print STDERR "$sql\n" if $DEBUG;
  $sth = $dbh->prepare($sql);
  $nr  = $sth->execute();
  if ($nr > 0) {
    my $s = ($sth->fetchrow_array()) [0];
    if ($s >= $MAX_SIZE) {
      print STDERR "Directory $d was $s KB when last we checked. Scanning.\n";
      $job = "scanfs_${fsid}_${dirid}";
      $cmd = "$0 -t $opt_t -f $opt_f -d $dirid";
      $cmd .= " -v" if $DEBUG;
      $cmd .= " --force-update" if $force;
#      $cmd = "bsub -r -q $queue -J $job -o /dev/null $cmd";
      print STDERR "$cmd\n" if $DEBUG;
      print `$cmd\n` unless $DRYRUN;
      $extdep = "done(\"scanfs_${fsid}_*\")";
      delete $dbdir{$d};
      next; 
    }
  } else {
    warn "unable to retreive historical size data for directory $d" if $DEBUG;
  }
}

my $res = "";
if (   $server =~ /bromine/ or $server =~ /hydrogen/ 
    or $server =~ /krypton/  or $server =~ /neon/ 
    or $server =~ /oxygen/  or $server =~ /radon/ 
    or $server =~ /xenon/ ) {
    $res = "-R \"rusage[${server}_io=7]\"";
} else {
  $res = "";
}

unless (-d "$TMP/$opt_t") {
  mkdir "$TMP/$opt_t", 0755 or die "could not mkdir $TMP/$opt_t: $!";
}
unless (-d "$TMP/$opt_t/${fsid}") {
  mkdir "$TMP/$opt_t/${fsid}", 0755 or die "could not mkdir $TMP/$opt_t/${fsid}: $!";
}
my $DIR = "$TMP/$opt_t/${fsid}";

my $dep;
##
## Submit scan of top-level contents
##
$job = defined $opt_d ? "scan_${fsid}_${opt_d}_0" :
                        "scan_${fsid}_0";
$cmd = "$PRG -1 -o $DIR/0.csv \"$dir\"";
$cmd = "bsub -r -q $queue -o $DIR/0.out -J $job $res " . $cmd;
print STDERR "$cmd\n" if $DEBUG;
print `$cmd\n` unless $DRYRUN;
for my $d (keys %dbdir) {
  $dirid = $dbdir{$d};
  $job = defined $opt_d ? "scan_${fsid}_${opt_d}_${dirid}" :
                          "scan_${fsid}_${dirid}";
  $cmd = "$PRG -o $DIR/${dirid}.csv \"$dir/$d\"";
  $cmd = "bsub -r -q $queue -J $job -o  $DIR/${dirid}.out $res " . $cmd;
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd\n` unless $DRYRUN;
  sleep $SLEEP;
}

##
## If we're not top-level, we're done
##
exit 0 if defined $opt_d;

if (defined $opt_d) {
  $job = "upload_${fsid}_${opt_d}";
  $dep = "done(\"scan_${fsid}_${opt_d}_*\")";
} else {
  $job = "upload_${fsid}";
  $dep = "done(\"scan_${fsid}_*\")";
}
$cmd = "/home/radon01/matter/sandbox/fsstats/upload_stats.pl -d $DIR -t $opt_t";
$cmd .= " -v" if $DEBUG;
$cmd = "bsub -r -q $queue -w '$dep' -J $job -o $DIR/upload.out " . $cmd;
print STDERR "$cmd\n" if $DEBUG;
print `$cmd\n` unless $DRYRUN;
##
## Submit rollup only if we're top-level
##
$dep = "done(\"$job\")";
if (defined $opt_d) {
  $job = "combine_${fsid}_${opt_d}";
} else {
  $job = "combine_${fsid}";
}
$cmd = "/home/radon01/matter/sandbox/fsstats/combine.pl -f $fsid";
$cmd .= " -v" if $DEBUG;
$cmd = "bsub -r -q $queue -w '$dep' -J $job -o $DIR/combine.out " . $cmd;
print STDERR "$cmd\n" if $DEBUG;
print `$cmd\n` unless $DRYRUN;

