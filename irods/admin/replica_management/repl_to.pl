#!/usr/bin/env perl

use strict;
use warnings;

use POSIX;

if ($#ARGV != 0 and $#ARGV != 2) {
  print "Usage: $0 <to_resource> [<trim_from_resource> <num_copies>]\n";
  exit(1);
}

my $to_resc = $ARGV[0];
my $trim_from = '';
my $num_copies = '';
if ($#ARGV == 2) {
  $trim_from = $ARGV[1];
  $num_copies = $ARGV[2];
}

# process the input
while (<STDIN>) {
  chomp;
  next if m/^\s*$/;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my $repl_cmd = "irepl -v -M -B -R $to_resc \"$fname\"";
  my $ts = strftime "%F %T", localtime $^T;
  print "$ts: ", $repl_cmd, "\n";
  my $rc = system $repl_cmd;
  if ($rc) {
    print "Could not replicate $fname\n";
  }
  elsif ($trim_from) {
    my $trim_cmd = "itrim -v -M -N $num_copies -S $trim_from \"$fname\"";
    my $ts = strftime "%F %T", localtime $^T;
    print "$ts: ", $trim_cmd, "\n";
    $rc = system $trim_cmd;
    if ($rc) {
      print "Could not trim $fname\n";
    }
  }
  print "------------------------\n";
}

exit(0);
