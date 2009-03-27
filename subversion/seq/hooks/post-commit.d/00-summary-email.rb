#!/bin/bash

# summarize commits of tests

/broad/tools/scripts/svn-summary-email.rb "$@" 'test|selenium' '"Susan McDonough" <smcdonou@broad.mit.edu>'

# (per RT #147945) summarize commits of files controlling inclusion of
# third-party objects

/broad/tools/scripts/svn-summary-email.rb "$@" '^main/sequence/.*/(profiles|pom).xml$' releng@broad.mit.edu
