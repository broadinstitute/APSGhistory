Test: simple1.t
use A: Set foo1, foo2, and alter Foo1 several times
Note that foo1 and foo2 have initial values, which should
be restored by the unuse operation.
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=bar2:bar1:Bar2:Bar1
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=0
A: _dk_self=././A
A: _dk_inuse=
Added:
        Foo1=bar2:bar1:Bar2:Bar1
_dk_sev_foo1=startfoo1
_dk_sev_foo2=startfoo2
Changed:
   _dk_inuse=A.0
 (old value)=
        foo1=bar1
 (old value)=startfoo1
        foo2=bar2
 (old value)=startfoo2

Now unuse A to undo changes
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=0
A: _dk_self=././A
A: _dk_inuse=
Removed:
_dk_sev_foo1=startfoo1
_dk_sev_foo2=startfoo2
Changed:
   _dk_inuse=
 (old value)=A.0
        foo1=startfoo1
 (old value)=bar1
        foo2=startfoo2
 (old value)=bar2
Wordlist variables altered:
  Removed from: Foo1
           1=bar2
           2=bar1
           3=Bar2
           4=Bar1

Now check operation of the -a flag
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=Bar1:Bar2:bar1:bar2
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=0
A: _dk_self=././A
A: _dk_inuse=
Added:
_dk_sev_foo1=startfoo1
_dk_sev_foo2=startfoo2
Changed:
   _dk_inuse=A.0
 (old value)=
        foo1=bar1
 (old value)=startfoo1
        foo2=bar2
 (old value)=startfoo2
Wordlist variables altered:
  Added to: Foo1
           1=Bar1
           2=Bar2
           3=bar1
           4=bar2

And undo once again
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=0
A: _dk_self=././A
A: _dk_inuse=
Removed:
_dk_sev_foo1=startfoo1
_dk_sev_foo2=startfoo2
Changed:
   _dk_inuse=
 (old value)=A.0
        foo1=startfoo1
 (old value)=bar1
        foo2=startfoo2
 (old value)=bar2
Wordlist variables altered:
  Removed from: Foo1
           1=Bar1
           2=Bar2
           3=bar1
           4=bar2
###
