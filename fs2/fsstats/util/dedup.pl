#!/util/bin/perl -w

use DBI;
use DBD::mysql;
use Getopt::Std;
use Storable qw{dclone};

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
$sql = qq{SELECT * FROM filesystem WHERE deprecated IS FALSE ORDER BY mount, id ASC};
$sth = $dbh->prepare($sql);
$nr  = $sth->execute();
unless (defined $nr and $nr > 0) {
  print STDERR "could not retreive filesystem data\n";
  exit 1;
}
my @cols = ('id','mount','path','parent','deprecated','gid','snapshot','tapebackup','diskbackup','type','contact','contact2','rescomp');
my (@row,@last,$mount);
$mount = " ";
while (my @row = $sth->fetchrow_array()) {
  if ($row[1] eq $mount) {
    printf STDERR "found duplicate for $mount\n" if $DEBUG;
    unless ($mount =~ /hptmp/) {
      $sql = "UPDATE filesystem SET deprecated=1 WHERE id=$last[0]";
      print STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
      my $clause = " ";
      for my $i (5..8) {
        $clause .= " , $cols[$i]=$last[$i]" if defined $last[$i];
      }
      $sql = "UPDATE filesystem SET deprecated=0 $clause WHERE id=$row[0]";
      print STDERR "$sql\n" if $DEBUG;
      $dbh->do($sql) unless $DRYRUN;
    }
  }
  $mount = $row[1];
  @last = @{dclone(\@row)};
}

