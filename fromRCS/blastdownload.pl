#!/util/bin/perl -w

eval 'exec /util/bin/perl -w -S $0 ${1+"$@"}'
    if 0; # not running under some shell

# @(#) $Id$
#
# The Broad Institute
# SOFTWARE COPYRIGHT NOTICE AGREEMENT
# This software and its documentation are copyright 2005 by the
# Broad Institute/Massachusetts Institute of Technology. All rights are
# reserved.

# This software is supplied without any warranty or guaranteed support
# whatsoever. Neither the Broad Institute nor MIT can be responsible for its
# use, misuse, or functionality.

use strict;
use Net::FTP;
use Getopt::Long;

(my $progname = $0) =~ s#^.*/##;
my $USAGE;
my $VERBOSE = 0;
my $HOST = 'ftp.ncbi.nih.gov';
my $USER_NAME = 'anonymous';
my $PASSWD = 'squid@broad.mit.edu';
my $FTP_DIR ='blast/db';
my $FTPDOWNLOADDIR;
my $DB_DIR;
my $BLASTDB;

$| = 1; #set STDOUT to flush after each print; should make the log more logical

###############################################################################
# Connect to ftp server
# get files under ftp server directory that matches specified file names
# uncompress the tar file
###############################################################################
sub ftpGetMyFiles {

    # connect to ftp server
    my $ftp = Net::FTP->new($HOST, Timeout=>800);
    $ftp->login($USER_NAME, $PASSWD) or die("ftpConnect error: " . $ftp->message()); 	
    $ftp->binary() or die($ftp->message());
    $ftp->cwd($FTP_DIR) or die("Could not cwd to $FTP_DIR: " . $ftp->message());

    print("Connected to NIH.\n") if ($VERBOSE);

    my @mFiles = grep { /^$BLASTDB.*.tar.gz/ } $ftp->ls();

   	for (@mFiles) {
		#download the file to ftpdownload directory, uncompress files.
		print("ftp get file $_\n") if ($VERBOSE);	
		$ftp->get($_) or die("ftp get error for file $_: $! "  . $ftp->message());
	}

	$ftp->quit();
	print("FTP quit.\n") if ($VERBOSE);

   	for (@mFiles) {
		#uncompress the tar file
		print("tar xzf $_\n") if ($VERBOSE);

		if (system("tar xzf $_")) {
			die("unable to untar file $_ : $!");	
		}

        # after successfull uncompress remove the tar.gz file.
        unlink($_) or die("Could not remove file after successful untar: $!");
	}

    opendir(DBDIR, $DB_DIR) or die("Could not opendir $DB_DIR: $!");
    my @existingfiles = grep { /^$BLASTDB\..*/ && -f "$DB_DIR/$_" } readdir(DBDIR);
    closedir(DBDIR);

    for my $prevfile (@existingfiles) {
        if (-e $prevfile) {

            rename($prevfile, "$DB_DIR/$prevfile") or 
                die("Could not rename file $FTPDOWNLOADDIR/$prevfile -> $DB_DIR/$prevfile: $!");
        } else {
            # here is the file is in production but no longer exists in the download from NIH
            unlink("$DB_DIR/$prevfile") or die("Could not remove file $DB_DIR/$prevfile: $!");
        }
    }

    opendir(DOWNLOADDIR, '.') or die("Could not opendir $FTPDOWNLOADDIR: $!");
    my @newfiles = grep { /^$BLASTDB\..*/ && -f "$_" } readdir(DOWNLOADDIR);
    close(DOWNLOADDIR);

    for my $filenew (@newfiles) {
        rename($filenew, "$DB_DIR/$filenew") or 
            die("Could not rename file $FTPDOWNLOADDIR/$filenew -> $DB_DIR/$filenew: $!");
    }

}

sub getargs() {
	my $HELP;

	Getopt::Long::Configure("bundling");
	GetOptions(
		'h'                 =>		\$HELP,
		'v'                 =>		\$VERBOSE,
		'dbdir=s'           =>      \$DB_DIR);

	die($USAGE) if ($HELP) or (!$DB_DIR) or (@ARGV != 1) or ($Getopt::Long::error);
	$BLASTDB = shift(@ARGV);
}

### MAIN PROGRAM BEGINS HERE ###

$USAGE = <<USAGE;

Usage: $progname [-hv] <--dbdir dir> <db>

-h                             	Print this usage message.
-v                             	Verbose mode.

--dbdir dir                     Directory where the database files will be downloaded
                                into and will reside. 
                                (example: /ibm_local/blastdb/htgs, /prodinfo/proddata_htgsblastdb)

db                            	blastdb names (example: htgs, nt).

USAGE

###############################################################################
# Main program start here:
# Connect to NIH's ftp server. cd to their blast db directory .
# get nt and htgs fils into our <directory>. Quit the ftp session.
# log file are saved to the $FTPDOWNLOADDIR.
###############################################################################

getargs();

$ENV{'PATH'} = '/usr/bin:/util/bin:/bin';

my $date = localtime();

print("db dir = $DB_DIR\n") if ($VERBOSE);

$FTPDOWNLOADDIR = $DB_DIR . '/ftpdownload';
print("ftpdownload dir = $FTPDOWNLOADDIR\n") if ($VERBOSE);

# check if dir exist, if not die
if (! -d $DB_DIR . '/.') {
   die("file system $DB_DIR does not exist, please contact system for help: $!");	
}

# check if dir exist, if not creat one
if (! -d $FTPDOWNLOADDIR . '/.') {
    print("mkdir $FTPDOWNLOADDIR\n") if ($VERBOSE);
	if (system("mkdir $FTPDOWNLOADDIR")) {
        die("mkdir error for $FTPDOWNLOADDIR: $!");
    }
}

chdir($FTPDOWNLOADDIR) or die("Could not chdir($FTPDOWNLOADDIR): $!");

print("blastdb = $BLASTDB\n") if ($VERBOSE);
print("Start downloading blast files on $date\n") if ($VERBOSE);

#ftp get all tar.gz files
ftpGetMyFiles();
my $end_date = localtime();
print("Succesfully downloaded blast files on $end_date\n") if ($VERBOSE);
exit(0);
