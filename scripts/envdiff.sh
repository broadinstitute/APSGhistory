#!/bin/bash -x

# Take the output of "env" from two contexts and compare them with
# "diff", after doing some preprocessing to make differences in path
# variables easier to interpret.

expand_paths() {
    perl -pe 's/^([^=]+)=(.*?:.*?)\s*$/join "", map { "$1 $_\n" } split ":", $2/e' $*
}

diff -U0 <(sort $1 | expand_paths) <(sort $2 | expand_paths) | grep '^[-+][^-+]'
