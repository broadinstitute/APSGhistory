#!/bin/sh

ARCHIVE_DAYS=30
DELETE_DAYS=90

set -e

cd /imaging/dropbox

find . -mindepth 1 -maxdepth 1 -name 'ToBeDeleted.*' -print0 |
	/util/bin/ruby -rtime -0 -ne 'print if $_ =~ %r{^\./(ToBeDeleted\.(\d+-\d+-\d+))\0$} and Time.parse($2) <= Time.parse("today")' |
		xargs -0 rm -rf

DELETION_DATE=`date -I --date "today +$DELETE_DAYS days"`
ARCHIVE_DIR=ToBeDeleted.$DELETION_DATE

mkdir -p $ARCHIVE_DIR
find . -mindepth 1 -maxdepth 1 -mtime +$ARCHIVE_DAYS -print0 | xargs -0i mv {} $ARCHIVE_DIR
