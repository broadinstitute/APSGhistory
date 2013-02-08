#!/util/bin/perl -w

opendir DP, "stats" or die "could not read stats directory: $!";

my @csv = grep /\.csv/, readdir DP;

closedir DP;

my %stats;
for my $file (@csv) {
  open FP, "stats/$file" or die "could not read $file: $!";
  while (<FP>) {
    chomp;
    next unless /^stats for user (\d*)/;
    my $user = $1;
    while (<FP>) {
      last if /^bucket/;
    }
    while (<FP>) {
      chomp;
      last if /^$/;
      $stats{$user} += (split /,/,$_)[3]/1000;
    }
  }
}

my $n = 0;
for my $user (sort {$stats{$b} <=> $stats{$a}} keys %stats) {
  my ($name,$pw);
  ($name,$pw) = (getpwuid $user)[0,1];
  $name .= "*" if defined $pw and $pw =~ m/nologin/i;
  $name = "($user)" unless $name;
  printf "%d. $name: %.2f GB\n", ++$n, $stats{$user}/1000;
}
