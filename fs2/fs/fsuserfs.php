<?php

##
## Load data
##
$uid  = isset($_REQUEST['uid'])  ? $_REQUEST['uid']  : 0;
$fsid = isset($_REQUEST['fsid']) ? $_REQUEST['fsid'] : 0;

include 'constants.php';
include 'config.php';
include 'opendb.php';


$query = <<<SQL
SELECT f.mount,s.sumval,u.username,s.checked
FROM fsstat s
INNER JOIN users u on s.uid = u.uid
INNER JOIN filesystem f on f.id = s.fsid
WHERE s.uid = $uid
AND s.latest = 1
AND s.type = 2
AND s.dirid IS NULL
AND f.parent IS NULL
AND f.deprecated IS FALSE
AND s.sumval > 0
ORDER BY sumval DESC
SQL;

$result = mysql_query($query);

$dat = array();
$cat = array();
$cat[0] = "";
$dat[0] = "";
$n = 0;
$max = 0;
$when = 0;
while ($row = mysql_fetch_assoc($result)) {
  $n = $n + 1;
  if ($when == 0) {
    $when = strftime("%B %e, %Y", $row['checked']);
  }
  if ($n <= $ntop) {
    $cat[$n] = $row['mount'];
    $dat[$n] = $row['sumval'];
    $max = $dat[$n] > $max ? $dat[$n] : $max;
  } else {
    $dat[$ntop] = $dat[$ntop] + $row['sumval'];
    $max = $dat[$ntop] > $max ? $dat[$ntop] : $max;
  }
}

if ($n < $ntop) {
  $ntop = $n;
} else {
  $cat[$ntop] = "others";
}

##
## Rescale
##
$e = (int)(log($max,1000));
$fact = pow(1000,$e);
for ($i = 1; $i<=$ntop; $i++) {
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
                              'x' => 275,
                             );
$chart['chart_rect'] = array(
                              'x' => 10,
                             );
$chart['draw'] = array(
                       array(
                             'type' => "text",
                             'text' => "usage in $unit[$e]",
                             'size' => 12,
                             'color' => '222222',
                             'x'    => 120
                            ),
                       );
#$chart['draw'] = array(
#                       array(
#                             'type' => "text",
#                             'text' => "$mount -- $type",
#                             'size' => 20,
#                             'x'    => 120
#                            ),
#                       );
$chart['series_color'] = array ( "cca768", "a67a55", "805e41", "68adcb", "558da6", "416d80", "cccccc", "333333");
$chart[ 'link_data' ] = array(
                              'url' => "fsuserlist.php?fsid=$fsid",
                              'target' => "_blank"
                             );
$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
SendChartData($chart);
exit;
?>
