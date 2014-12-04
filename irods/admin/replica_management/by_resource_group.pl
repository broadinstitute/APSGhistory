#!/usr/bin/env perl

use strict;
use warnings;

my %rgroups = ();

# prime with list of resources
open(Q, "iquest --no-page '%s' \"select RESC_NAME\" |")
  or die "can't run iquest: $1";
while (<Q>) {
  chomp;
  $rgroups{$_} = $_;
}
close(Q);

# map a resource to it's resource group name
open(Q, "iquest --no-page '%s:%s' \"select RESC_NAME, RESC_GROUP_NAME\" |")
  or die "can't run iquest: $1";
while (<Q>) {
  chomp;
  my ($resc, $grp) = split(':');
  $rgroups{$resc} = $grp;
}
close(Q);

# process the input
while (<STDIN>) {
  chomp;
  my ($resources, $fname) = split(/\s+/, $_, 2);
  my @reslist = split(',', $resources);
  my %num_in_res = ();
  foreach (split(',', $resources)) {
    my $resc = $_;
    $resc =~ s/:.*$//;
    $num_in_res{$rgroups{$resc}} = 0 
      if not exists($num_in_res{$rgroups{$resc}});
    $num_in_res{$rgroups{$resc}}++;
  }
  my @grplist = ();
  foreach (sort keys %num_in_res) {
    push(@grplist, "$_:$num_in_res{$_}");
  }
  print join(',', @grplist) . " $fname\n";
}

exit(0);
