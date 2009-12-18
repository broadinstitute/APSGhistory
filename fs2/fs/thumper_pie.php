<?php

include "charts.php";

$thumper = $_REQUEST['thumper'];


$fp = fopen("/sysman/scratch/thumper/thumper_zfs.txt","r");
$f = array();
while ($line = fgets($fp)) {
  if (preg_match("/-->/",$line)) {
    $f = explode(" ", $line);
    if (rtrim($f[1]) == $thumper) {
      break 1;
    }
  }
}

$fs = array("");
$used = array("");
$avail = array("");
$alloc = 0;
while ($line = fgets($fp)) {
  if (strlen($line) < 10) {
    if (preg_match("/<--/",$line)) {
      ##
      ## Print things out
      ##
      break;
    }
    continue;
  }
  if (preg_match ("/@bkup/",$line)) {
#    $snap = 1;
    continue;
  }
  if (preg_match ("/zpool/", $line)) {
    list ($f,$u,$a,$r,$m) = explode("\t", $line);
    if (preg_match("/\//",$f)) {
      $scale = substr($u,-1,1);
      $fs[]   = $f;
      $used[] = toTB($u);
      $avail[] = toTB($a);
      $alloc += toTB($u)+toTB($a);
    } else {
      ##
      ## This is the top zpool line
      ##
      $fs[] = "available";
      $used[] = toTB($a);
#      $fs[] = "zpool";
#      $used[] = toTB($u);
#      $avail[] = toTB($a);
      $usable = toTB($u)+toTB($a);
    }
  }
}
$title=sprintf("%s (%.1fT usable, %.1fT allocated)",$thumper,$usable,$alloc);

#$chart[ 'chart_type' ] = "3d pie";
$chart[ 'chart_type' ] = "pie";
$chart[ 'chart_data' ] = array($fs,$used);
#$chart[ 'chart_type' ] = "stacked column";
#$chart[ 'chart_data' ] = array($fs,$avail,$used);
$chart[ 'draw' ] = array(
                         array(
                               'type' => 'text',
                               'text' => $title,
                               'size' => 12,
                               'x'    => 5
                              )
                        );
$chart[ 'series_color' ] = array(
                                 "fafafa",
                                 "6ab8f9",
                                 "5b9dd4",
                                 "4b81ad",
                                 "fadb6b",
                                 "d4a558",
                                 "ad884b",
                                 "6abaf9",
                                 "5b9dd4",
                                 "4b81ad",
                                 "fadb6b",
                                 "d4a558",
                                 "ad884b",
                                );
$chart[ 'license' ] = "J1XQREZO-U7LO.W5T4Q79KLYCK07EK";
SendChartData( $chart );

exit;

function toTB($a) {
  $unit = array( 'T' => 1, 'G' => 1E-3, 'M' => 1E-6, 'K' => 1E-9);
  $t = substr($a,0,strlen($a)-1) * $unit[substr($a,-1,1)];
  return $t;
}
?>
