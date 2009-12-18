<?php
require ('gChart2.php');

$ind_t = array(
               '0'    => 1,
               '2'    => 1,
               '4'    => 1,
               '8'    => 1,
               '16'   => 2,
               '32'   => 2,
               '64'   => 3,
               '128'  => 4,
               '256'  => 5,
               '512'  => 6,
               '1024' => 7,
               '2048' => 8,
              );

$lab_t = array(
               "",          #  => 0,
               "&#60;+1+week",    #  => 1,
               "&#60;+1+month",   #  => 2,
               "&#60;+2+months",  #  => 3,
               "&#60;+4+months",  #  => 4,
               "&#60;+8+months",  #  => 5,
               "&#60;+18+months", #  => 6,
               "&#60;+3+years",   #  => 7,
               ">+3+years", #  => 8,
              );

$ind_s = array(
               '0'          => 1,
               '2'          => 1,
               '4'          => 1,
               '8'          => 1,
               '16'         => 1,
               '32'         => 1,
               '64'         => 1,
               '128'        => 2,
               '256'        => 2,
               '512'        => 2,
               '1024'       => 2,
               '2048'       => 2,
               '4096'       => 2,
               '8192'       => 3,
               '16384'      => 4,
               '32768'      => 4,
               '65536'      => 4,
               '131072'     => 4,
               '262144'     => 5,
               '524288'     => 5,
               '1048576'    => 5,
               '2097152'    => 6,
               '4194304'    => 6,
               '8388608'    => 6,
               '16777216'   => 6,
               '33554432'   => 7,
               '67108864'   => 7,
               '134217728'  => 8,
               '268435456'  => 8,
               '536870912'  => 8,
               '1073741824' => 8,
               '2147483648' => 8
              );

$lab_s = array(
               "",         #  => 0,
               "128 KB",   #  => 1,
               "4 MB",     #  => 2,
               "8 MB",     #  => 3,
               "128 MB",   #  => 4,
               "1 GB",     #  => 5,
               "16 GB" ,   #  => 6,
               "128 GB",   #  => 7,
               "> 128 GB", #  => 8,
              );

$unit = array('KB','MB','GB','TB','PB');

$ntop = 7;

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

startHTML("Statview", "Google test");

##
## Load data
##
$gid = isset($_REQUEST['gid']) ? $_REQUEST['gid'] : 9;

include 'config.php';
include 'opendb.php';

$ind = $ind_t;
$lab = $lab_t;

$query = <<<SQL
SELECT g.name,f.mount,s.maxcnt,s.histogram,s.checked
FROM fsstat s
INNER JOIN filesystem f ON f.id=s.fsid
INNER JOIN grp g on f.gid=g.id
WHERE s.fsid > 0
AND f.gid = $gid
AND s.type = 15
AND s.uid IS NULL
AND s.dirid IS NULL
AND s.latest=1
ORDER BY s.maxcnt DESC
SQL;

print "<table>\n";
print "<tr><th>File system</th><th>Age distribution</th></tr>\n";
    
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result)) {

$max = $row['maxcnt'];
$mount = $row['mount'];

$when = strftime("%B %e, %Y", $row['checked']);

$lines = explode(":",$row['histogram']);
$dat = array();
$cat = array();
$cat[0] = "";
$dat[0] = "Last access (KB)";
$nmax = 0;
foreach ($lines as $line) {
  list ($bot, $top, $cnt, $valcnt) = explode(",", $line);
  $top = $top > 1024 ? 1024 : $top;
  $val = $cnt;
  $n = $ind[$top];
  $dat[$n] = isset($dat[$n]) ? $dat[$n] + $val : $val;
  $nmax = $n > $nmax ? $n : $nmax;
  $cat[$n] = $lab[$n];
}

##
## Rescale
##
$data = "";
$label = "0:";
$e = (int)(log($max,1000));
$fact = pow(1000,$e);
for ($i = 1; $i<=$nmax; $i++) {
  $dat[$i] = floor($dat[$i]/$fact +0.5);
  if ($i == 1) {
    $data = $dat[$i];
  } else {
    $data = "$data,$dat[$i]";
  }
  $l = urlencode($cat[$i]);
  $label = "$label|$l";
}
$max = floor($max/$fact+0.5);
$chart = new gPieChart;
#$chart->type = 6;
$chart->height = 115;
#$chart->values = array($data);
$chart->addDataSet($dat);
$chart->valueLabels = $cat;

#$url = "http://chart.apis.google.com/chart?cht=p&chd=t:$data&chxt=x,y&chds=1,$max&chxr=1,0,$max&chs=200x100&chbh=a&chco=4D89F9";
#$url = "http://chart.apis.google.com/chart?cht=bvs&chd=t:$data&chxt=y&chds=0,$max&chs=200x100&chbh=a&chco=4D89F9";
print "<tr><td>$mount</td><td><img src="; 
print $chart->getUrl();
print "></img></td>\n";
}


#$chart['chart_data'] = array($cat,$dat);

print<<<HTMLend
</table>
</center>
</body>
</html>
HTMLend;

exit;
?>
