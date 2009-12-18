#!/util/bin/perl -w

use POSIX qw(log10);

my %data;
my $imax = 0;
while (<STDIN>) {
  chomp;
  my @f = split /,/;
  my ($mo,$yr);
  ($mo, $yr) = (localtime($f[10]))[4,5];
  $yr += 1900;
  $mo += 1;
  my $yrmo = sprintf "%d%02d",$yr,$mo;
  my $size = $f[7];
  $size = int log10($size);
  $imax = $size > $imax ? $size : $imax;
  $data{$yrmo}[$size]++;
#  print "Here: $size, $f[10] $yrmo\n";
}

for my $k (sort keys %data) {
  print "$k";
  for my $i (0..$imax) {
    if (defined $data{$k}[$i]) {
      print ",$data{$k}[$i]";
    } else {
      print ",0";
    }
  }
  print "\n";
}
