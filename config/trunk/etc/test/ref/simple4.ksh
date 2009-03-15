Test: simple4.t
Check operation of _dk_err
Prepending: I
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/foo/bar:/bin:/usr/bin
3: dk_setenv should not set X=YYY, actual is X=XYZ
4: dk_alter should not add/remove /foo2/bar to PATH, actual is PATH=/foo/bar:/bin:/usr/bin
This was printed instead of (ok) because of error.
Added:
           X=XYZ
Wordlist variables altered:
  Added to: PATH
           1=/foo/bar

Now unuse I
Dropping: I (not found)
(Should not be found on unuse, because dotkit had internal errors.)
###
