<?php

##
## Load data
##
$fsid  = isset($_REQUEST['fsid'])  ? $_REQUEST['fsid']  : 0;
if (isset($_REQUEST['dirid'])) {
  $dirid = $_REQUEST['dirid'];
  $dircond = "s.dirid = $dirid";
} else {
  $dircond = "s.dirid IS NULL";
}

include 'constants.php';
include 'config.php';
include 'opendb.php';

$ind = $ind_s;
$lab = $lab_s;

$query = <<<SQL
SELECT s.uid,s.sumval,u.username,checked
FROM fsstat s
INNER JOIN users u on s.uid = u.uid
WHERE s.fsid = $fsid
AND $dircond
AND s.type = 2
AND s.latest = 1
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
    if ($row['username'] == NULL) {
      $cat[$n] = $row['uid'];
    } else {
      $cat[$n] = $row['username'];
    }
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
                              'as_percentage'=>true,
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
                             'color' => '444444',
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
