#!/usr/bin/env perl

my $broad_rules = "$ENV{'HOME'}/irods/rules/broad.irb";
my $core_rules = "$ENV{'HOME'}/irods/rules/core.irb";
my $icathost = 'irods01.broadinstitute.org';
my $hostname;
my @hostlist;

open(HOSTLIST, "iquest 'select RESC_LOC'|")
	|| die "Can't run iquest: $!\n";
while (<HOSTLIST>) {
	next if !/^RESC_LOC/;
	($d, $d, $hostname) = split;
	next if $hostname =~ /localhost/;
	print "Pushing configuration to host $hostname ...\n";
	system "ssh $hostname cp $broad_rules /opt/iRODS/server/config/reConfigs";
	system "ssh $hostname cp $core_rules /opt/iRODS/server/config/reConfigs";
}
close(HOSTLIST);

print "Restarting the ICAT-enabled iRODS server $icathost ...\n";
system "ssh $icathost /opt/iRODS/irodsctl irestart";

exit 0;

