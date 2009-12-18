<?php
require ('gChart2.php');
?>

<html>
<head>
  <title>Google chart API test: trend view</title>
</head>
<body bgcolor=888888>
<b>
<center>
<table>
<?php


include 'constants.php';
include 'config.php';
include 'opendb.php';

$gid = isset($_REQUEST['gid']) ? $_REQUEST['gid'] : 9;

$query = <<<SQL
SELECT checked, sum(used) used, sum(blocks-used) available
FROM fsusage u 
INNER JOIN filesystem f on f.id = u.fsid
WHERE f.parent IS NULL
AND f.id NOT IN (1384,1178,1131,1286,1270)
AND f.gid = $gid
GROUP BY checked
ORDER BY checked ASC
SQL;

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

$dt = 7*86400*4;	# one week
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

#$chart['series_color'] = array("416d80", "cca768");

$chart = new gStackedBarChart;
$chart->addDataSet($y1);
$chart->addDataSet($y2);
$chart->barWidth=5;
$chart->width=300;
$chart->groupSpacerWidth=1;
$chart->valueLabels = array("used","allocated");
$chart->dataColors = array("416d80","cca768");

$url = $chart->getUrl();
#$url = "$url?chm=b,416d80,0,1,0";
$url = "$url&chxt=y";
print "<tr><td>$url</td></tr>\n";
print "<tr><td><img src=$url></img></td>\n";


?>
</table>
</center>
</body>
<html>
