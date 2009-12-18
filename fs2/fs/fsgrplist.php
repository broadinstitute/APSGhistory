<?php


include 'constants.php';
include 'config.php';
include 'opendb.php';

$result = mysql_query("SELECT MAX(checked) FROM fsusage");
$row    = mysql_fetch_array($result);
$when   = $row[0];


$query = <<<SQL
select g.name,sum(u.blocks) 'blocks',sum(u.used) 'used',
sum(u.available) 'available' ,count(distinct(u.fsid)) 'count'
from fsusage u
inner join filesystem f on f.id=u.fsid
inner join grp g on g.id=f.gid
where f.parent is null
and u.checked = $when
group by f.gid
SQL;

$result = mysql_query($query);

include 'closedb.php';
$when = strftime("%B %e, %Y", $when);

print<<<HTMLtop
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>NFS utlization by group</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="aabbcc">All NFS file systems</font></h1>
<h3> <font color="666666"> as of $when</font> </h3>
</center>
HTMLtop;
print "<center><table border=1>\n";
print "<thead>\n";
print "<tr><th scope=\"col\">Group</th><th scope=\"col\">Allocated</th><th scope=\"col\">Used</th><th scope=\"col\">Available</th><th scope=\"col\"># of file systems</th></tr>\n";
print "</thead>\n";

$max = 0;
while ($row = mysql_fetch_assoc($result)) {
  $e = (int)(log($row['blocks'],1000));
  $fact = pow(1000,$e);
  $blks = $row['blocks']/$fact;
  $used = $row['used']/$fact;
  $avail = $row['available']/$fact;
  $name = $row['name'];
#  $mnt = "<a href=\"http://apsg.broadinstitute.org/fs/fsview.php?fsid=" . $row['fsid'] . "\">" . $row['mount']. "</a>";
  print "<tr><th scope=\"row\" align=\"left\">$name</th>";
  printf("<td align=right>%.1f %s</td><td align=right>%.1f %s</td><td align=right>%.1f %s</td><td align=center>%d</td></tr>\n",
         $blks, $unit[$e], $used, $unit[$e], 
         $avail, $unit[$e], $row['count']);
}

print<<<HTML
</table>
</center>
</body>
</html>
HTML;

exit;
?>
