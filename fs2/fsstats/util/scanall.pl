#!/util/bin/perl -w

use DBI;
use DBD::mysql;

my $DEBUG=1;

##
## Get list of filesystems to look at
##
my @maps;
my $cmd = "ypcat auto.master | awk '{print \$1}'";
open(CMD, "$cmd |") or die "Unable to run $cmd: $!\n";
while (<CMD>) {
	chomp;
	push @maps, $_
}

for my $map (@maps) {
  $cmd = "ypcat -k $map | awk '{print \$1}'";
  ($dir = $map) =~ s/auto\.//;
  open(CMD, "$cmd |") or die "Unable to run $cmd: $!\n";
  while (<CMD>) {
	chomp;
	push @filesys, "/$dir/$_";
  }
}

for my $fs (@filesys) {
  my $cmd = "/home/radon00/matter/sandbox/fsstats/scanfs.pl -v --force-update -f $fs";
  print STDERR "$cmd\n" if $DEBUG;
  print `$cmd`;
}

