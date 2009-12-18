<?php

##
## Load data
##
$fsid = $_REQUEST['fsid'];
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
SELECT maxcnt,maxval,histogram,checked
FROM fsstat s
WHERE s.fsid = 0
AND s.type = 1
AND s.uid IS NULL
AND checked = (SELECT MAX(checked) FROM fsstat WHERE fsid = 0)
SQL;

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
if (preg_match("/time/", $type)) {
  $max = $row['maxcnt'];
} else {
  $max = $row['maxval'];
}
#$mount = $row['mount'];

print<<<HTML
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>All NFS file systems</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="aabbcc">All NFS file systems</font></h1>
<h3> <font color="666666"> as of $when</font> </h3>
</center>
HTML;

$when = strftime("%B %e, %Y", $row['checked']);

$lines = explode(":",$row['histogram']);
$dat = array();
$cat = array();
$cat[] = "";
$dat[] = "Last access (KB)";
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
print "$n, $dat[$n], $cat[$n], $top<p>\n";
#   $cat[$n] = "$bot - $top";
#   $dat[$n] = $cnt;
}

print<<<HTML_end
</center>
</body>
</html>
HTML_end;

?>
