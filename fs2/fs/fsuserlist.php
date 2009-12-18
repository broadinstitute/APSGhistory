<?php

##
## Load data
##
if (isset($_REQUEST['fsid'])) {
  $fsid = $_REQUEST['fsid'];
} else {
  $fsid = 0;
}

include 'constants.php';
include 'config.php';
include 'opendb.php';

$ind = $ind_s;
$lab = $lab_s;

if ($fsid == 0) {
  $mnt = "all file systems";
} else {
  $query = "SELECT mount,path FROM filesystem WHERE id=$fsid";
  $result = mysql_query($query);
  $row = mysql_fetch_assoc($result);
  $mnt = $row['mount'];
  $path = $row['path'];
}

$query = <<<SQL
SELECT DISTINCT s.uid,s.sumval,u.username,checked
FROM fsstat s
INNER JOIN users u on s.uid = u.uid
WHERE s.fsid = $fsid
AND s.type = 2
AND s.latest = 1
AND s.dirid is NULL
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
$ntop = 100;
$sum = 0;
while ($row = mysql_fetch_assoc($result)) {
  $n = $n + 1;
  if ($when == 0) {
    $when = strftime("%B %e, %Y", $row['checked']);
  }
  if ($n <= $ntop) {
    if ($row['username'] == NULL) {
      $cat[$n] = $row['uid'];
      $uid[$n] = 1;
    } else {
      $cat[$n] = $row['username'];
      $uid[$n] = 0;
    }
    $dat[$n] = $row['sumval'];
    $max = $dat[$n] > $max ? $dat[$n] : $max;
    $sum += $dat[$n];
  } else {
    $dat[$ntop] = $dat[$ntop] + $row['sumval'];
    $max = $dat[$ntop] > $max ? $dat[$ntop] : $max;
  }
}
if ($n < $ntop) {
  $ntop = $n;
  $title = "All $ntop users in $mnt";
} else {
  $cat[$ntop] = "others";
  $sum += $dat[$ntop];
  $title = "Top $ntop users in $mnt";
}


print<<<HTMLtop
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>Top $ntop user in $mnt</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="4455aa">$title</font> </h1>
</center>
HTMLtop;

print "<center><table>\n";
print "<thead>\n";
print "<tr><th scope=\"col\">Username</th><th scope=\"col\">Used</th><th scope=\"col\">Percentage</th></tr>\n";
print "</thead>\n";
for ($i = 1; $i<=$ntop; $i++) {
  $e = (int)(log($dat[$i],1000));
  $fact = pow(1000,$e);
  if ($i%2) {
    $cl = 'class="odd"';
  } else {
    $cl = '';
  }
  if ($cat[$i] == "others") {
    printf("<tr $cl><td>$cat[$i]</td><td>%.2f %s</td><td>%.2f%%</td></tr>\n",
    $dat[$i]/$fact, $unit[$e], $dat[$i]*100/$sum);
  } elseif ($uid[$i] == 1) {
    printf("<tr $cl><td><a href=\"fsuser.php?uid=$cat[$i]\">$cat[$i]</a></td><td>%.2f %s</td><td>%.2f%%</td></tr>\n",
    $dat[$i]/$fact, $unit[$e], $dat[$i]*100/$sum);
  } else {
    printf("<tr $cl><td><a href=\"fsuser.php?user=$cat[$i]\">$cat[$i]</a></td><td>%.2f %s</td><td>%.2f%%</td></tr>\n",
    $dat[$i]/$fact, $unit[$e], $dat[$i]*100/$sum);
  }
}

print<<<HTML
</table>
</center>
</body>
</html>
HTML;



exit;
?>
