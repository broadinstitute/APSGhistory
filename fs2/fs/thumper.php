<?php

include "charts.php";

function startHTML($Title,$Heading) {
print<<<HTMLtop
<html>
<head>
  <title>$Title - $Heading</title>
</head>
<body bgcolor=8888888">
<b>
<center>
HTMLtop;
}

startHTML("Thumper","test");

print "<table>\n<tr>";

$n = 0;
$fp = fopen("/sysman/scratch/thumper/thumper_zfs.txt","r");
$f = array();
$ncol = 4;
while ($line = fgets($fp)) {
  if (preg_match("/-->/",$line)) {
    if (++$n % $ncol == 1) {
      print "</tr>\n<tr>";
    }
    $f = explode(" ", $line);
    $thumper = $f[1];
    $snap = 0;
    $free = 0;
    $chart =  InsertChart("charts.swf","charts_library","thumper_pie.php?thumper=$thumper", 250, 250);
    print "<td>$chart</td>\n";
  }
}
print "</tr>\n";

print<<<HTMLend
</table>
</center>
</body>
</html>
HTMLend;
?>
