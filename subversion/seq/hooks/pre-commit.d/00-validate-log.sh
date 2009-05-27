#!/bin/bash

# For testing, we want this to work on revisions as well as
# transactions, so infer which it is that we're looking at.

T=${2//[0-9]}
T=${T:+-t}
T=${T:--r}

# ignore commits not touching main, branches, or tags

/util/bin/svnlook dirs-changed $T $2 $1 | /usr/bin/egrep -q '^(main|branches|tags)(/|$)' || exit 0

# ensure that a JIRA issue number is present

/util/bin/svnlook log $T $2 $1 | /usr/bin/egrep -q '\b[A-Z]{3}-[0-9]+\b' && exit 0

/bin/cat 1>&2 <<EOF
Please include in the commit message a reference to the appropriate 
Jira issues, for example "SQU-999" or "FIN-1234".
EOF

exit 1

