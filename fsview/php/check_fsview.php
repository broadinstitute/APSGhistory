#!/usr/bin/php
<?php
// +-------------------------------------------------------------------------+
// | Program Name:	check_fsview.php			
// | Author:  Ed Lauzier   Date:  11 October 2011	
// | Version: 0.1 ( Prototype ) 				
// | Purpose: Monitor database for file system information extraction
// |								
// | This program is free software; you can redistribute it and/or
// | modify it under the terms of the GNU General Public License 
// | as published by the Free Software Foundation; either version 2 
// | of the License, or (at your option) any later version. 	
// |								
// | This program is distributed in the hope that it will be useful,
// | but WITHOUT ANY WARRANTY; without even the implied warranty of 
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// | GNU General Public License for more details.		
// +-------------------------------------------------------------------------+

//for email...
require 'Net/SMTP.php';
$rcpt = array('StorageServiceCenter@broadinstitute.org','elauzier@broadinstitute.org');
//$rcpt = array('elauzier@broadinstitute.org','matter@broadinstitute.org');
//$rcpt = array('elauzier@broadinstitute.org');


// Set program timeout
$ALARM_TIMEOUT = 20;

// Set the desired output format
$OutputFormat = 1;

$PROGRAM_NAME  = basename($argv[0]);

// Set group pid for process control
$mypid = posix_getpid();
posix_setpgid($mypid, $mypid);
$mygpid = $mypid;

// flush output buffers automatically
ob_implicit_flush();

// Set up signal alarm for license polling timeout
declare(ticks=1);
pcntl_signal(SIGALRM, "my_signal_handler", true);
pcntl_alarm($ALARM_TIMEOUT); // alarm after n seconds...
pcntl_signal(SIGTERM,"my_signal_handler");
pcntl_signal(SIGHUP,"my_signal_handler");
pcntl_signal(SIGINT,"my_signal_handler");
pcntl_signal(SIGUSR1,"my_signal_handler");

// Remember during cleanup if no errors to remove error file upon exiting...
// Not done yet.
$fdspec = array(
0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
2 => array("file", "/tmp/$PROGRAM_NAME.$mypid.error.txt", "a") // stderr is a file to write to
);


flush();

// mysql read-only access info
$host  = 'calcium';
$user  = 'elauzier';
$pass  = 'lsfacctdata';
$dbase = 'matter';

$mybufsize = 1024;

// hashes for results info
$fsvo           = array();
$oldmountpoints = array();

// email output buffer
$obuf  = sprintf("%'#120s\n",' ');
$obuf .= sprintf("FSview Report from host ".getenv('HOSTNAME')."\n");
$obuf .= sprintf("Cron file location: /etc/cron.d/fsview"."\n");
$obuf .= sprintf("Script Location: /sysman/scratch/elauzier/fsview_devel/check_fsview.php"."\n");
$obuf .= sprintf("Report date: ".date("F j, Y, g:i a")."\n\n");

// auto.master hash info
$amts = array();

// yp commands
$ammaplist = array();
$ammapinfo = array();
$ypcmd1 = "ypcat -k auto.master |awk '{print $2}'";

// load automount map list array...
// should put into a function, but not required now.
$process_yp = proc_open("$ypcmd1", $fdspec, $pipes);
if (is_resource($process_yp)) {
	fclose($pipes[0]);	
	while (!feof($pipes[1])) {
	if(is_resource($pipes[1])) {
		$line = fgets($pipes[1], $mybufsize);
		//print $line;
		$ammaplist[] = trim($line);
	} else {
		while(true) {
			echo "PING : $mypid : ERROR: Unexpected Result.	Exiting...\n";
			sleep(1);
			clean_up();
		}
	  }
    }
 	fclose($pipes[1]);           
}
proc_close($process_yp);

// process NIS info and populate $ammapinfo hash...
ProcessAutomountNISInfo(&$ammaplist, $ammapinfo);

// establish mysql connection
$mysqli = new mysqli($host,$user,$pass,$dbase);
$dbh = $mysqli;

// option 1 - file systems that do not have group identifiers set.
$fsview_option = 1;
$sql_query     = 'select * from matter.filesystem where deprecated is false and gid is null';
$mystate       = fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option);
PrintFSviewInfo($fsvo, $fsview_option, $ammapinfo, $obuf);

// option 2
$fsview_option = 2;
$sql_query     = 'select * from matter.filesystem where deprecated is false and type is null';
$mystate       = fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option);
PrintFSviewInfo($fsvo, $fsview_option, $ammapinfo, $obuf);

// option 3
$fsview_option = 3;
$sql_query     = 'select * from matter.filesystem where deprecated is false';
$mystate       = fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option);
PrintFSviewInfo($fsvo, $fsview_option, $ammapinfo, $obuf);


// option 4
$fsview_option = 4;
$sql_query     = 'select f.* from matter.fsusage u inner join matter.filesystem f on u.fsid=f.id 
			      where u.checked = (select max(checked) from matter.fsusage) 
			      and u.used < 100';
$mystate       =  fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option);
PrintFSviewInfo($fsvo, $fsview_option, $ammapinfo, $obuf);

// option 5
$fsview_option = 5;
$sql_query     = 'select * from filesystem where deprecated is false
				  group by mount having count(mount) > 1';
$mystate       =  fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option);
PrintFSviewInfo($fsvo, $fsview_option, $ammapinfo, $obuf);

// close mysql connection
$mysqli->close();

// print obuf when needing to see output on screen...
//print $obuf."\n";

// send email with results...
FSviewSendmail($obuf, $rcpt);

// get rid of tmp file if present...
if(file_exists("/tmp/$PROGRAM_NAME.$mypid.error.txt")){
	unlink("/tmp/$PROGRAM_NAME.$mypid.error.txt");
}

exit(0);

// End of Main program

// Start function definitions

function PrintFSviewInfo(&$fsvo, &$fsview_option, &$ammapinfo, &$obuf){
	$numfs = sizeof($fsvo[$fsview_option]);
	switch ($fsview_option)
	{
    case 1:
	if($numfs > 0){
		$obuf .= sprintf("%'#120s\n",' ');
		$obuf .= sprintf("fsview option $fsview_option :  ");
		$obuf .= sprintf("Mounts with no defined group id.\n\n");
		$obuf .= sprintf("%-10s%-40s%-60s%-10s\n",'ID','MOUNT','PATH','GID');
		$obuf .= sprintf("%'#120s\n",' ');
		if($fsvo[$fsview_option][0] != 'NULL'){
		    for ($i = 0; $i < $numfs; $i++){
		       if ($fsvo[$fsview_option][$i]['gid'] == NULL){$fsvo[$fsview_option][$i]['gid'] = 'NULL';}
		   
               $obuf .= sprintf("%-10s%-40s%-60s%-10s\n",$fsvo[$fsview_option][$i]['id'],
                     $fsvo[$fsview_option][$i]['mount'],
                     $fsvo[$fsview_option][$i]['path'],
                     $fsvo[$fsview_option][$i]['gid']);
            }
        } else {
	      $obuf .= sprintf("None\n");   
        }
    }
    break;
    case 2:
    if($numfs > 0){
		$obuf .= sprintf("%'#120s\n",' ');
		$obuf .= sprintf("fsview option $fsview_option :  ");
		$obuf .= sprintf("Mounts with no defined filesystem type.\n\n");
		$obuf .= sprintf("%-10s%-40s%-60s%-10s\n",'ID','MOUNT','PATH','TYPE');
		$obuf .= sprintf("%'#120s\n",' ');
		if($fsvo[$fsview_option][0] != 'NULL'){
		for ($i = 0; $i < $numfs; $i++){
		   if ($fsvo[$fsview_option][$i]['type'] == NULL){$fsvo[$fsview_option][$i]['type'] = 'NULL';}
		   
           $obuf .= sprintf("%-10s%-40s%-60s%-10s\n",$fsvo[$fsview_option][$i]['id'],
                 $fsvo[$fsview_option][$i]['mount'],
                 $fsvo[$fsview_option][$i]['path'],
                 $fsvo[$fsview_option][$i]['type']);
        }
        } else {
	        $obuf .= sprint("None\n");
        }
    }
    break;
    case 3:
    if($numfs > 0){
		$obuf .= sprintf("%'#120s\n",' ');
		$obuf .= sprintf("fsview option $fsview_option :  ");
		$obuf .= sprintf("Mounts listed in db that are not in automount maps.\n\n");
		$obuf .= sprintf("%-10s%-40s%-60s%-10s\n",'ID','MOUNT','PATH','TYPE');
		$obuf .= sprintf("%'#120s\n",' ');
        if($fsvo[$fsview_option][0] != 'NULL'){
	    for ($i = 0; $i < $numfs; $i++){
		    // check for mounts that are in $fsvo but not in $ammapinfo...
	        if(!array_key_exists($fsvo[$fsview_option][$i]['mount'],$ammapinfo)){
		      $obuf .= sprintf("%-10s%-40s%-60s%-10s\n",$fsvo[$fsview_option][$i]['id'],
                 $fsvo[$fsview_option][$i]['mount'],
                 $fsvo[$fsview_option][$i]['path'],
                 $fsvo[$fsview_option][$i]['type']);  
	        } 	
	    }
        } else {
	      $obuf .= sprintf("None\n");  
        }
    }
    break;
    case 4:
    if($numfs > 0){
		$obuf .= sprintf("%'#120s\n",' ');
		$obuf .= sprintf("fsview option $fsview_option :  ");
		$obuf .= sprintf("Mounts that appear to be empty.\n\n");
		$obuf .= sprintf("%-10s%-40s%-60s%-10s\n",'ID','MOUNT','PATH','TYPE');
		$obuf .= sprintf("%'#120s\n",' ');
		if($fsvo[$fsview_option][0] != 'NULL'){		
		    for ($i = 0; $i < $numfs; $i++){
		       if ($fsvo[$fsview_option][$i]['type'] == NULL){$fsvo[$fsview_option][$i]['type'] = 'NULL';}
		       
               $obuf .= sprintf("%-10s%-40s%-60s%-10s\n",$fsvo[$fsview_option][$i]['id'],
                     $fsvo[$fsview_option][$i]['mount'],
                     $fsvo[$fsview_option][$i]['path'],
                     $fsvo[$fsview_option][$i]['type']);
            }
        } else {
	      $obuf .= sprintf("None\n");
        }  
    }
    break;
    case 5:
    if($numfs > 0){
		$obuf .= sprintf("%'#120s\n",' ');
		$obuf .= sprintf("fsview option $fsview_option :  ");
		$obuf .= sprintf("Mounts that have been moved and need to be marked depreciated.\n\n");
		$obuf .= sprintf("%-10s%-40s%-60s%-10s\n",'ID','MOUNT','PATH','TYPE');
		$obuf .= sprintf("%'#120s\n",' ');
		if($fsvo[$fsview_option][0] != 'NULL'){
             for ($i = 0; $i < $numfs; $i++){
                if ($fsvo[$fsview_option][$i]['type'] == NULL){$fsvo[$fsview_option][$i]['type'] = 'NULL';}
                
                $obuf .= sprintf("%-10s%-40s%-60s%-10s\n",$fsvo[$fsview_option][$i]['id'],
                      $fsvo[$fsview_option][$i]['mount'],
                      $fsvo[$fsview_option][$i]['path'],
                      $fsvo[$fsview_option][$i]['type']);
             }
        } else {
	      $obuf .= sprintf("None\n");
        }
    }
    break;
    default:
        print "Not a valid fsview option...\n";
    } //end switch 
    return 0;
}

function fsview_info($dbh, &$sql_query, &$fsvo, &$fsview_option) {

	if ($result = $dbh->query($sql_query)) {
		$fsvo[$fsview_option][] = array();
		$count = 0;
	    if ($result->num_rows > 0) {
		    while ($row = $result->fetch_object()) {
			    if ($count == 0){
				    $fsvo[$fsview_option][0] = (array)$row;
			    } else {
				    $fsvo[$fsview_option][] = (array)$row;
			    }
			    $count++; 
		    }
		    //print_r($fsvo[$fsview_option]);
	     } else {
		    $fsvo[$fsview_option][0] = 'NULL';
	     	return 0;
		 }
	} else {
		echo 'fsview option '.$fsview_option."\n";
		printf("There has been an error from MySQL: %s\n",$dbh->error);
		return 0;
	}
	return 0;
}

function ProcessAutomountNISInfo(&$ammaplist, &$ammapinfo){
	global $fdspec;
	$mybufsize = 1024;
	$atmp = array();
	$atmp2 = array();
	// Run each command...
	foreach($ammaplist as $ammap){
	//print $ammap."\n";
	$mytopdirinfo  = array();
	$mytopdirinfo  = explode('.', trim($ammap));
	$myypcmd = "ypcat -k $ammap";
	$process_yp = proc_open("$myypcmd", $fdspec, $pipes);
		if (is_resource($process_yp)) {
			fclose($pipes[0]);	
			while (!feof($pipes[1])) {
				if(is_resource($pipes[1])) {
					$line = fgets($pipes[1], $mybufsize);
					//print $line;
					//  Have to deal with automount options entries if present.
					//  They are in the second element if present...
					//  So check for three elements...
					$atmp = explode(' ',trim($line));
					if(isset($atmp[1])){      // gets rid of null lines since [1] will not be set.
					     $mytopdir = '/'.$mytopdirinfo[1];
					     if(isset($atmp[2])){ // detects mount options and selects desired values.
					        $mytopdir .= '/'.$atmp[0];
					        // use associative arrays to ease matching mount points...
					        $ammapinfo[$mytopdir] = explode(' ',$atmp[0]." ".$atmp[2]);
				         } else {
					        $mytopdir .= '/'.$atmp[0]; 
					        $ammapinfo[$mytopdir] = $atmp;
				         }
			    	}
					//sleep(1);
				} else {
					while(true) {
						echo "YPCAT : $mypid : ERROR: Unexpected Result.	Exiting...\n";
						sleep(1);
						clean_up();
					}
				}
			}
			fclose($pipes[1]);
			$return_value = proc_close($process_yp);
		}
	}
	return $return_value;				
}

function FSviewSendmail(&$obuf, &$rcpt){
	// borrowed code from simple example...
	// see http://pear.php.net/manual/en/package.networking.net-smtp.intro.php for details...
	//
    $mailhost = 'smtp.broadinstitute.org';
    $from = 'apsg@broadinstitute.org';
    $subj = "Subject: FSview Query Daily Report\n";
    $body = $obuf;  
    /* Create a new Net_SMTP object. */
    if (! ($smtp = new Net_SMTP($mailhost))) {
        die("Unable to instantiate Net_SMTP object\n");
    } 
    /* Connect to the SMTP server. */
    if (PEAR::isError($e = $smtp->connect())) {
        die($e->getMessage() . "\n");
    }  
    /* Send the 'MAIL FROM:' SMTP command. */
    if (PEAR::isError($smtp->mailFrom($from))) {
        die("Unable to set sender to <$from>\n");
    }  
    /* Address the message to each of the recipients. */
    foreach ($rcpt as $to) {
        if (PEAR::isError($res = $smtp->rcptTo($to))) {
            die("Unable to add recipient <$to>: " . $res->getMessage() . "\n");
        }
    }   
    /* Set the body of the message. */
    if (PEAR::isError($smtp->data($subj . "\r\n" . $body))) {
        die("Unable to send data\n");
    }   
    /* Disconnect from the SMTP server. */
    $smtp->disconnect();  
    return 0;		
}

function my_signal_handler($signal){
	// Do some meaningful tasks here or in clean_up()...
	global $mypid, $mytask;
	switch($signal) {
	case SIGALRM:
	print "$mypid Caught SIGALRM - ";
	print "$mytask - Process Runtime exceeded...\n";
	clean_up();
	break;
	case SIGTERM || SIGHUP || SIGINT || SIGUSR1:
		print "$mypid Caught signal to terminate.\n";
		clean_up();
		break;
	default:
		// Any special signal handling start here...
	break;
	}
}

function clean_up(){
	global $mygpid, $pipes, $process;
	//print "$mygpid Cleaning up\n";
	//fclose($pipes[1]);
	system("pkill -KILL -g $mygpid");
}

// End function definitions
?>
