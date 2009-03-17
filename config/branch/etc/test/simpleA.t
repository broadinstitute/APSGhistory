echo "Check operation of dk_alias"

# Get correct Solaris grep.
setenv PATH "/usr/xpg4/bin:$PATH"

# AT&T ksh has a bug.  Although it can define an alias such as
# alias ---=popd, it cannot print the value for it.  This difference
# is noted in several of the tests below.

setenv _dk_mm ""
dk_test "$_dk_shell" = bash -o "$_dk_shell" = ksh && setenv _dk_mm "--"

use T
echo "** alias definition for myls:"
alias | grep myls > /dev/null && alias myls

echo "** alias definition for myecho++:"
alias | grep myecho++ > /dev/null && alias myecho++

echo "** alias definition for a2:"
alias | grep a2 > /dev/null && alias a2

echo "** alias definition for +++:"
alias | grep -e '+++' > /dev/null && alias $_dk_mm +++
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh will have nil output.)"

echo "** alias definition for ---:"
alias | grep -e '---' > /dev/null && alias $_dk_mm ---
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh will have nil output.)"

echo ""
echo "----------------------------------------------"
echo ""

use U
echo "** alias definition for myls:"
alias | grep myls > /dev/null && alias myls

echo "** alias definition for myecho++:"
alias | grep myecho++ > /dev/null && alias myecho++

echo "** alias definition for a2:"
alias | grep a2 > /dev/null && alias a2

echo "** alias definition for +++:"
alias | grep -e '+++' > /dev/null && alias $_dk_mm +++
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh will have nil output.)"

echo "** alias definition for ---:"
alias | grep -e '---' > /dev/null && alias $_dk_mm ---
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh will have nil output.)"

echo "** alias definition for _dk_sal_myls:"
alias | grep _dk_sal_myls > /dev/null && alias _dk_sal_myls

echo "** alias definition for _dk_sal_myecho++:"
alias | grep _dk_sal_myecho++ > /dev/null && alias _dk_sal_myecho++

echo "** alias definition for _dk_sal_a2:"
alias | grep _dk_sal_a2 > /dev/null && alias _dk_sal_a2

echo "** alias definition for _dk_sal_+++:"
alias | grep '_dk_sal_+++' > /dev/null && alias _dk_sal_+++
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh output will be _dk_sal_+++=''.)"

echo "** alias definition for _dk_sal_---:"
alias | grep '_dk_sal_---' > /dev/null && alias _dk_sal_---
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh output will be _dk_sal_---=''.)"

echo ""
echo "----------------------------------------------"
echo ""

unuse U
echo "** alias definition for myls:"
alias | grep myls > /dev/null && alias myls

echo "** alias definition for myecho++:"
alias | grep myecho++ > /dev/null && alias myecho++

echo "** alias definition for a2:"
alias | grep a2 > /dev/null && alias a2

echo "** alias definition for +++:"
alias | grep -e '+++' > /dev/null && alias $_dk_mm +++
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh output is nil for this case.)"

echo "** alias definition for ---:"
alias | grep -e '---' > /dev/null && alias $_dk_mm ---
dk_test "$_dk_shell" = ksh && echo "(Note: AT&T ksh output is nil for this case.)"

alias | grep _dk_sal_myls > /dev/null && echo "ERROR: alias for _dk_sal_myls should be gone."

alias | grep _dk_sal_myecho++ > /dev/null && echo "ERROR: alias for _dk_sal_myecho++ should be gone."

alias | grep _dk_sal_a2 > /dev/null && echo "ERROR: alias for _dk_sal_a2 should be gone."

alias | grep _dk_sal_+++ > /dev/null && echo "ERROR: alias for _dk_sal_+++ should be gone."

alias | grep _dk_sal_--- > /dev/null && echo "ERROR: alias for _dk_sal_--- should be gone."

echo ""
echo "----------------------------------------------"
echo ""

unuse T
alias | grep myls >/dev/null && echo "ERROR: alias for myls should be gone."

alias | grep myecho++ >/dev/null && echo "ERROR: alias for myecho++ should be gone."

alias | grep a2 >/dev/null && echo "ERROR: alias for a2 should be gone."

alias | grep -e '+++' > /dev/null && echo "ERROR: alias for +++ should be gone."

alias | grep -e '---' > /dev/null && echo "ERROR: alias for --- should be gone."
