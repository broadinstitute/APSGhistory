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

$fsid  = isset($_REQUEST['fsid']) ? $_REQUEST['fsid'] : 0;
$type  = isset($_REQUEST['type']) ? $_REQUEST['type'] : "atime";


include "config.php";
include "opendb.php";

if (isset($_REQUEST['filesystem'])) {
  if (preg_match("/platform/i",$_REQUEST['filesystem'])) {
    $fsid = -1;
  } elseif (preg_match("/program/i",$_REQUEST['filesystem'])) {
    $fsid = -2;
  } else {
    $mnt = $_REQUEST['filesystem'];
    $query = "SELECT id,path,snapshot,tapebackup,diskbackup FROM filesystem WHERE mount='$mnt' AND DEPRECATED IS FALSE ORDER BY id DESC";
    $result = mysql_query($query);
    if ($result) {
      $row = mysql_fetch_assoc($result);
      $fsid = $row['id'];
      $path = $row['path'];
      $snap = $row['snapshot'] > 0 ? "yes" : "no";
      $tape = $row['tapebackup'] > 0 ? "yes" : $row['diskbackup'] > 0 ? "yes" : "no";
    } else {
      $fsid = 0;
    }
  }
} else {
  $query = "SELECT mount,path,snapshot,tapebackup,diskbackup FROM filesystem WHERE id=$fsid";
  $result = mysql_query($query);
  $row = mysql_fetch_assoc($result);
  $mnt = $row['mount'];
  $path = $row['path'];
  $snap = $row['snapshot'] > 0 ? "yes" : "no";
  $tape = $row['tapebackup'] > 0 ? "yes" : $row['diskbackup'] > 0 ? "yes" : "no";
}

include 'constants.php';

$menu = makeViewMenu($type);

if ($fsid == 0) {
  $mnt = "all filesystems";
  $tape = "some";
  $snap = "some";
  $subt = "";
  $fsid = 0; # Why do I need this ?!?
} elseif ($fsid == -1) {
  $mnt = "all Platform filesystems";
  $tape = "some";
  $snap = "some";
  $subt = "";
  $fsid = -1; # Why do I need this ?!?
} elseif ($fsid == -2) {
  $mnt = "all Program filesystems";
  $tape = "some";
  $snap = "some";
  $subt = "";
  $fsid = -2; # Why do I need this ?!?
} else {
  $subt="($path)";
}

print<<<HTMLtop
<html>
<head>
  <link rel="stylesheet" type="text/css" href="fsstat.css"/>
  <title>$mnt</title>
</head>
<body bgcolor="888888">
<b>
<center>
<h1><font color="aabbcc">$mnt</font> 
    <font color="666666">$subt</font></h1>
<h4><font color="444444">Backups:</font><font color="aabbcc"> $tape&nbsp</font>
<font color="444444">Snapshots:</font><font color="aabbcc"> $snap</font></h4>
</center>
HTMLtop;



$trend = InsertChart("charts.swf", "charts_library", "fstrend.php?fsid=$fsid", 400, 250, "666666");
if ($type == "owner") {
  $stats = InsertChart("charts.swf", "charts_library", "fsowner.php?fsid=$fsid");
} else {
  $stats = InsertChart("charts.swf", "charts_library", "fsstats.php?fsid=$fsid&type=$type", 400, 250, "666666");
}

print<<<HTML
<center>
<form action="$PHP_SELF">
<table rules="none" cellspacing="0" cellpadding="0" bgcolor="666666">
  <tr>
  </tr>
  <tr>
    <td align="center" bgcolor="666666" colspan=2>
      <font color="111111" size="4" face="Arial">
        <b>Overview</b>
      </font>
    </td>
    <td align="center" bgcolor="666666" colspan=2>
      <font color="111111" size="4" face="Arial">
        <b>$title[$type]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>
      </font>
  </td>
  </tr>
  <tr>
    <td colspan=2>$trend</td>
    <td colspan=2 >$stats</td>
  </tr>
  <tr>
    <td bgcolor="666666" colspan=4 align=center>&nbsp</td>
  </tr>
  <tr>
    <td bgcolor="666666" align=right>
      <font color="111111" size="4" face="Arial">
      <b>Find file system:&nbsp&nbsp&nbsp</b>
      </font>
    </td>
    <td bgcolor="666666"><input type=text name=filesystem value="$mnt" size=20</td>
    <td bgcolor="666666" align=right>
      <font color="111111" size="4" face="Arial">
      <b>View:&nbsp&nbsp&nbsp</b>
      </font>
    </td>
    <td bgcolor="666666">
      $menu
    </td>
  </tr>
  <tr>
    <td bgcolor="666666" colspan=4 align=center><input type=submit value="Go"></td>
  </tr>
  <tr>
    <td bgcolor="666666" colspan=2 align=center><a href="http://apsg.broadinstitute.org/fs/fslist.php">List all file systems</a></td>
    <td bgcolor="666666" colspan=2 align=center><a href="http://apsg.broadinstitute.org/fs/fsuserlist.php?fsid=$fsid">List top data owners</a></td>
  </tr>
</table>
</form>
HTML;
if ($fsid > 0) {
  $query=<<<SQL
  SELECT d.dirid,d.name, s.sumval, s.checked
  FROM fsstat s
  INNER JOIN subdir d ON s.fsid=d.fsid AND s.dirid=d.dirid
  WHERE s.fsid=$fsid
  AND s.type=2
  AND s.uid IS NULL
  AND d.deprecated IS FALSE
  AND d.parent IS NULL
  AND latest=1
  ORDER BY s.sumval DESC
SQL;
  $result = mysql_query($query);
  $nrow = mysql_num_rows($result);
  if ($nrow > 10) {
    print "<h2>Top 10 subdirectories by size</h2>\n";
  } else {
    print "<h2>All $nrow subdirectories by size</h2>\n";
  }
  $n=0;
  while ($row = mysql_fetch_assoc($result)) {
    $n = $n + 1;
    if ($n == 1) {
      $when = strftime("%B %e, %Y", $row['checked']);
      print "<h5><font color='444444'>as of $when</font></h5>\n";
      print "<table>\n";
      print "<tr><th>Directory</th><th>Size</th></tr>\n";
    }
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
    printf ("<tr $cl><td><a href=fsdirview.php?fsid=$fsid&dirid=%d>%s</a></td><td>%.1f %s</td></tr>\n",
            $row['dirid'],$row['name'], $row['sumval']/$fact, $unit[$exp]);
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
