<?php

function makeViewMenu($selected="") {

  $viewMenu=<<<viewMenu

<select name=type size=1>
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

$fsid = isset($_REQUEST['fsid']) ? $_REQUEST['fsid'] : 0;
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "atime";
$uid  = isset($_REQUEST['uid'])  ? $_REQUEST['uid']  : 0;


include "config.php";
include "opendb.php";

if (isset($_REQUEST['user'])) {
  $user = $_REQUEST['user'];
  $query = "SELECT uid,username,gecos FROM users WHERE username='$user'";
  $result = mysql_query($query);
  if ($result) {
    $row = mysql_fetch_assoc($result);
    $uid = $row['uid'];
    $gecos = $row['gecos'];
  } else {
    $uid = 0;
    $gecos = 'root';
  }
} else {
  $query = "SELECT username,gecos FROM users WHERE uid=$uid";
  $result = mysql_query($query);
  $row = mysql_fetch_assoc($result);
  $user = isset($row['username']) ? $row['username'] : "UID $uid";
  $gecos = $row['gecos'];
}

#$query =<<<SQL
#SELECT checked,blocks,used,available,capacity
#FROM fsusage
#WHERE fsid=$fsid
#checked = (
#    SELECT MAX(checked) FROM fsusage where fsid=$fsid
#  )
#SQL;


#$result = mysql_query($query);
#$row = mysql_fetch_assoc($result);

include 'constants.php';

#$exp = (int)(log($row['blocks'],1000));
#$fact = pow(1000,3);
#$blocks = sprintf("%2d %s",$row['blocks']/$fact, $unit[$exp]);
#$used   = sprintf("%2d %s",$row['used']/$fact, $unit[$exp]);
#$cap    = $row['capacity'];

$menu = makeViewMenu($type);

print<<<HTMLtop
<HTML>
<HEAD>
  <TITLE>File system usage for $user</TITLE>
</HEAD>
<BODY BGCOLOR="888888">
<B>
<CENTER>
<H1><FONT COLOR="aabbcc">File system usage for $gecos</FONT> 
    <FONT COLOR="666666">($user)</FONT></H1>
</CENTER>
HTMLtop;

include "closedb.php";

$trend = InsertChart("charts.swf", "charts_library", "fsuserfs.php?uid=$uid");
$stats = InsertChart("charts.swf", "charts_library", "fsstats_u.php?uid=$uid&type=$type");

print<<<HTML
<center>
<form action="$PHP_SELF">
<table rules="none" cellspacing="0" cellpadding="0" bgcolor="666666">
  <tr>
  </tr>
  <tr>
    <td align="center" bgcolor="666666" colspan=2>
      <font color="111111" size="4" face="Arial">
        <b>Usage by file system&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b>
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
      <b>Find user:&nbsp&nbsp&nbsp</b>
      </font>
    </td>
    <td bgcolor="666666"><input type=text name=user value="$user" size=8</td>
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
    <td bgcolor="666666" colspan=4 align=center>&nbsp</td>
  </tr>
  <tr>
    <td bgcolor="666666" colspan=4 align=center><input type=submit value="Go"></td>
  </tr>
</table>
</form>
<p>
<font color=333333>
Comments? Suggestions? Please email <a href=mailto:apsg@broadinstitute.org>apsg@broadinstitute.org</a>.
</font>
</center>
</body>
</html>
HTML;

exit;

?>
