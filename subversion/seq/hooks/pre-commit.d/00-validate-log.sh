#!/bin/bash

# ignore commits not touching main/releng

svnlook dirs-changed -t $2 $1 | grep -q '^main/releng' || exit 0

# ensure that a JIRA issue number is present

svnlook log -t $2 $1 | egrep -q '\b[A-Z]{3}-[0-9]+\b' && exit 0

cat 1>&2 <<EOF
Please include in the commit message a reference to the appropriate 
Jira issues, for example "SQU-999" or "FIN-1234".
EOF

exit 1

