#!/util/bin/perl -w

use DBI;
use DBD::mysql;
use Getopt::Std;

use vars qw ($opt_v);

my $DRYRUN = 0;

##
## Process command-line options
##
getopts('v');
my $DEBUG = defined $opt_v ? 1 : 0;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "tyhjcZ30Y");

my ($sql, $sth, $nr);
my $cmd;

my ($del, $dlh);
my ($ins, $ish);
my ($upd, $ush);

##
## Ad hoc SELECT goes here
$sql = <<SQL;
SELECT s.uid,s.type,s.histogram 
  FROM fsstat s
    INNER JOIN filesystem f on s.fsid = f.id
  WHERE f.parent IS NULL
  AND f.deprecated IS FALSE
  AND s.latest IS TRUE
  AND s.dirid IS NULL
  AND s.uid IS NULL
  AND (f.path like 'yin%' or f.path like 'yang%' or f.path like 'zig%' or f.path like 'zag%')
  AND s.type=15
SQL

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
  ##
  ## Dump histogram
  ##
  print join ",", $type,$hist;
  print "\n";
 }
exit;
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
