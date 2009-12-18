#!/util/bin/perl -w

open FP, "fsids.csv" or die "could not open fsids.csv";
my %fsids;
while (<FP>) {
  chomp;
  $fsids{$_} = $_
}

my $STATDIR = "/broad/hptmp/matter/wgas_20090423";

my $cmd = "find $STATDIR/ -mindepth 1 -maxdepth 1 -type d -not -name '.' -not -name '.snapshot'";
open FH, "$cmd |" or die "could not run find: $!";
my @fs;
while (<FH>) {
  chomp;
  push @fs, $_;
}
close FH;

open OUT, ">$STATDIR/0.csv" or die "could not create 0.csv: $!";

my ($fsid, $dirid);
my $atime = 0;
my %cnt = ();
my $valcnt = undef;
my ($user, $type);
for my $dir (@fs) {
  ($fsid = $dir) =~ s,.*/,,;
  next unless defined $fsids{$fsid};
  open FP, "$dir/${fsid}.csv" or do {
    warn "could not open $dir/${fsid}.csv: $!";
    next;
  };
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
