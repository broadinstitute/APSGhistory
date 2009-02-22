Test: simple5.t
J++ should note internal changes
Prepending: J++
Entering J++.dk
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/foo/bar:/bin:/usr/bin
Leaving J++.dk
 (ok)
Added:
           X=XYZ
Changed:
   _dk_inuse=J++.0
 (old value)=
Wordlist variables altered:
  Added to: PATH
           1=/foo/bar

Now unuse J++
Dropping: J++
Entering J++.dk
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/foo/bar:/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/bin:/usr/bin
Leaving J++.dk
 (ok)
Removed:
           X=XYZ
Changed:
   _dk_inuse=
 (old value)=J++.0
Wordlist variables altered:
  Removed from: PATH
           1=/foo/bar

Use J++ again
Prepending: J++
Entering J++.dk
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/foo/bar:/bin:/usr/bin
Leaving J++.dk
 (ok)
Added:
           X=XYZ
Changed:
   _dk_inuse=J++.0
 (old value)=
Wordlist variables altered:
  Added to: PATH
           1=/foo/bar

And again
Prepending: J++
Entering J++.dk
1: dk_setenv should set X=XYZ, actual is X=XYZ
2: Start PATH=/foo/bar:/bin:/usr/bin
2: dk_alter should add/remove /foo/bar to PATH, actual is PATH=/foo/bar:/foo/bar:/bin:/usr/bin
Leaving J++.dk
 (ok)
Added:
   _dk_sev_X=XYZ
Wordlist variables altered:
  Added to: PATH
           1=/foo/bar
At the end, PATH should have doubled /foo/bar, because dk_alter
is not idempotent.  However, _dk_inuse should not change after
the second use.
###
