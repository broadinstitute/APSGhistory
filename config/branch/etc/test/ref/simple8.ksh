Test: simple8.t
Check operation of dk_setdef, _dk_pream
#################################################
foo starts out nil
Use S
Prepending: S (ok)
Added:
           X=b:a
Changed:
   _dk_inuse=S.0
 (old value)=
         foo=BAR
 (old value)=
Unuse S
Dropping: S (ok)
Removed:
         foo=BAR
Changed:
   _dk_inuse=
 (old value)=S.0
Wordlist variables altered:
  Removed from: X
           1=b
           2=a
#################################################
foo starts out XXXXX
Use S
Prepending: S (ok)
Changed:
   _dk_inuse=S.0
 (old value)=
Wordlist variables altered:
  Added to: X
           1=b
           2=a
Unuse S
Dropping: S (ok)
Changed:
   _dk_inuse=
 (old value)=S.0
Wordlist variables altered:
  Removed from: X
           1=b
           2=a
#################################################
foo starts out XXXXX, should be just the same as previous section
Use S
Appending: S (ok)
Changed:
   _dk_inuse=S.0
 (old value)=
Wordlist variables altered:
  Added to: X
           1=b
           2=a
Unuse S
Dropping: S (ok)
Changed:
   _dk_inuse=
 (old value)=S.0
Wordlist variables altered:
  Removed from: X
           1=b
           2=a
###
