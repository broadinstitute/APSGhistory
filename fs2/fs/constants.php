<?php

$tid = array(
             'atime' => 15,
             'ctime' => 13,
             'mtime' => 11,
             'size'  => 1,
             'cap'   => 2
            );

$title = array(
               'owner' => "Distribution of file ownership",
               'atime' => "Distribution of last access time",
               'mtime' => "Distribution of last modifcation time",
               'ctime' => "Distribution of last inode change time",
               'size'  => "Distribution of reported file size",
               'cap'   => "Distribution of file size on disk"
              );

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
               "&#60; 1 week",    #  => 1,
               "> 1 week",   #  => 2,
               "> 1 month",  #  => 3,
               "> 2 months",  #  => 4,
               "> 4 months",  #  => 5,
               "> 8 months", #  => 6,
               "> 18 months",   #  => 7,
               "> 3 years", #  => 8,
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

?>
