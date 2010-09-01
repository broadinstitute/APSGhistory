#!/bin/bash

# Take the output of "env" from two contexts and compare them with
# "diff", after doing some preprocessing to make differences in path
# variables and _dk_inuse easier to interpret.  Do a stable sort on
# variable names so that related lines come up next to each other.

expand_paths() {
    perl -pe 's/^([^=]+)=(.*?:.*?)\s*$/join "", map { "$1 $_\n" } split ":", $2/e' $* |
      perl -pe 's/^(_dk_inuse)=(\S+?\s.*?)\s*$/join "", map { "$1 $_\n" } split " ", $2/e'
}

diff -dU0 <(sort $1 | expand_paths) <(sort $2 | expand_paths) | grep '^[-+][^-+]' | sort -sk1.2,1.999
