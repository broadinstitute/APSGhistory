<?php

global $PHP_SELF;

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


$fp = fopen("/sysman/scratch/thumper/thumper_zfs.txt","r");
$f = array();
while ($line = fgets($fp)) {
  if (strlen($line) < 10) {
    continue;
  }
  if (preg_match("/-->/",$line)) {
    $f = explode(" ", $line);
    $thumper = $f[1];
    $when = $f[4];
    $snap = 0;
    print "<table>\n";
    print "<tr><th>$thumper</th><th>$when</th>\n";
    continue;   
  }
  if (preg_match("/<--/",$line)) {
    ##
    ## Print things out
    ##
    print "</table>\n";
    continue;
  }
  if (preg_match ("/@bkup/",$line)) {
    $snap = 1;
    continue;
  }
  list ($fs,$used,$avail,$refer,$mount) = explode("\t", $line);
  if (preg_match("/\//",$fs)) {
    print "<tr><td>$fs</th><td>$used</td><td>$avail</td></tr>\n";
  } else {
    print "<tr><th>$mount</th><td>$used</td><td>$avail</td></tr>\n";
  }

}

print<<<HTMLend
</center>
</body>
</html>
HTMLend;
?>
