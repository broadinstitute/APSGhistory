#!/util/bin/perl -w

my $STATDIR = "/sysman/scratch/matter/sandbox/fsstats/stats";

opendir DP, "$STATDIR" or die "could not read $STATDIR: $!";
my @csv = grep /[1-9]\.csv/, readdir DP;
closedir DP;

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

      if ($type =~ /file size/ and $f[0] > 536870912) {
        print "$f: $_\n";
      }
      $cnt{$user}{$type}{$f[0]} += $f[2];
      $valcnt{$user}{$type}{$f[0]} += $f[3];
    };
  }
  close FP;
}

