<?php

function makeViewMenu($selected="") {

  $viewMenu=<<<viewMenu

<select name=type size=1>
  <option value="owner">file ownership</option>
  <option value="atime">last access</option>
  <option value="mtime">last modification</option>
  <option value="ctime">last inode change</option>
  <option value="size">file size</option>
  <option value="cap">capacity used</option>
</select>

viewMenu;

  $viewMenu = preg_replace("|\"$selected\">*|","\"$selected\" SELECTED>",$viewMenu);

  return $viewMenu;
}

include "charts.php";

global $PHP_SELF;

$fsid  = isset($_REQUEST['fsid'])  ? $_REQUEST['fsid'] : 0;
$dirid = isset($_REQUEST['dirid']) ? $_REQUEST['dirid'] : 0;
$type  = isset($_REQUEST['type'])  ? $_REQUEST['type'] : "atime";

include "config.php";
include "opendb.php";

$query = <<<SQL
select f.mount, f.path, d.name
from filesystem f, subdir d
where f.id=$fsid
and d.fsid = f.id
and d.dirid=$dirid
and d.deprecated is false
SQL;

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$dir  = $row['name'];
$mnt  = $row['mount'];
$path = $row['path'];

include 'constants.php';

$menu = makeViewMenu($type);

$subt="($path)";

print<<<HTMLtop
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>$mnt/$dir</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="aabbcc"><a href=fsview.php?fsid=$fsid&type=$type>$mnt<a>/$dir</font> 
    <font color="666666">$subt</font></h1>
</center>
HTMLtop;



if ($type == "owner") {
  $stats = InsertChart("charts.swf", "charts_library", "fsowner.php?fsid=$fsid$dirid=$dirid");
} else {
  $stats = InsertChart("charts.swf", "charts_library", "fsstats.php?fsid=$fsid&dirid=$dirid&type=$type", 400, 250, "666666");
}

print<<<HTML
<center>
<form action="$PHP_SELF">
<input type=hidden name=fsid value=$fsid>
<input type=hidden name=dirid value=$dirid>
<table rules="none" cellspacing="0" cellpadding="0" bgcolor="666666">
  <tr>
  </tr>
  <tr>
    <td align="center" bgcolor="666666" colspan=3>
      <font color="111111" size="4" face="Arial">
        <b>$title[$type]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>
      </font>
  </td>
  </tr>
  <tr>
    <td colspan=3 >$stats</td>
  </tr>
  <tr>
    <td bgcolor="666666" colspan=3 align=center>&nbsp</td>
  </tr>
  <tr>
    <td bgcolor="666666" align=right>
      <font color="111111" size="4" face="Arial">
      <b>View:&nbsp&nbsp&nbsp</b>
      </font>
    </td>
    <td bgcolor="666666">
      $menu
    </td>
    <td bgcolor="666666" align=left><input type=submit value="Go"></td>
  </tr>
</table>
</form>
HTML;
if ($fsid > 0) {
  $query=<<<SQL
  SELECT u.gecos,u.username, s.sumval
  FROM fsstat s
  INNER JOIN users u on s.uid = u.uid
  WHERE s.fsid=$fsid
  AND s.dirid=$dirid
  AND s.type=2
  AND s.uid IS NOT NULL
  AND latest=1
  ORDER BY s.sumval DESC
SQL;
  $result = mysql_query($query);
  $nrow = mysql_num_rows($result);
  if ($nrow > 10) {
    print "<h2>Top 10 data owners in directory</h2>\n";
  } else {
    print "<h2>All data owners in directory</h2>\n";
  }
  print "<table>\n";
  print "<tr><th>User</th><th>Data volume</th></tr>\n";
  $n=0;
  while ($row = mysql_fetch_assoc($result)) {
    $n = $n + 1;
    if ($n > 10) {
      break;
    }
    if ($n%2) {
      $cl = 'class="odd"';
    } else {
      $cl = '';
    }
    $exp = (int)(log($row['sumval'],1000));
    $fact = pow(1000,$exp);
    printf ("<tr $cl><td><a href=\"fsuser.php?user=%s\">%s (%s)</a></td><td>%.1f %s</td></tr>\n",
            $row['username'], $row['gecos'], $row['username'], $row['sumval']/$fact, $unit[$exp]);
  }
  print "</table>\n";
}
include "closedb.php";

print<<<HTML_END
<p>
<font color=333333>
Comments? Suggestions? Please email <a href=mailto:apsg@broadinstitute.org>apsg@broadinstitute.org</a>.
</font>
</center>
</body>
</html>
HTML_END;

exit;

?>
