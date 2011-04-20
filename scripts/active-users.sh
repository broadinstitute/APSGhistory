#!/usr/bin/env bash

ypcat passwd |
perl -F: -lane 'die "bad passwd line: $_" unless @F == 7;
print $F[0] unless $F[6] =~ m!^/usr/bin/yppasswd$! or $F[1] !~ m!^\$1\$!' |
sort
