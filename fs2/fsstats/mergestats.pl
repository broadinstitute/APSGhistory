#!/util/bin/perl -w

my $STATDIR = "/broad/hptmp/matter/wgas_20090423";

my $cmd = "find $STATDIR/ -mindepth 1 -maxdepth 1 -type d -not -name '.' -not -name '.snapshot'";
open FH, "$cmd |" or die "could not run find: $!";
my @fs;
while (<FH>) {
  chomp;
  push @fs, $_;
}
close FH;

my ($fsid, $dirid);
$prt=0;
for my $dir (@fs) {
  my $fsid;
  ($fsid = $dir) =~ s,.*/,,;
  opendir DP, "$dir" or die "could not read $dir: $!";
  my @csv = grep /$fsid\.\d+\.csv/, readdir DP;
  closedir DP;
  my $atime = 0;
  my %cnt = ();
  my %valcnt = ();
  my ($user, $type);
  open OUT, ">$dir/${fsid}.csv" or die "could not create ${fsid}.csv: $!";
  print STDERR "processing ${fsid}.csv\n";
  for my $subdir (@csv) {
    ($dirid = $subdir) =~ s,$fsid\.(\d+)\.csv,$1,;
    open FP, "$dir/$subdir" or die "could not read $subdir: $!";
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
        if ($prt and $type=~/capacity/){
          print "Here $f[3]\n";
          $sum += $f[3];
          print "Here sum=$sum\n";
        }
      };
    }
    close FP;
  }
$sum=0;

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
        if ($type =~ /capacity/ and $user==1143) {
          printf "%d,%d,%d,%f\n",$k,$k*2,$cnt{$user}{$type}{$k},$valcnt{$user}{$type}{$k};
          $sum += $valcnt{$user}{$type}{$k};
          print "Here: sum=$sum\n";
        }
      }
      print OUT "\n";
    }
  }
  close OUT;
}
