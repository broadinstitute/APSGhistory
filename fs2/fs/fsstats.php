<?php

##
## Load data
##
$fsid = $_REQUEST['fsid'];
if (isset($_REQUEST['dirid'])) {
  $dirid = $_REQUEST['dirid'];
  $dircond = "s.dirid = $dirid";
} else {
  $dircond = "s.dirid IS NULL";
}
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

if ($fsid >= 0) {
$query = <<<SQL
SELECT maxcnt,maxval,histogram,checked
FROM fsstat s
WHERE s.fsid = $fsid
AND s.type = $tid[$type]
AND $dircond
AND s.uid IS NULL
AND latest=1
SQL;
} elseif ($fsid == -1) {
$query = <<<SQL
SELECT maxcnt,maxval,histogram,checked
FROM fsstat s
INNER JOIN filesystem f
WHERE s.type = $tid[$type]
AND s.dirid IS NULL
AND s.uid IS NULL
AND latest=1
AND f.gid IN (2,5,9,10,12,19,21)
AND f.parent IS NULL
SQL;
} elseif ($fsid == -2) {
$query = <<<SQL
SELECT maxcnt,maxval,histogram,checked
FROM fsstat s
INNER JOIN filesystem f
WHERE s.type = $tid[$type]
AND s.dirid IS NULL
AND s.uid IS NULL
AND latest=1
AND f.gid NOT IN (2,5,9,10,12,19,21)
AND f.parent IS NULL
SQL;
}

#AND checked = (SELECT MAX(checked) FROM fsstat WHERE fsid = $fsid AND $dircond)

$dat = array();
$cat = array();
$cat[0] = "";
$dat[0] = "";
$nmax = 0;
$max = 0;
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
  if (preg_match("/time/", $type)) {
    $max = $max > $row['maxcnt'] ? $max : $row['maxcnt'];
  } else {
    $max = $max > $row['maxval'] ? $max : $row['maxval'];
  }
  $when = strftime("%B %e, %Y", $row['checked']);

  $lines = explode(":",$row['histogram']);
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
  }
}

##
## Rescale
##
$e = (int)(log($max,1000));
$fact = pow(1000,$e);
for ($i = 1; $i<=$nmax; $i++) {
  $dat[$i] = $dat[$i]/$fact;
  $cat[$i] = $lab[$i];
}

include 'charts.php';
$chart['chart_data'] = array($cat,$dat);
$chart['chart_type'] = '3d pie';
#$chart['chart_type'] = 'column';
$chart['chart_value'] = array(
                              'as_percentage'=>false,
                              'position' => 'cursor',
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
$chart['series_color'] = array ( "cca768", "a67a55", "805e41", "68adcb", "558da6", "416d80", "cccccc", "333333");
$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
SendChartData($chart);
exit;
?>
