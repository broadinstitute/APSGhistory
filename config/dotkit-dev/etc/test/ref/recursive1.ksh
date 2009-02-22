Test: recursive1.t
use B, which uses C, which uses D, which uses E, which uses A
In B before dk_op -q C, b1=B1 (B1 correct)
In C, c1=C1 (C1 correct)
In C, c2=C2 (C2 correct)
In D, d1=D1 (D1 correct)
In D, d2=D2 (D2 correct)
In E, e1=E1 (E1 correct)
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=bar2:bar1:Bar2:Bar1
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=4
A: _dk_self=././A
A: _dk_inuse=
In E, after return from A, e1=E1, e2=E2 (E1, E2/nil correct)
E: _dk_rl=3 (3)
E: _dk_self=././E
E: _dk_inuse=A.4
In D, after return from E, d1=D1, d2=D2 (D1, D2/nil correct)
D: _dk_rl=2 (2)
D: _dk_self=././D
D: _dk_inuse=E.3 A.4
In C, after return from D, c1=C1, c2=C2 (C1, C2/nil correct)
C: _dk_rl=1 (1)
C: _dk_self=././C
C: _dk_inuse=D.2 E.3 A.4
In B after dk_op -q C, b1=B1 (B1 correct)
In B after dk_op -q C, b2=B2 (B2 correct)
B: _dk_rl=0 (0)
B: _dk_self=././B
B: _dk_inuse=C.1 D.2 E.3 A.4
Added:
        Foo1=bar2:bar1:Bar2:Bar1
          b1=B1
          b2=B2
          c1=C1
          c2=C2
          d1=D1
          d2=D2
          e1=E1
          e2=E2
        foo1=bar1
        foo2=bar2
Wordlist variables altered:
  Added to: _dk_inuse
           1=B.0
           2=C.1
           3=D.2
           4=E.3
           5=A.4

Now unuse B, which should also unuse C, D, E, A
In B before dk_op -q C, b1=B1 (B1 correct)
In C, c1=C1 (C1 correct)
In C, c2= (C2 correct)
In D, d1=D1 (D1 correct)
In D, d2= (D2 correct)
In E, e1=E1 (E1 correct)
Leaving A, foo1=bar1 (bar1 is correct)
Leaving A, foo2=bar2 (bar2 is correct)
Leaving A, Foo1=
(bar2:bar1:Bar2:Bar1 is correct, or nil if unuse, or reversed if -a)
A: _dk_rl=4
A: _dk_self=././A
A: _dk_inuse=
In E, after return from A, e1=E1, e2= (E1, E2/nil correct)
E: _dk_rl=3 (3)
E: _dk_self=././E
E: _dk_inuse=
In D, after return from E, d1=D1, d2= (D1, D2/nil correct)
D: _dk_rl=2 (2)
D: _dk_self=././D
D: _dk_inuse=
In C, after return from D, c1=C1, c2= (C1, C2/nil correct)
C: _dk_rl=1 (1)
C: _dk_self=././C
C: _dk_inuse=
In B after dk_op -q C, b1=B1 (B1 correct)
In B after dk_op -q C, b2=B2 (B2 correct)
B: _dk_rl=0 (0)
B: _dk_self=././B
B: _dk_inuse=
Removed:
          b1=B1
          b2=B2
          c1=C1
          d1=D1
          e1=E1
        foo1=bar1
        foo2=bar2
Changed:
          c2=
 (old value)=C2
          d2=
 (old value)=D2
          e2=
 (old value)=E2
Wordlist variables altered:
  Removed from: Foo1
           1=bar2
           2=bar1
           3=Bar2
           4=Bar1
  Removed from: _dk_inuse
           1=B.0
           2=C.1
           3=D.2
           4=E.3
           5=A.4
###
