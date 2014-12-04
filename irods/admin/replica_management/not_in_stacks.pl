#!/usr/bin/env perl

use strict;
use warnings;

# process the input
while (<STDIN>) {
  chomp;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my $in_stacks = 0;
  foreach (split(',', $resources)) {
    $in_stacks = 1 if m/^stack/;
  }
  print "$_\n" if not $in_stacks;
}

exit(0);
