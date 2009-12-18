#!/usr/bin/perl 

use Chart::Composite;
use DBI;
use DBD::mysql;
use GD;

##
## Initiate DB connection
##
my $dsn = "DBI:mysql:database=matter;host=mysql;port=3306";
my $dbh = DBI->connect($dsn, "matter", "spamLet1");

my $sql;
$sql  = 'SELECT f.mount, u.* ';
$sql .= 'FROM filesystem f, fsusage u ';
$sql .= 'WHERE f.id = u.fsid ';
$sql .= 'AND fsid = 943 ';
#$sql .= 'AND fsid = 1198 ';
$sql .= 'ORDER BY checked ASC';

my $sth = $dbh->prepare($sql);
my $nr  = $sth->execute();

my (@x,@y1,@y2,@y3);
my (@t,@u,@a,@c);
my $mnt;
my ($t0,$t1);
while (my $ref = $sth->fetchrow_hashref()) {
  $mnt = $ref->{'mount'};
#  push @x,scalar localtime $ref->{'checked'};
  $t0 = defined $t0 ? $t0 : $ref->{'checked'};
  $t1 = $ref->{'checked'};
  push @t,$ref->{'checked'};
  push @u, $ref->{'used'}/(1000*1000*1000);
  push @a, $ref->{'available'}/(1000*1000*1000);
  push @c ,$ref->{'capacity'};
}


my $dt = 7*86400; 	# one week
my $n = int(($t1 - $t0)/$dt);
$t0 = $t1 - $n * $dt;

my $j = 0;
for my $i (0..$n) {
  my $t = $t0 + $i*$dt;
  ($wkd,$mon,$day,$tim,$yr) = split /\s+/, localtime $t;
  $x[$i] = "$mon $yr";
  while ($t[$j] < $t) {
    ++$j;
  }
  $y1[$i] = (($u[$j] - $u[$j-1]) / ($t[$j] - $t[$j-1])) * ($t - $t[$j-1]) + $u[$j-1];
  $y2[$i] = (($a[$j] - $a[$j-1]) / ($t[$j] - $t[$j-1])) * ($t - $t[$j-1]) + $a[$j-1];
  $y3[$i] = (($c[$j] - $c[$j-1]) / ($t[$j] - $t[$j-1])) * ($t - $t[$j-1]) + $c[$j-1];
}

my $g = Chart::Composite->new(200,160);

$g->add_dataset(@x);
$g->add_dataset(@y1);
$g->add_dataset(@y2);
$g->add_dataset(@y3);

$g->set(
#'title' => $mnt,
        'composite_info' => [ ['Mountain', [1,2]], ['Lines',[3]] ],
#        'x_ticks' => 'vertical',
#        'xy_plot' => 'true',
        'skip_x_ticks' => $#x,
        'y_ticks1' => 5,
        'y1_ticks' => 5,
        'y_ticks2' => 5,
        'y2_ticks' => 5,
        'precision' => 0,
        'title_font' => gdGiantFont,
        'y_label' => "     TB",
        'y_label2' => "     %",
        'transparent' => 'true',
#        'grey_background' => 'false',
        'min_val1' => 0,
        'min_val2' => 0,
        'colors' => {
                     'dataset0' => [139,119,101],
                     'dataset1' => [50,205,50],
                     'dataset2' => [200,0,0],
                     'y_label2' => [200,0,0],
                     'y2_grid_lines' => [200,0,0]
                     },
        'brush_size' => 2,
        'legend' => 'none');

$g->png("wgas.png");

