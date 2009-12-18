<?php

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

startHTML("Thumper","Google test");

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
    $thumper = rtrim($f[1]);
    $used  = 0;
    $avail = 0;
    $alloc = 0;
    $snap  = 0;
    while ($line = fgets($fp)) {
      if (strlen($line) < 10) {
        if (preg_match("/<--/",$line)) {
          break 1;
        }
        continue;
      }
      if (preg_match ("/@bkup/",$line)) {
        list ($f,$u,$a,$r,$m) = explode("\t", $line);
        $snap += toTB($u);
        continue;
      }
      if (preg_match ("/zpool/", $line)) {
        list ($f,$u,$a,$r,$m) = explode("\t", $line);
        if (preg_match("/\//",$f)) {
          $used  += toTB($u);
          $avail += toTB($a);
          $alloc += toTB($u)+toTB($a);
        } else {
          ##
          ## This is the top zpool line
          ##
          $usable = toTB($u)+toTB($a);
        }
      }
    }
    $title = sprintf("%s (%.1fT usable, %.1f allocated)",$thumper,$usable,$alloc);
    $title = urlencode($title);
    $used = $used < .001 ? 0 : $used;
    $unalloc = $unalloc < .001 ? 0 : $unalloc;
    if ($alloc > $usable+.03) {
      $unalloc = 0;
      $overalloc = 1;
      $url="http://chart.apis.google.com/chart?cht=p3&chco=04346c,6899d3&chtt=$title&chd=t:$used,$avail&chs=300x150&chl=Used|Available";
    } else {
      $unalloc = $usable - $alloc;
      $unalloc = $unalloc < .001 ? 0 : $unalloc;
      $overalloc = 0;
      $url="http://chart.apis.google.com/chart?cht=p3&chco=04346c,6899d3,ff9c00&chtt=$title&chd=t:$used,$avail,$unalloc&chs=300x150&chl=Used|Available|Unallocated";
    }
    $used = $used < .001 ? 0 : $used;
    $unalloc = $unalloc < .001 ? 0 : $unalloc;
    print "<td><img src=$url></td>\n";
  }
}
print "</tr>\n";

print<<<HTMLend
</table>
</center>
</body>
</html>
HTMLend;

exit;

function toTB($a) {
  static $unit;
  isset($unit) or $unit = array( 'T' => 1, 'G' => 1E-3, 'M' => 1E-6, 'K' => 1E-9);
  $t = substr($a,0,strlen($a)-1) * $unit[substr($a,-1,1)];
  return $t;
}
?>
