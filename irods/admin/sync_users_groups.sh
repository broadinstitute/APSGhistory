#!/bin/bash

eval `/broad/software/dotkit/init -b`
use -q default
use -q irods

script_dir=`dirname $0`
PERL5LIB=$script_dir
export PERL5LIB

$script_dir/sync_users_groups.pl

