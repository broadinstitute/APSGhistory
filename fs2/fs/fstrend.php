<?php


include 'constants.php';
include 'config.php';
include 'opendb.php';

$fsid = $_REQUEST['fsid'];
$gid = isset($_REQUEST['gid']) ? $_REQUEST['gid'] : 0;

if ($fsid > 0) {
  $query = <<<SQL
  SELECT f.mount, u.*
  FROM filesystem f, fsusage u
  WHERE f.id = u.fsid
  AND u.fsid = $fsid
  ORDER BY checked ASC
SQL;
} elseif ($fsid == -1) {
  $query = <<<SQL
  SELECT checked, sum(used) used, sum(available) available
  FROM fsusage u 
  INNER JOIN filesystem f on f.id = u.fsid
  WHERE f.parent IS NULL
  AND f.id NOT IN (1384,1178,1131,1286,1270)
  AND f.gid IN (2,5,9,10,12,19,21)
  GROUP BY checked
  ORDER BY checked ASC
SQL;
} elseif ($fsid == -2) {
  $query = <<<SQL
  SELECT checked, sum(used) used, sum(available) available
  FROM fsusage u 
  INNER JOIN filesystem f on f.id = u.fsid
  WHERE f.parent IS NULL
  AND f.id NOT IN (1384,1178,1131,1286,1270)
  AND f.gid NOT IN (2,5,9,10,12,19,21)
  GROUP BY checked
  ORDER BY checked ASC
SQL;
} elseif ($gid) {
  $query = <<<SQL
  SELECT checked, sum(used) used, sum(available) available
  FROM fsusage u 
  INNER JOIN filesystem f on f.id = u.fsid
  WHERE f.parent IS NULL
  AND f.gid = $gid
  GROUP BY checked
  ORDER BY checked ASC
SQL;
} else {
  $query = <<<SQL
  SELECT checked, sum(used) used, sum(available) available
  FROM fsusage u 
  INNER JOIN filesystem f on f.id = u.fsid
  WHERE f.parent IS NULL
  AND f.id NOT IN (1384,1178,1131,1286,1270)
  GROUP BY checked
  ORDER BY checked ASC
SQL;
}

$result = mysql_query($query);

include 'closedb.php';

$u = array();
$a = array();
#$c = array();
$t = array();

$max = 0;
while ($row = mysql_fetch_assoc($result)) {
#  $mnt = $row['mount'];
  $t1  = $row['checked'];
  $t[] = $row['checked'];
  $u[] = $row['used'];
  $a[] = $row['available'];
#  $c[] = $row['capacity'];
  $sum = $row['used'] + $row['available'];
  $max = $sum > $max ? $sum : $max;
}

##
## For rescaling
##
$e = (int)(log($max,1000));
$fact = pow(1000,$e);

$x  = array();
$y1 = array();
$y2 = array();
$y3 = array();

$dt = 7*86400;	# one week
$n = (int)(($t1 - $t[0])/$dt);
$t0 = $t1 - $n * $dt;
$j = 0;
$x[] = "";
$y1[] = "Used";
$y2[] = "Available";
$y3[] = "Capacity";
for ($i = 0; $i <= $n; $i++) {
  $tt = $t0 + $i * $dt;
  $x[] = strftime("%b %Y",$tt);
#  $x[] = $tt;
  while ($t[$j] < $tt) {
    $j++;
  }
  $m = ($tt - $t[$j-1])/($t[$j] - $t[$j-1]);
  $y1[] = ( ($u[$j] - $u[$j-1]) * $m + $u[$j-1] )/$fact;
  $y2[] = ( ($a[$j] - $a[$j-1]) * $m + $a[$j-1] )/$fact;
#  $y3[] = ($c[$j] - $c[$j-1]) * $m + $c[$j-1];
}

$skip = ($t1-$t0) > 31536000 ? 24 : 12;

include 'charts.php';
$chart['chart_data'] = array( $x, $y1, $y2);
$chart['chart_type'] = "stacked area";
$chart['axis_category'] = array('skip' => $skip);

$chart[ 'draw' ] = array( 
                         array( 
                               'type'=>"text", 
                               'color'=>"000000", 
#                               'alpha'=>50, 
#                               'bold'=>false, 
#                               'size'=>14, 
                               'x'=>20, 
                               'y'=>170, 
                               'rotation' => -90, 
                               'text'=>"total capacity ($unit[$e])",
#                               'h_align'=>"left", 
#                               'v_align'=>"top" 
                               ),
                         );
$chart['series_color'] = array("416d80", "cca768");
#$chart['series_color'] = array ( "cca768", "a67a55", "805e41", "68adcb", "558da6", "416d80", "cccccc", "333333");
#if ($fsid == 0) {
$chart[ 'link_data' ] = array(
                              'url' => "fslist.php",
                              'target' => "_blank"
                             );
#}
$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
SendChartData($chart);
#$chart['chart_data'] = array($x, $y1, $y2);
#$chart['chart_type'] = "area";
#$chart[ 'chart_rect' ] = array(
#                               'positive_color' => "ffffff",
#                               'positive_alpha' => 20,
#                               'negative_color' => "ff0000",
#                               'negative_alpha' => 10,
#                               'y'              => 10,
#                               'height'         => 200
#                              );
###
### Move legend offscreen
###
#$chart['legend_rect'] = array('x' => -10000, 'y' => -10000);
#
###
### Vertical gridlines
###
#$chart['chart_grid_v'] = array(
#                               'alpha'=>10,
#                               'color'=>"0066FF",
#                               'thickness'=>1
#                              );
#
#      
###
### Horizontal gridlines
###
#$chart['chart_grid_h'] = array(
#                               'alpha'     => 20,
#                               'color'     => "000000",
#                               'thickness' => 1,
#                               'type'      => "solid"
#                              );
#
###
### x-axis labels
###
#$chart['axis_category'] = array(
#                                'font'=>"arial", 
#                                'bold'=>true, 
#                                'size'=>9, 
#                                'color'=>"000000", 
#                                'alpha'=>50, 
#                                'skip'=>0 
#                               );
#
#
$chart[ 'draw' ] = array( 
                         array( 
                               'type'=>"text", 
                               'color'=>"000000", 
                               'alpha'=>50, 
                               'font'=>"arial", 
                               'bold'=>false, 
                               'size'=>14, 
                               'x'=>12, 
                               'y'=>23, 
                               'rotation'=>-90, 
                               'text'=>"Time of last access (days)", 
                               'h_align'=>"left", 
                               'v_align'=>"top" 
                               ),
                         );
#                         array( 
#                               'type'=>"text", 
#                               'color'=>"000033", 
#                               'alpha'=>50, 
#                               'font'=>"arial", 
#                               'rotation'=>-90, 
#                               'bold'=>true, 
#                               'size'=>14, 
#                               'x'=>-10, 
#                               'y'=>260, 
#                               'width'=>300, 
#                               'height'=>50, 
#                               'text'=>"Total usage (GB)", 
#                               'h_align'=>"center", 
#                               'v_align'=>"middle" 
#                              )
#                        );

#$chart[ 'series_color' ] = array ( "c89341", "c89341" );

#$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
#SendChartData ( $chart );

exit;
?>
