#!/bin/sh

set -e

LOCAL=`mktemp`
REMOTE=`mktemp`

#curl -s ftp://ftp-trace.ncbi.nih.gov/1000genomes/current.tree | perl -lne 'next if $. == 1; /^(.*)\s(\S+)$/ or exit; ($indent, $name) = ($1, $2); $indent = (length($indent)+1)/4; $delta = $indent - $last_indent - 1; $last_indent = $indent; for (1..(-$delta)) { pop @path; } push @path, $name; printf "%s\n", join "/", @path' | sort > $REMOTE
curl -s ftp://ftp-trace.ncbi.nih.gov/1000genomes/current.tree | perl -lne 'next if $. == 1; /^(.*)\[\s*(\d+)\]\s+(.*\S)\s*$/ or exit; ($indent, $size, $name) = ($1, $2, $3); $indent = length($indent)/4; $delta = $indent - $last_indent - 1; $last_indent = $indent; for (1..(-$delta)) { pop @path; } push @path, $name; printf "%s\n", join "/", @path' | sort > $REMOTE

cd /broad/gold_standard/1000genomes
find * | sort > $LOCAL

cd /tmp
echo 'Files missing locally (will be downloaded):'
echo
diff -U0 $LOCAL $REMOTE | grep '^+[^\+]' || echo '(no files missing)'
echo
echo 'Files missing upstream (please delete or move aside):'
echo
diff -U0 $LOCAL $REMOTE | grep '^-[^\-]' || echo '(no files missing)'

rm $LOCAL $REMOTE
#echo "REMOTE = $REMOTE"
