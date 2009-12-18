#!/util/bin/perl -w

my $STATDIR = "/sysman/scratch/matter/sandbox/fsstats/stats";

opendir DP, "$STATDIR" or die "could not read $STATDIR: $!";
my @csv = grep /[1-9]\.csv/, readdir DP;
closedir DP;

open OUT, ">$STATDIR/0.csv" or die "could not create 0.csv: $!";

my $atime = 0;
my (%cnt, $valcnt);
my ($user, $type);
for my $f (@csv) {
  open FP, "$STATDIR/$f" or die "could not read $f: $!";
  $user = 'all';
  while (<FP>) {
    chomp;
    /^histogram/ and do {
      $type = $_;
      next;
    };
    /stats for user (\d+)/ and do {
      $user = $1;
      next;
    };
    /^\d/ and do {
      my @f = split /,/;
      $cnt{$user}{$type}{$f[0]} += $f[2];
      $valcnt{$user}{$type}{$f[0]} += $f[3];
    };
  }
  close FP;
}

for my $type (keys %{$cnt{'all'}}) {
  print OUT "$type\n";
  print OUT "bucket min,bucket max,count,val count\n";
  for my $k (sort {$a<=>$b} keys %{$cnt{'all'}{$type}}) {
    printf OUT "%d,%d,%d,%f\n",$k,$k*2,$cnt{'all'}{$type}{$k},$valcnt{'all'}{$type}{$k};
  }
  print OUT "\n";
}

for my $user (keys %cnt) {
  next if $user eq 'all';
  print OUT "-------------------------------------------------------\n";
  print OUT "stats for user $user\n";
  for my $type (keys %{$cnt{$user}}) {
    print OUT "$type\n";
    print OUT "bucket min,bucket max,count,val count\n";
    for my $k (sort {$a<=>$b} keys %{$cnt{$user}{$type}}) {
      printf OUT "%d,%d,%d,%f\n",$k,$k*2,$cnt{$user}{$type}{$k},$valcnt{$user}{$type}{$k};
    }
    print OUT "\n";
  }
}
close OUT;
