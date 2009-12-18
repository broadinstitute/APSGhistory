<?php


include 'constants.php';
include 'config.php';
include 'opendb.php';

$result = mysql_query("SELECT MAX(checked) FROM fsusage");
$row    = mysql_fetch_array($result);
$when   = $row[0];
$scan = isset($_REQUEST['scan_time']) ? 1 : 0;
if (isset($_REQUEST['gid'])) {
  if ($_REQUEST['gid'] >= 0) {
    $gclause =  "AND f.gid=$_REQUEST[gid]";
    $result = mysql_query("SELECT name FROM grp WHERE id=$_REQUEST[gid]");
    $row = mysql_fetch_array($result);
    $gtitle = "belonging to $row[0]"; 
  } else {
    $gid = -1 * $_REQUEST['gid'];
    $gclause =  "AND f.gid<> $gid";
    $result = mysql_query("SELECT name FROM grp WHERE id=$gid");
    $row = mysql_fetch_array($result);
    $gtitle = "not belonging to $row[0]"; 
  }
} else {
  $gclause = "";
  $gtitle = "";
}

if ($scan) {
$query = <<<SQL
SELECT u.fsid, u.checked, s.checked 'when', u.blocks, u.used, u.capacity, u.available,
f.path, f.mount, f.tapebackup, f.snapshot, f.diskbackup
FROM fsusage u 
INNER JOIN filesystem f on f.id = u.fsid
INNER JOIN fsstat s on u.fsid=s.fsid
WHERE u.checked = (SELECT MAX(checked) FROM fsusage)
AND f.parent IS NULL
AND f.deprecated IS FALSE
$gclause
AND s.type=2
AND s.dirid IS NULL
AND s.uid IS NULL
AND s.latest=1
ORDER BY u.blocks DESC
SQL;
} else {
$query = <<<SQL
SELECT u.fsid, u.checked, u.blocks, u.used, u.capacity, u.available,
f.path, f.mount, f.tapebackup, f.snapshot, f.diskbackup
FROM fsusage u 
INNER JOIN filesystem f on f.id = u.fsid
WHERE u.checked = (SELECT MAX(checked) FROM fsusage)
AND f.parent IS NULL
AND f.deprecated IS FALSE
$gclause
ORDER BY u.blocks DESC
SQL;
}

$result = mysql_query($query);

$when = strftime("%B %e, %Y", $when);

print<<<HTMLtop
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>All NFS file systems $gtitle</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="aabbcc">All NFS file systems $gtitle</font></h1>
<h3> <font color="666666"> as of $when</font> </h3>
</center>
HTMLtop;
print "<center><table border=1>\n";
print "<thead>\n";
print "<tr><th scope=\"col\">File system</th><th scope=\"col\">Size</th><th scope=\"col\">Used</th><th scope=\"col\">Available</th><th scope=\"col\">Capacity</th><th>Last Changed</th><th>Backed up?</th><th>Snapshotted?</th>";
if ($scan) {
  print "<th>Last scanned</th>\n";
}
print "</tr></thead>\n";

$max = 0;
while ($row = mysql_fetch_assoc($result)) {
  $e = (int)(log($row['blocks'],1000));
  $fact = pow(1000,$e);
  $fsid = $row['fsid'];
  $blks = $row['blocks']/$fact;
  $used = $row['used']/$fact;
  $avail = $row['available']/$fact;
  $cap = $row['capacity'];
  $uqry = "SELECT MIN(checked) FROM fsusage WHERE fsid=$fsid AND used=$row[used] AND blocks=$row[blocks]";
  $ures = mysql_query($uqry);
  $urow = mysql_fetch_array($ures);
  $then = $urow[0];
  $dt = floor(($row['checked'] - $then)/(7*86400));
  if ($dt==0) {
    $changed = "< 1 week ago";
  } else {
    $changed = "$dt weeks ago";
  }
  if ($scan) {
    $when = strftime("%B %e, %Y", $row['when']);
  }
  $mnt = "<a href=\"http://apsg.broadinstitute.org/fs/fsview.php?fsid=" . $row['fsid'] . "\">" . $row['mount']. "</a>";
  print "<tr><th scope=\"row\" align=\"left\">$mnt</th>";
  printf("<td>%.1f %s</td><td>%.1f %s</td><td>%.1f %s</td><td>%d%%</td>",
         $blks, $unit[$e], $used, $unit[$e], $avail, $unit[$e], $cap);
  printf("<th>%s</th><th>%s</th><th>%s</th>\n",
         $changed,
         $row['tapebackup'] ? "yes" : "no",
         $row['snapshot'] ? "yes" : "no");
  if ($scan) {
    printf("<th>%s</th>", $when);
  }
  printf("\n");
}
include 'closedb.php';

print<<<HTML
</table>
</center>
</body>
</html>
HTML;

exit;
?>
