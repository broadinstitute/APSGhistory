#!/bin/sh

ARCHIVE_DAYS=30
DELETE_DAYS=90

set -e

cd /imaging/dropbox

find ToBeDeleted -mindepth 1 -maxdepth 1 -print0 |
	/util/bin/ruby -rtime -0 -ne 'print if $_ =~ %r{^ToBeDeleted/(\d+-\d+-\d+)\0$} and Time.parse($1) <= Time.parse("today")' |
		xargs -0t --no-run-if-empty rm -rf

DELETION_DATE=`date -I --date "today +$DELETE_DAYS days"`
ARCHIVE_DIR=ToBeDeleted/$DELETION_DATE

mkdir -p $ARCHIVE_DIR
find . -mindepth 1 -maxdepth 1 \( -not -name ToBeDeleted \) -mtime +$ARCHIVE_DAYS -print0 |
    xargs -0t -I {} --no-run-if-empty mv {} $ARCHIVE_DIR
