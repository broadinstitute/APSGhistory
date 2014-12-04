#!/usr/bin/env perl

my $coll_name = '/broad/attic';

$coll_name = $ARGV[0] if $#ARGV == 0;
$coll_name =~ s/\/$//;

my %filelist = ();

my $qcmd = "iquest --no-page";
my $sep = '=:=:=';
my $format = "%s/%s$sep%s$sep%s";
my $query = "\"select COLL_NAME, DATA_NAME, DATA_REPL_NUM, DATA_RESC_NAME";
$query .= " where COLL_NAME like '$coll_name/%'\"";

open(QUERY, "$qcmd $format $query|")
  or die "Error running iquest: $!";
while (<QUERY>) {
  chomp;
  my ($fname, $repl_num, $resource) = split($sep);

  $filelist{$fname} = [] if not exists $filelist{$fname};
  push(@{$filelist{$fname}}, $resource.':'.$repl_num);
}
close(QUERY);

foreach my $fname (keys %filelist) {
  # counting
  my %in_resource = ();
  my $total_repls = 0;
  foreach (@{$filelist{$fname}}) {
    my $resc = $_;
    $resc =~ s/:.*$//;
    $total_repls++;
    $in_resource{$resc} = 0 if not exists($in_resource{$resc});
    $in_resource{$resc}++;
  }

  print join(',', @{$filelist{$fname}}) . " $fname\n";
}

exit(0);
