#!/usr/bin/env perl

chomp($port = `cat /var/run/aspera/asperacentral.port`);

@ASCP = (qw(ascp -i /opt/aspera/connect/etc/asperaweb_id_dsa.putty -M), $port, qw(-k3 -l10G -T));

$SOURCE      = shift @ARGV;
$DESTINATION = shift @ARGV;

%TARGET = ();

for (@ARGV) {
    die $_ unless m!^(.+)/([^/]+)$!;
    $TARGET{$1} ||= [];
    push @{$TARGET{$1}}, $2;
#    print "$1 -> (", (join ", ", @{$TARGET{$1}}), ")\n";
}

for $dir (sort keys %TARGET) {

    system "mkdir", "-p", "$DESTINATION/$dir" and die "$! creating $DESTINATION/$dir\n";

    if (system @ASCP, (map { "$SOURCE/$dir/$_" } @{$TARGET{$dir}}), "$DESTINATION/$dir" and $fail_count < 3) { # copy failed; exponential backoff for 3 iterations

	$fail_count++;
	warn "$dir/$_ copy failed:  $!\n";
#	my $t = 1<<$fail_count;
#	warn "retrying in $t minutes (attempt $fail_count)\n";
#	sleep 60*$t;
#	redo;

    } else { $fail_count = 0 }

}

