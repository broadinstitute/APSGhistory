Test: simpleA.t
Check operation of dk_alias
Prepending: T (ok)
** alias definition for myls:
myls='ls -CF'
** alias definition for myecho++:
** alias definition for a2:
a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for +++:
+++=pushd
(Note: AT&T ksh will have nil output.)
** alias definition for ---:
---=popd
(Note: AT&T ksh will have nil output.)

----------------------------------------------

Prepending: U (ok)
** alias definition for myls:
myls='ls -lF'
** alias definition for myecho++:
** alias definition for a2:
a2='test "$foo" = "xx" && echo "foo is xx" || echo "foo is not xx"'
** alias definition for +++:
+++=ppushd
(Note: AT&T ksh will have nil output.)
** alias definition for ---:
---=ppopd
(Note: AT&T ksh will have nil output.)
** alias definition for _dk_sal_myls:
_dk_sal_myls='ls -CF'
** alias definition for _dk_sal_myecho++:
** alias definition for _dk_sal_a2:
_dk_sal_a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for _dk_sal_+++:
_dk_sal_+++=pushd
(Note: AT&T ksh output will be _dk_sal_+++=''.)
** alias definition for _dk_sal_---:
_dk_sal_---=popd
(Note: AT&T ksh output will be _dk_sal_---=''.)

----------------------------------------------

Dropping: U (ok)
** alias definition for myls:
myls='ls -CF'
** alias definition for myecho++:
** alias definition for a2:
a2='test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"'
** alias definition for +++:
+++=pushd
(Note: AT&T ksh output is nil for this case.)
** alias definition for ---:
---=popd
(Note: AT&T ksh output is nil for this case.)

----------------------------------------------

Dropping: T (ok)
###
