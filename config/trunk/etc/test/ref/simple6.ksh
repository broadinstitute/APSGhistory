Test: simple6.t
Check operation of _dk_hide
Prepending: N
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/foo/bar:/bin:/usr/bin
 (ok)
Added:
           X=XYZ
Wordlist variables altered:
  Added to: PATH
           1=/foo/bar

Now unuse N
Dropping: N (not found)
(Should not be found on unuse, because dotkit was hidden.)
###
