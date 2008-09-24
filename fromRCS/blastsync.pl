#!/util/bin/perl -w

##
## This is a temporary script (read: hack) to syncronize the nt/ and htgs/
## subdirectories of /ibm_local/blastdb on the specified farm nodes. It
## is intended to be run during the Sunday maintenance window, after Cristyn's
## blastdownload.pl script runs on node124 on Saturday evening.
##
## There is no cleverness to this approach. It simply rsync's from 
## /broad/data/blastdb/{nt,htgs} (which is presently served by radon)
## to the appropriate directories in /ibm_local/blastdb. Lead will
## initiate up to $NFSWIDTH rysncs in parallel via ssh to the target 
## nodes, waiting for the last of these to complete before starting
## another $NFSWIDTH rsyncs. With $NFSWIDTH ~ 8, this at least 15 times
## faster than the sequential rsync approach used by rsync.blastdb.
##
## This approach should be replaced by peer-to-peer copying within
## the farm as soon as we have established a strategy for this.
##
##				matter 10 August 2006
##
use strict;

my @BCHASSIS = qw[ 01 02 03 04 05 06 07 10 13 14 15 17 ];
my @ONEOFFS  = qw[ node243 node244 node245 node246 node247 node248 node249 ];
my @FOUR54   = qw[ node126 node219 node220 node224 ];

my $SYNCWIDTH = 0;
my $NFSWIDTH  = 8;

my $DEBUG = 0;

##
## Only these are allowed at present
##
my %DIRS =  ( 'nt'   => 'ntblastdb',
              'htgs' => 'htgsblastdb');
my $RSYNC  = '/usr/bin/rsync';
my $ARGS   = '-rlptDL -e ssh --delete --exclude="queries/" --exclude="ftpdownload/"'; # Note: no -o or -g flags
my $SRCDIR = '/broad/data/blastdb/';
my $TGTDIR = '/ibm_local/blastdb/';
my $SSH    = '/usr/bin/ssh';

if ($#ARGV or not defined $DIRS{$ARGV[0]}) {
  print STDERR "usage: $0 {nt|htgs}\n";
  exit 1;
}

$SRCDIR .= "$ARGV[0]/";
$TGTDIR .= "$ARGV[0]/";

##
## Validate that download has completed (no files in ftpdownload/ subdir)
##
if (opendir DIR, "${SRCDIR}ftpdownload") {
  my @files = readdir DIR;
  print STDERR "Files present in ${SRCDIR}ftpdownload/. Exiting.\n" and exit if $#files > 1;
} else {
  warn "unable to open ${SRCDIR}ftpdownload: $!";
}
closedir DIR;

my $nfscmd = "$RSYNC $ARGS $SRCDIR $TGTDIR";

my @nodes = ();
my ($node, $rc, $cmd);
my $err_flag = 0;
my %tmp;
my $bpc = 0;
for my $chassis (@BCHASSIS) {
  my @blades = `cat /broad/tools/hostlists/blades$chassis`;
  chomp @blades;
  $bpc = $#blades > $bpc ? $#blades : $bpc;
  for my $b (@blades) {
    push @{$tmp{$chassis}}, $b;
  }
}
for my $b (@ONEOFFS) {
  push @{$tmp{'00'}}, $b;
}
for my $b (@FOUR54) {
  push @{$tmp{'454'}}, $b;
}

##
## Shuffle node list so that simultaneous rsyncs are happening on 
## different chassis.
##
for my $j (0..$bpc) {
  for my $i (keys %tmp) {
    push @nodes, @{$tmp{$i}}[$j] if defined @{$tmp{$i}}[$j];
  }
}

##
## First pass: NFS to $NFSWIDTH-1 nodes + lead
##
my $limit = $#nodes > ($NFSWIDTH - 1) ? ($NFSWIDTH - 1) : ($#nodes);
for my $n (0..$limit-1) {
  $node = shift @nodes;
  $cmd = "$SSH $node \"$nfscmd\" >/dev/null 2>&1 &";
  $DEBUG and print STDERR "Running $cmd\n";
  $rc = system($cmd);
  if ($rc) {
    warn "\"$cmd\" returned $rc";
    $err_flag = 1;
  }
}
##
## Now to lead
##
$cmd = "$nfscmd >/dev/null 2>&1";
$DEBUG and print STDERR "Running $cmd\n";
$rc = system($cmd);
if ($rc) {
  warn "\"$cmd\" returned $rc";
  $err_flag = 1; 
}

##
## Main loop: start $NFSWIDTH NFS copies in background on nodes, and
## $SYNCWIDTH copies on lead
##
while (@nodes) {
  $limit = $#nodes > ($NFSWIDTH - 1) ? ($NFSWIDTH - 1) : ($#nodes);
  for my $n (0..$limit-1) {
    $node = shift @nodes;
    $cmd = "$SSH $node \"$nfscmd\" >/dev/null 2>&1 &";
    $DEBUG and print STDERR "Running $cmd\n";
    $rc = system($cmd);
    if ($rc) {
      warn "\"$cmd\" returned $rc";
      $err_flag = 1; 
    }
  }
  ##
  ## Last of batch is run synchronously
  ##
  $node = shift @nodes;
  $cmd = "$SSH $node \"$nfscmd\" >/dev/null 2>&1";
  $DEBUG and print STDERR "Running $cmd\n";
  $rc = system($cmd);
  if ($rc) {
    warn "\"$cmd\" returned $rc";
    $err_flag = 1; 
  }
  next;
  ##
  ## RSYNC, skipped for now
  ##
  $limit = $#nodes > ($SYNCWIDTH - 1) ? ($SYNCWIDTH - 1) : ($#nodes);
  for my $n (1..$limit-1) {
    $node = shift @nodes;
    my $rsync = "$RSYNC $ARGS $TGTDIR $node:$TGTDIR";
    $cmd = "$rsync >/dev/null 2>&1 &";
    $DEBUG and print STDERR "Running $cmd\n";
    $rc = system($cmd);
    if ($rc) {
      warn "\"$cmd\" returned $rc";
      $err_flag = 1; 
    }
  }
  $node = shift @nodes;
  my $rsync = "$RSYNC $ARGS $TGTDIR $node:$TGTDIR";
  $cmd = "$rsync >/dev/null 2>&1";
  $DEBUG and print STDERR "Running $cmd\n";
  $rc = system($cmd);
  if ($rc) {
    warn "\"$cmd\" returned $rc";
    $err_flag = 1; 
  }
  exit $err_flag;
}
