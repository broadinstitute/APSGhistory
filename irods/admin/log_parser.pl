#!/usr/bin/env perl

%mon2num = qw(
  Jan 1  Feb 2  Mar 3  Apr 4  May 5  Jun 6
  Jul 7  Aug 8  Sep 9  Oct 10 Nov 11 Dec 12
);

%not_open = ();
%connections = ();

while (<>) {
  chomp;
  m/^(\w{3}) (\d+) (\d{2}):(\d{2}):(\d{2}) pid:(\d+) (\w+): (.*)$/;
  $mon = $mon2num{$1};
  $day = $2;
  $h = $3;
  $m = $4;
  $s = $5;
  $pid = $6;
  $level = $7;
  $msg = $8;

  #print "2013/$mon/$day $h:$m:$s $pid $level\n";

  print "$_\n" if /puser=/;

  if ($msg =~ m/Agent process (\d+) started for puser=(\w+) and cuser=(\w+) from ([\d\.]+)$/) {
    $connections{$1} = "$2:$3:$4";
    #print "New connection for $3 from $4\n";
  }
}

exit(0);

