#!/usr/bin/env perl

##
##  combine.pl: For a given fsid, roll up all subdirectory stats into
##  higher-level directories and finally into the filesystem level.
##

use DBI;
use DBD::mysql;
use Getopt::Long;

require 'dbconnect.pl';

my $DRYRUN = 0;

##
## Process command-line options
##
my ($opt_f, $opt_d, $opt_v);
my $norollup = '';
my $DEBUG;
GetOptions(
           "f=s" => \$opt_f,
           "d=i" => \$opt_d,
           "v" => \$DEBUG,
           "norollup" =>\$norollup
          );
unless (defined $opt_f) {
  warn "usage: $0: -f fsid <-d dirid>";
  exit 1;
}

##
## Initiate DB connection
##
my $dbh = DBI->connect($dsn, $dbuser, $dbpw);

my ($sql, $sth, $nr);
my $cmd;
##
## See if we have rollup to do
##
unless (defined $opt_d or $opt_f == 0 or $norollup) {
  $sql = qq{SELECT DISTINCT(parent) FROM subdir WHERE fsid=$opt_f AND parent IS NOT NULL AND deprecated IS FALSE};
  $sql = qq{SELECT MAX(level) FROM subdir WHERE fsid=$opt_f AND deprecated IS FALSE};
  print STDERR "$sql\n" if $DEBUG;
  $sth = $dbh->prepare($sql);
  $nr  = $sth->execute();
  unless (defined $nr and $nr > 0) {
    warn "No rows returned. Something amiss.\n";
    exit 1;
  }
  my $level = ($sth->fetchrow_array())[0];
  while ($level > 0) {
    $sql = qq{SELECT DISTINCT(parent) FROM subdir WHERE fsid=$opt_f AND deprecated IS FALSE and level=$level};
    print STDERR "$sql\n" if $DEBUG;
    $sth = $dbh->prepare($sql);
    $nr  = $sth->execute();
    while (my @row = $sth->fetchrow_array()) {
      my $dirid = $row[0];
      $cmd = "$0 -f $opt_f -d $dirid";
      $cmd .= " -v" if $DEBUG;
      print STDERR "$cmd\n" if $DEBUG;
      print `$cmd` unless $DRYRUN;
    }
    $level--;
  }
}

my ($del, $dlh);
my ($ins, $ish);
my ($upd, $ush);

##
## Verify that there is data to work with. There should always be at
## least '.' (dirid 0). Is this necessary/useful?
##
my $dclause = defined $opt_d ? "d.parent=$opt_d" : "d.parent IS NULL";
if ($opt_f > 0) {
$sql = <<SQL;
SELECT MAX(checked) 
  FROM fsstat f 
  INNER JOIN subdir d ON f.fsid=d.fsid AND f.dirid=d.dirid
    WHERE f.fsid=$opt_f 
    AND f.latest=1 
    AND f.type=2 
    AND f.uid IS NULL  
    AND $dclause
SQL
} else {
$sql = <<SQL;
SELECT MAX(checked) 
  FROM fsstat f 
    WHERE f.dirid IS NULL
    AND f.latest=1 
    AND f.type=2 
    AND f.uid IS NULL  
SQL
}
print STDERR "$sql\n" if $DEBUG;
$sth = $dbh->prepare($sql);
$nr = $sth->execute();
unless ($nr > 0) {
  warn "unable to query DB.\n";
  exit 1;
}
my $t = ($sth->fetchrow_array())[0];
unless (defined $t) {
  warn "found no data to combine.\n";
  exit 1;
}
##
## Off we go
##
if ($opt_f == 0) {		# Global rollup
  $sql = "SELECT s.uid, s.type, s.histogram FROM fsstat s INNER JOIN filesystem f ON s.fsid=f.id WHERE f.parent IS NULL AND f.deprecated IS FALSE AND s.latest IS TRUE AND s.dirid IS NULL AND s.fsid>0 AND s.fsid <> 2003";
} elsif (defined($opt_d)) {	# Directory rollup
  $sql = "SELECT s.uid, s.type, s.histogram FROM fsstat s INNER JOIN subdir d ON s.dirid=d.dirid AND s.fsid=d.fsid WHERE s.fsid=$opt_f AND d.parent=$opt_d AND d.deprecated IS FALSE AND s.latest IS TRUE";
}  else {			# Filesystem rollup
  $sql = "SELECT s.uid, s.type, s.histogram, s.dirid FROM fsstat s INNER JOIN subdir d ON s.dirid=d.dirid AND s.fsid=d.fsid WHERE s.fsid=$opt_f AND d.parent IS NULL AND d.deprecated IS FALSE AND s.latest IS TRUE";
}

print STDERR "$sql\n" if $DEBUG;

$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
unless (defined ($nr) and $nr > 0) {
  warn "no data returned ($sql)";
  exit 1;
}
my %cdata = ();
my %csum  = ();
my %cmax  = ();
my %vdata = ();
my %vsum  = ();
my %vmax  = ();
while (my $row = $sth->fetchrow_hashref()) {
  my $uid  = defined $row->{'uid'} ? $row->{'uid'} : 'all';
  my $type = $row->{'type'};
  my @l = split /:/, $row->{'histogram'};
  for my $line (@l) {
    my ($bot, $top, $cnt, $valcnt);
    ($bot, $top, $cnt, $valcnt) = split /,/, $line;
    ##
    ## Count data
    ##
    $cdata{$uid}{$type}{$bot} += $cnt;
    $csum{$uid}{$type}        += $cnt;
    unless (defined $cmax{$uid}{$type}) {
      $cmax{$uid}{$type} = 0;
    }
    $cmax{$uid}{$type} = $cnt > $cmax{$uid}{$type} ? $cnt : $cmax{$uid}{$type};
    ##
    ## Value data
    ##
    $vdata{$uid}{$type}{$bot} += $valcnt;
    $vsum{$uid}{$type}        += $valcnt;
    unless (defined $vmax{$uid}{$type}) {
      $vmax{$uid}{$type} = 0;
    }
    $vmax{$uid}{$type} = $valcnt > $vmax{$uid}{$type} 
                       ? $valcnt : $vmax{$uid}{$type};
  }
}

##
## First, rollup for all users
##
for my $type (keys %{$csum{'all'}}) {
  my $hist = "";
  for my $k (sort {$a<=>$b} keys %{$cdata{'all'}{$type}}) {
    my $top = $k > 0 ? $k * 2 : 2;
    my $line =  sprintf  "%d,%d,%d,%.0f", 
                $k, $top, $cdata{'all'}{$type}{$k}, $vdata{'all'}{$type}{$k};
    if (length($hist)) {
      $hist .= ":$line";
    } else {
      $hist = "$line";
    }
  }
  if (defined $opt_d) {
    ##
    ## Mark previous entries as "old"
    ##
    $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$opt_f AND dirid=$opt_d AND type=$type AND checked < $t";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
    ##
    ##  Delete old rollups, if any
    ##
    $sql = "DELETE FROM fsstat WHERE fsid=$opt_f AND dirid=$opt_d AND uid IS NULL AND type=$type AND checked = $t";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
    ##
    ## Insert new data
    ##
    $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram) VALUES ($opt_f, $opt_d, $t, 1, $type, $csum{'all'}{$type}, $vsum{'all'}{$type}, $cmax{'all'}{$type}, $vmax{'all'}{$type}, '$hist')";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
  } else {
    ##
    ## Move previous entries to history table
    ##
    $sql = "INSERT INTO fsstat_history SELECT * FROM fsstat WHERE fsid=$opt_f AND dirid IS NULL AND type=$type AND checked < $t";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
    ##
    ##  Delete previous entries, including old rollups, if any
    ##
    $sql = "DELETE FROM fsstat WHERE fsid=$opt_f AND dirid IS NULL AND type=$type AND checked <= $t";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
    ##
    ## Insert new data
    ##
    $sql = "INSERT INTO fsstat (fsid,checked,latest,type,sumcnt,sumval,maxcnt,maxval,histogram) VALUES ($opt_f, $t, 1, $type, $csum{'all'}{$type}, $vsum{'all'}{$type}, $cmax{'all'}{$type}, $vmax{'all'}{$type}, '$hist')";
    printf STDERR "$sql\n" if $DEBUG;
    $dbh->do($sql) unless $DRYRUN;
  }
}
##
## Now do per-user stats
##
for my $uid (keys %csum) {
  next if $uid eq 'all';
  for my $type (keys %{$csum{$uid}}) {
    my $hist = "";
      for my $k (sort {$a<=>$b} keys %{$cdata{$uid}{$type}}) {
      my $top = $k > 0 ? $k * 2 : 2;
      my $line =  sprintf  "%d,%d,%d,%.0f", 
                  $k, $top, $cdata{$uid}{$type}{$k}, $vdata{$uid}{$type}{$k};
      if (length($hist)) {
        $hist .= ":$line";
      } else {
        $hist = "$line";
      }
    }
    if (defined $opt_d) {
      ##
      ## Mark previous entries as "old"
      ##
      $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$opt_f AND dirid=$opt_d  AND uid=$uid AND type=$type AND checked < $t";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      ##
      ## Just in case, to avoid duplicate entires
      ##
      $sql = "DELETE FROM fsstat WHERE fsid=$opt_f AND dirid=$opt_d AND uid=$uid AND type=$type AND checked = $t";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      ##
      ## And finally
      ##
      $sql = "INSERT INTO fsstat (fsid,dirid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram) VALUES ($opt_f, $opt_d, $t, 1, $uid, $type, $csum{$uid}{$type}, $vsum{$uid}{$type}, $cmax{$uid}{$type}, $vmax{$uid}{$type}, '$hist')";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
    } else {
      ##
      ## Mark previous entries as "old"
      ##
      $sql = "UPDATE fsstat SET latest=0 WHERE fsid=$opt_f AND dirid IS NULL AND uid=$uid AND type=$type AND checked < $t";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      ##
      ## Just in case, to avoid duplicate entires
      ##
      $sql = "DELETE FROM fsstat WHERE fsid=$opt_f AND dirid IS NULL AND uid=$uid AND type=$type AND checked = $t";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      ##
      ## And finally
      ##
      $sql = "INSERT INTO fsstat (fsid,checked,latest,uid,type,sumcnt,sumval,maxcnt,maxval,histogram) VALUES ($opt_f, $t, 1, $uid, $type, $csum{$uid}{$type}, $vsum{$uid}{$type}, $cmax{$uid}{$type}, $vmax{$uid}{$type}, '$hist')";
      printf STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
    }
  }
}

##
## Update lock status
##
exit if $opt_f == 0 or defined $opt_d;
$sql = qq{SELECT MAX(id) FROM fslock WHERE fsid=$opt_f AND END IS NULL};
printf STDERR "$sql\n" if $DEBUG;
$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
my $id = ($sth->fetchrow_array())[0];
unless (defined $id) {
  warn "no lock found for $opt_f";
  exit;
}
my $now = time();
$sql = qq{UPDATE fslock SET end=$now WHERE id=$id};
printf STDERR "$sql\n" if $DEBUG;
$dbh->do($sql) unless $DRYRUN;
