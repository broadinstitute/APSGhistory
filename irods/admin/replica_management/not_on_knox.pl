#!/usr/bin/env perl

use strict;
use warnings;

# process the input
while (<STDIN>) {
  chomp;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my $on_knox = 0;
  foreach (split(',', $resources)) {
    $on_knox = 1 if m/^knox/;
  }
  print "$_\n" if not $on_knox;
}

exit(0);
