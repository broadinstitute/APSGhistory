<? session_start(); ?>
<html>
<head>
<title>broaddb -- BROAD_DB_SERVER_STORAGE_REPORT</title>
<meta name="generator" content="text/html">
<style type="text/css">
  body {
    background-color: #FFFFFF;
    color: #004080;
    font-family: Arial;
    font-size: 12px;
  }
  .bd {
    background-color: #FFFFFF;
    color: #004080;
    font-family: Arial;
    font-size: 12px;
  }
  .tbl {
    background-color: #FFFFFF;
  }
  a:link {
    color: #FF0000;
    font-family: Arial;
    font-size: 12px;
  }
  a:active {
    color: #0000FF;
    font-family: Arial;
    font-size: 12px;
  }
  a:visited {
    color: #800080;
    font-family: Arial;
    font-size: 12px;
  }
  .hr {
    background-color: #336699;
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:link {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:active {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:visited {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  .dr {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  .sr {
    background-color: #FFFFCF;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
</style>
</head>
<body>
<img src="broad.gif" alt="" border="0">
<table class="bd" width="100%"><tr><td class="hr"></td></tr></table>
<?
  $conn = connect();
  $showrecs = 30;
  $pagerange = 10;

  $a = @$_GET["a"];
  $recid = @$_GET["recid"];

  $page = @$_GET["page"];
  if (!isset($page)) $page = 1;

  switch ($a) {
    case "view":
      viewrec($recid);
      break;
    default:
      select();
      break;
  }


  ocilogoff($conn);
?>
<table class="bd" width="100%"><tr><td class="hr">http://gpd52-1f0</td></tr></table>
</body>
</html>

<? function select()
  {
  global $a;
  global $showrecs;
  global $page;

  $res = sql_select();
  $count = sql_getrecordcount();
  if ($count % $showrecs != 0) {
    $pagecount = intval($count / $showrecs) + 1;
  }
  else {
    $pagecount = intval($count / $showrecs);
  }
  $startrec = $showrecs * ($page - 1);
  if ($startrec < $count) {for ($i = 1; $i <= $startrec; ocifetchassoc($res), $i++);}
  $reccount = min($showrecs * $page, $count);
  $fields = array(
    "SERVER_NAME" => "SERVER_NAME",
    "ALLOCATION" => "ALLOCATION",
    "USED" => "USED",
    "FREE" => "FREE");
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>Table: BROAD_DB_SERVER_STORAGE_REPORT</td></tr>
<tr><td>Records shown <? echo $startrec + 1 ?> - <? echo $reccount ?> of <? echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<? showpagenav($page, $pagecount); ?>
<br>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<?
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="hr"><? echo $caption ?></td>
<? } ?>
</tr>
<?
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = ocifetchassoc($res);
    $style = "dr";
    if ($i % 2 != 0) {
      $style = "sr";
    }
?>
<tr>
<?
  reset($fields);
  foreach($fields as $val => $caption) {
?>
<td class="<? echo $style ?>"><? echo htmlspecialchars($row[$val]) ?></td>
<? } ?>
<td class="<? echo $style ?>"><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?a=view&recid=<? echo $i ?>">View</a></td>
</tr>
<?
  }
  ocifreestatement($res);
?>
</table>
<br>
<? showpagenav($page, $pagecount); ?>
<? } ?>

<? function showrow($row)
  {
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
<tr>
<td class="hr"><? echo htmlspecialchars("SERVER_NAME")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["SERVER_NAME"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("ALLOCATION")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["ALLOCATION"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("USED")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["USED"]) ?></td>
</tr>
<tr>
<td class="hr"><? echo htmlspecialchars("FREE")."&nbsp;" ?></td>
<td class="dr"><? echo htmlspecialchars($row["FREE"]) ?></td>
</tr>
</table>
<? } ?>

<? function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<? if ($page > 1) { ?>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?page=<? echo $page - 1 ?>">&lt;&lt;&nbsp;Prev</a>&nbsp;</td>
<? } ?>
<?
  global $pagerange;

  if ($pagecount > 1) {

  if ($pagecount % $pagerange != 0) {
    $rangecount = intval($pagecount / $pagerange) + 1;
  }
  else {
    $rangecount = intval($pagecount / $pagerange);
  }
  for ($i = 1; $i < $rangecount + 1; $i++) {
    $startpage = (($i - 1) * $pagerange) + 1;
    $count = min($i * $pagerange, $pagecount);

    if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
      for ($j = $startpage; $j < $count + 1; $j++) {
        if ($j == $page) {
?>
<td><b><? echo $j ?></b></td>
<? } else { ?>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?page=<? echo $j ?>"><? echo $j ?></a></td>
<? } } } else { ?>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?page=<? echo $startpage ?>"><? echo $startpage ."..." .$count ?></a></td>
<? } } } ?>
<? if ($page < $pagecount) { ?>
<td>&nbsp;<a href="BROAD_DB_SERVER_STORAGE_REPORT.php?page=<? echo $page + 1 ?>">Next&nbsp;&gt;&gt;</a>&nbsp;</td>
<? } ?>
</tr>
</table>
<? } ?>

<? function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php">Index Page</a></td>
<? if ($recid > 0) { ?>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?a=<? echo $a ?>&recid=<? echo $recid - 1 ?>">Prior Record</a></td>
<? } if ($recid < $count) { ?>
<td><a href="BROAD_DB_SERVER_STORAGE_REPORT.php?a=<? echo $a ?>&recid=<? echo $recid + 1 ?>">Next Record</a></td>
<? } ?>
</tr>
</table>
<hr size="1" noshade>
<? } ?>


<? function viewrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  for ($i = 1; $i <= $recid; ocifetchassoc($res), $i++);
  $row = ocifetchassoc($res);
  showrecnav("view", $recid, $count);
?>
<br>
<? showrow($row) ?>
<?
  ocifreestatement($res);
} ?>

<? function connect()
{
  $conn = ocilogon("SYSTEM", "del_ph1", "broaddb");
  return $conn;
}

function sql_select()
{
  global $conn;

  $sql = "SELECT case grouping(server_name) when 0 then server_name when 1 then 'TOTALS' end server_name ,sum(a.current_allocation)\"ALLOCATION\", sum(a.current_used)\"USED\", sum(a.current_free)\"FREE\" FROM mdman.server_storage a where a.current_date > sysdate -1group by rollup ( a.server_name )order by a.server_name ";
  $res = ociquery($sql);
  return $res;
}

function sql_getrecordcount()
{
  global $conn;

  $sql = "SELECT COUNT(*) AS ROWCOUNT FROM (SELECT case grouping(server_name) when 0 then server_name when 1 then 'TOTALS' end server_name ,sum(a.current_allocation)\"ALLOCATION\", sum(a.current_used)\"USED\", sum(a.current_free)\"FREE\" FROM mdman.server_storage a where a.current_date > sysdate -1group by rollup ( a.server_name )) S";
  $res = ociquery($sql);
  $row = ocifetchassoc($res);
  reset($row);
  return current($row);
}

function ociquery($sql)
{
  global $conn;

  $res = ociparse($conn, $sql);
  ociexecute($res, OCI_DEFAULT) or die(ocierror());
  ocicommit($conn);
  return $res;
}

function ocifetchassoc($res)
{
  $ret_array = array();
  ocifetchinto($res, $ret_array, OCI_ASSOC);
  return $ret_array;
} ?>
