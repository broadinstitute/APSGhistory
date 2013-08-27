#!/usr/bin/env perl

my $size_threshold = 250 * 1024 * 1024 * 1024;
my $max_level = 3;

my $topcoll = '/broad/attic';
if ($#ARGV == 0) {
  $topcoll = $ARGV[0];
}

printf "%-56s:", $topcoll;
my $sq = 'iquest "%s:%s" ';
$sq .= '"select sum(DATA_SIZE), count(DATA_ID)';
$sq .= " where COLL_NAME like '${topcoll}%'";
$sq .= " and DATA_RESC_GROUP_NAME = 'knox'\"";
my $result = `$sq 2>/dev/null`;
chomp $result;
my ($size, $num) = split(':', $result);
printf "%7d %12s\n", $num, size_str($size);

if ($size > $size_threshold) {
  process_collection($topcoll, 1);
}

exit(0);

sub process_collection {
  my $collname = shift;
  my $level = shift;
  my $q = 'iquest --no-page "%s" "select COLL_NAME';
  $q .= " where COLL_PARENT_NAME = '${collname}'\"";
  foreach my $scoll (`$q 2>/dev/null`) {
    chomp $scoll;
    my $s = ' ' x ($level*2);
    $s .= substr($scoll, rindex($scoll, '/') + 1);
    printf "%-56s:", $s;
    my $sq = 'iquest "%s:%s" "select sum(DATA_SIZE), count(DATA_ID)';
    $sq .= " where COLL_NAME like '${scoll}%'";
    $sq .= " and DATA_RESC_GROUP_NAME = 'knox'\"";
    my $result = `$sq 2>/dev/null`;
    chomp $result;
    my ($size, $num) = split(':', $result);
    printf "%7d %12s\n", $num, size_str($size);
    if ($size > $size_threshold and $level < $max_level) {
      process_collection($scoll, $level+1);
    }
  }
}


sub size_str {
  $size = shift;
  $s = $size / (1024.0*1024.0*1024.0);
  return sprintf("%.2f Gb", $s);
}

