#!/usr/bin/env perl

use strict;
use warnings;

use POSIX;

if ($#ARGV != 1) {
  print "Usage: $0 <trim_from_resource> <num_copies>\n";
  exit(1);
}

my $trim_from = $ARGV[0];
my $num_copies = $ARGV[1];

# process the input
while (<STDIN>) {
  chomp;
  next if m/^\s*$/;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my $trim_cmd = "itrim -v -M -N $num_copies -S $trim_from \"$fname\"";
  my $ts = strftime "%F %T", localtime $^T;
  print "$ts: ", $trim_cmd, "\n";
  my $rc = system $trim_cmd;
  if ($rc) {
    print "Could not trim $fname\n";
  }
  print "------------------------\n";
}

exit(0);
