#!/bin/sh

script_dir=`dirname $0`
PERL5LIB=$script_dir
export PERL5LIB

$script_dir/sync_users_groups.pl

