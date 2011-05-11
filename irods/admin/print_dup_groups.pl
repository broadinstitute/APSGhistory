#!/usr/bin/perl

my %nis_groups_by_name = ();
my %nis_groups_by_gid = ();
my %dup_gid = ();
my %group_list = ();
my ($group, $pw, $gid, $members);
open(YPCAT, "ypcat group|") or die "Can't run ypcat: $!\n";
while (<YPCAT>) {
  chomp;
  ($group, $pw, $gid, $members) = split /:/;
   $nis_groups_by_gid{$gid} = $group;
   $nis_groups_by_name{$group} = $members;
   if (exists $group_list{$gid}) {
     $dup_gid{$gid} = 1;
   }
   if ($dup_gid{$gid}) {
     $group_list{$gid} .= ":$group";
   }
   else {
     $group_list{$gid} = $group;
   }
}
close(YPCAT);

foreach $gid (keys %dup_gid) {
  print "$gid : $group_list{$gid}\n";
}

exit 0;
