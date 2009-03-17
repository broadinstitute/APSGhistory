Test: simpleA.t
Check operation of dk_alias
Prepending: T (ok)
** alias definition for myls:
alias myls='ls -CF'
** alias definition for myecho++:
** alias definition for a2:
alias a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for +++:
alias +++='pushd'
** alias definition for ---:
alias ---='popd'

----------------------------------------------

Prepending: U (ok)
** alias definition for myls:
alias myls='ls -lF'
** alias definition for myecho++:
** alias definition for a2:
alias a2='test "$foo" = "xx" && echo "foo is xx" || echo "foo is not xx"'
** alias definition for +++:
alias +++='ppushd'
** alias definition for ---:
alias ---='ppopd'
** alias definition for _dk_sal_myls:
alias _dk_sal_myls='ls -CF'
** alias definition for _dk_sal_myecho++:
** alias definition for _dk_sal_a2:
alias _dk_sal_a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for _dk_sal_+++:
alias _dk_sal_+++='pushd'
** alias definition for _dk_sal_---:
alias _dk_sal_---='popd'

----------------------------------------------

Dropping: U (ok)
** alias definition for myls:
alias myls='ls -CF'
** alias definition for myecho++:
** alias definition for a2:
alias a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for +++:
alias +++='pushd'
** alias definition for ---:
alias ---='popd'

----------------------------------------------

Dropping: T (ok)
###
