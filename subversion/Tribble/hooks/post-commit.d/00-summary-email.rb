#!/bin/bash

REPOS="$1"
REV="$2"

/broad/svn/svn/tools/hook-scripts/commit-email.pl "$REPOS" "$REV" --from svn@broadinstitute.org -s "SVN: " tribble_svn_list@broadinstitute.org
