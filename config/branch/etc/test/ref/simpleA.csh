Test: simpleA.t
Check operation of dk_alias
Prepending: T (ok)
** alias definition for myls:
ls -CF
** alias definition for myecho++:
cd /usr/!:1 ; echo "in cwd=$cwd"; /bin/ls -1
** alias definition for a2:
test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"
** alias definition for +++:
pushd
** alias definition for ---:
popd

----------------------------------------------

Prepending: U (ok)
** alias definition for myls:
ls -lF
** alias definition for myecho++:
cd /usr/local/!:1 ; echo "in PWD=$cwd"; /bin/ls -1
** alias definition for a2:
test "$foo" = "xx" && echo "foo is xx" || echo "foo is not xx"
** alias definition for +++:
ppushd
** alias definition for ---:
ppopd
** alias definition for _dk_sal_myls:
ls -CF
** alias definition for _dk_sal_myecho++:
cd /usr/!:1 ; echo "in cwd=$cwd"; /bin/ls -1
** alias definition for _dk_sal_a2:
test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"
** alias definition for _dk_sal_+++:
pushd
** alias definition for _dk_sal_---:
popd

----------------------------------------------

Dropping: U (ok)
** alias definition for myls:
ls -CF
** alias definition for myecho++:
cd /usr/!:1 ; echo "in cwd=$cwd"; /bin/ls -1
** alias definition for a2:
test "$foo" = "XX" && echo "foo is XX" || echo "foo is not XX"
** alias definition for +++:
pushd
** alias definition for ---:
popd

----------------------------------------------

Dropping: T (ok)
###
