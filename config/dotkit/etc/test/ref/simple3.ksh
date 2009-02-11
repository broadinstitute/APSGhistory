Test: simple3.t
Test eval inside a dotkit, and some common quoting needs

1: Starting values A=AAA, B=BBB, C=E, D=PATH, E=EEE
Prepending: H
2: dk_setenv should set X=XYZ, actual is X=XYZ
3: Start PATH=/bin:/usr/bin
3: dk_alter should add/remove BBB to PATH
3: actual new PATH=BBB:/bin:/usr/bin
4: eval dk_setenv should set E to AAA, actual is E=AAA
5: dk_setenv should set FOO to AAA, actual is FOO=AAA
6: Start PATH=BBB:/bin:/usr/bin
6: eval dk_alter should add/remove E to PATH, actual is PATH=E:BBB:/bin:/usr/bin
 (ok)
Added:
         FOO=AAA
           X=XYZ
   _dk_sev_E=EEE
Changed:
           E=AAA
 (old value)=EEE
   _dk_inuse=H.0
 (old value)=
Wordlist variables altered:
  Added to: PATH
           1=E
           2=BBB

Now unuse H
Dropping: H
2: dk_setenv should set X=XYZ, actual is X=XYZ
3: Start PATH=E:BBB:/bin:/usr/bin
3: dk_alter should add/remove BBB to PATH
3: actual new PATH=E:/bin:/usr/bin
4: eval dk_setenv should set E to AAA, actual is E=AAA
5: dk_setenv should set FOO to AAA, actual is FOO=AAA
6: Start PATH=E:/bin:/usr/bin
6: eval dk_alter should add/remove E to PATH, actual is PATH=/bin:/usr/bin
 (ok)
Removed:
         FOO=AAA
           X=XYZ
   _dk_sev_E=EEE
Changed:
           E=EEE
 (old value)=AAA
   _dk_inuse=
 (old value)=H.0
Wordlist variables altered:
  Removed from: PATH
           1=E
           2=BBB
###
