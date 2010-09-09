#!/bin/bash

# NAME
#
#  analyze_filesystem.sh - A distributed hylomorphism over filesystems.
#
# SYNOPSIS
#
#  analyze_filesystem.sh 'printf string' summarizer combiner forker timeout 'find arguments' [path ...]
#
# DESCRIPTION
#
# Iterate over the supplied paths with the supplied find arguments.
# For each file found (grouped by directory with -execdir)
#
# (1) test if the timeout has expired;  if it has, print and prune
# (2) run the forker;  if it returns true, a parallel job has been forked to analyze this subtree, so prune but don't print
# (3) for files that have passed both of these tests (both return false), feed the printf string to the summary script
#
# EXAMPLES
#
#   analyze_filesystem.sh "%p" cat cat false inf 'find arguments' paths
#
# should behave just like plain "find" except for the paths coming
# last and the logic being quoted.
#
#   analyze_filesystem.sh "%k\n" sum cat false inf '' paths
#
# (where sum is something like perl -0ne '$t += $_; END { print $t }')
# should work very much like du -s.
#
# Replacing "inf" with a timeout should result in the same operation
# proceeding until the timeout expires, then printing a list of
# filenames it didn't have time to examine.
#
# The forker is a hook to dispatch a subjob, e.g., with bsub.  The
# output of subjobs and of the summarizer will be passed to the
# combiner.

set -e

printf=$1
summarize=$2
combine=$3
fork=$4
timeout=$5
find_args=$6

shift 6 || (echo Too few arguments.  Read $0 for usage information.; exit)

args="$printf $summarize $combine $fork $timeout '$find_args'"

tmpdir=`mktemp -dt analyze_filesystem.XXXXXXXX`

ln -s /bin/false $tmpdir/timeToStop

(sleep $timeout && ln -sf /bin/true $tmpdir/timeToStop) &
sleeper=$!

set +e

find "$@" $find_args \( -execdir $tmpdir/timeToStop \; -print -prune \) -o \( -execdir $fork $0 $args '{}' \; -prune \) -o -fprintf >($summarize) "$printf" | $combine

set -e

disown -a
kill $sleeper
rm -rf $tmpdir
