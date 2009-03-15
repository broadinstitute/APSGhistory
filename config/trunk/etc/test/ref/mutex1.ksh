Test: mutex1.t
use F1
Prepending: F1
Starting F1
Dropping: __NIL__ (not found)

Leaving F1: f1=F1 (F1 is correct)
Leaving F1: f2=F1:F3:F2 (F1:F3:F2 is correct, or nil if unuse)
 (ok)
Added:
          f1=F1
          f2=F1:F3:F2
Changed:
   _dk_inuse=F1.0
 (old value)=

Now use F2, which should unuse F1
Prepending: F2
Starting F2
Dropping: F1
Starting F1
Dropping: __NIL__ (not found)

Leaving F1: f1=F1 (F1 is correct)
Leaving F1: f2= (F1:F3:F2 is correct, or nil if unuse)
 (ok)

Leaving F2: f1=F2 (F2 is correct)
Leaving F2: f2=F2:F4:F3 (F2:F4:F3 is correct, or nil if unuse)
 (ok)
Changed:
   _dk_inuse=F2.0
 (old value)=F1.0
          f1=F2
 (old value)=F1
Wordlist variables altered:
  Removed from: f2
           1=F1
           3=F2
  Added to: f2
           1=F2
           2=F4

Now use F3, which should unuse F2
Prepending: F3
Starting F3
Dropping: F2
Starting F2
Dropping: __NIL__ (not found)

Leaving F2: f1=F2 (F2 is correct)
Leaving F2: f2= (F2:F4:F3 is correct, or nil if unuse)
 (ok)

Leaving F3: f1=F3 (F3 is correct)
Leaving F3: f2=F3:F6:F5 (F3:F6:F5 is correct, or nil if unuse)
 (ok)
Changed:
   _dk_inuse=F3.0
 (old value)=F2.0
          f1=F3
 (old value)=F2
Wordlist variables altered:
  Removed from: f2
           1=F2
           2=F4
  Added to: f2
           2=F6
           3=F5

Return to the starting state by unusing F3
Dropping: F3
Starting F3
Dropping: __NIL__ (not found)

Leaving F3: f1=F3 (F3 is correct)
Leaving F3: f2= (F3:F6:F5 is correct, or nil if unuse)
 (ok)
Removed:
          f1=F3
Changed:
   _dk_inuse=
 (old value)=F3.0
Wordlist variables altered:
  Removed from: f2
           1=F3
           2=F6
           3=F5
###
