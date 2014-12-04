#!/usr/bin/env perl

use strict;
use File::Basename;

my $resc_name = 'amplistor';

my $imeta_cmd = 'imeta qu -d';
$imeta_cmd .= ' broadReplicationState = pending'; # not replicated yet
$imeta_cmd .= " and broadReplicationDestination = $resc_name";

open(IMETA, "$imeta_cmd |")
    or die "Error running '$imeta_cmd': $!";
my $fname = "";
while(<IMETA>) {
    chomp;
    if (m/^----$/) {
	my $owner = get_owner($fname);
	remove_meta($fname, $owner, 'broadReplicationState', 'pending');
	add_meta($fname, $owner, 'broadReplicationState', 'replicating');
	if (replicate_file($fname, $resc_name)) {
	    remove_meta($fname, $owner, 'broadReplicationState', 'replicating');
	    add_meta($fname, $owner, 'broadReplicationState', 'failed');
	}
	else {
	    remove_meta($fname, $owner, 
			'broadReplicationState', 'replicating');
	    remove_meta($fname, $owner,
			'broadReplicationDestination', $resc_name);
	}
	$fname = "";
	next;
    }
    elsif (m/^collection: (.*)$/) {
	$fname = $1;
    }
    elsif (m/^dataObj: (.*)$/) {
	$fname .= "/" . $1;
    }
}
close(IMETA);

exit(0);


sub replicate_file {
    my $fname = shift;
    my $resource = shift;

    my $irepl_cmd = "irepl -v -M -B -R $resource $fname";
    my $rc = system "$irepl_cmd";

    return $rc;
}


sub get_owner {
    my $fname = shift;

    my ($name, $path, $suffix) = fileparse($fname);
    $path =~ s|/$||;
    
    my $owner_q = 'iquest "%s" "select DATA_OWNER_NAME where ';
    $owner_q .= "DATA_NAME = '$name' and COLL_NAME = '$path'\"";

    my $owner = `$owner_q`;
    chomp($owner);

    return $owner;
}


sub add_meta {
    my $fname = shift;
    my $owner = shift;
    my $attrname = shift;
    my $attrvalue = shift;

    $ENV{clientUserName} = $owner;
    my $rc = system "imeta add -d $fname $attrname $attrvalue";
    delete $ENV{clientUserName};

    return $rc;
}


sub remove_meta {
    my $fname = shift;
    my $owner = shift;
    my $attrname = shift;
    my $attrvalue = shift;

    $ENV{clientUserName} = $owner;
    my $rc = system "imeta rm -d $fname $attrname $attrvalue";
    delete $ENV{clientUserName};

    return $rc;
}
