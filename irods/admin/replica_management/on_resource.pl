#!/usr/bin/env perl

use strict;
use warnings;

if ($#ARGV != 0) {
  print "Usage: $0 <resource>\n";
    exit(1);
}
my $resc = $ARGV[0];

# process the input
while (<STDIN>) {
  chomp;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my $on_resc = 0;
  foreach (split(',', $resources)) {
    $on_resc = 1 if m/^$resc/;
  }
  print "$_\n" if $on_resc;
}

exit(0);
