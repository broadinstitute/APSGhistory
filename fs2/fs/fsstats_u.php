<?php

##
## Load data
##
$uid  = $_REQUEST['uid'];
$type = $_REQUEST['type'];

include 'constants.php';
include 'config.php';
include 'opendb.php';

if (preg_match("/time/", $type)) {
  $ind = $ind_t;
  $lab = $lab_t;
} else {
  $ind = $ind_s;
  $lab = $lab_s;
}

$query = <<<SQL
SELECT sumcnt,sumval,histogram,checked
FROM fsstat s
WHERE s.fsid = 0
AND s.type = $tid[$type]
AND s.uid = $uid
AND latest = 1
SQL;

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
if (preg_match("/time/", $type)) {
  $max = $row['sumcnt'];
} else {
  $max = $row['sumval'];
}
#$mount = $row['mount'];

$when = strftime("%B %e, %Y", $row['checked']);

$lines = explode(":",$row['histogram']);
$dat = array();
$cat = array();
$cat[0] = "";
$dat[0] = "";
$nmax = 0;
foreach ($lines as $line) {
  list ($bot, $top, $cnt, $valcnt) = explode(",", $line);
  if (preg_match("/time/", $type)) {
    $top = $top > 1024 ? 1024 : $top;
    $val = $cnt;
  } else {
    $top = $top > 2147483648 ? 2147483648 : $top;
    $val = $valcnt;
  }
  $n = $ind[$top];
  $dat[$n] = isset($dat[$n]) ? $dat[$n] + $val : $val;
  $nmax = $n > $nmax ? $n : $nmax;
  $cat[$n] = $lab[$n];
#   $cat[$n] = "$bot - $top";
#   $dat[$n] = $cnt;
}

##
## Rescale
##
$e = (int)(log($max,1000));
$fact = pow(1000,$e);
for ($i = 1; $i<=$nmax; $i++) {
  $dat[$i] = $dat[$i]/$fact;
}

include 'charts.php';
$chart['chart_data'] = array($cat,$dat);
$chart['chart_type'] = '3d pie';
#$chart['chart_type'] = 'column';
$chart['chart_value'] = array(
                              'as_percentage'=>false,
                              'position' => 'inside',
                              'hide_zero'=>true
                             );
$chart['legend_rect'] = array(
                              'x' => 300,
                             );
$chart['chart_rect'] = array(
                              'x' => 30,
                             );
$chart['draw'] = array(
                       array(
                             'type' => "text",
                             'text' => "as of $when",
                             'size' => 12,
                             'color' => '222222',
                             'x'    => 120
                            ),
                       );
$chart['series_color'] = array ( "cca768", "a67a55", "805e41", "68adcb", "558da6", "416d80", "cccccc", "333333");
$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
SendChartData($chart);
exit;
?>
