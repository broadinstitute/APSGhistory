Test: simple7.t
Check operation of SEPARATOR for dk_alter, alter, unalter
foo is -L/foo1, should be -L/foo1
foo is -L/foo2:-L/foo1, should be -L/foo2:-L/foo1
foo is -L/foo2:-L/foo1:-L/foo3, should be -L/foo2:-L/foo1:-L/foo3
foo is -L/foo4:-L/foo2:-L/foo1:-L/foo3, should be -L/foo4:-L/foo2:-L/foo1:-L/foo3
foo is -L/foo4:-L/foo2:-L/foo3, should be -L/foo4:-L/foo2:-L/foo3
foo is -L /foo1, should be -L /foo1
foo is -L /foo2	-L /foo1, should be -L /foo2	-L /foo1
foo is -L /foo2	-L /foo1	-L /foo3, should be -L /foo2	-L /foo1	-L /foo3
foo is -L /foo4	-L /foo2	-L /foo1	-L /foo3, should be -L /foo4	-L /foo2	-L /foo1	-L /foo3
foo is -L /foo4	-L /foo2	-L /foo3, should be -L /foo4	-L /foo2	-L /foo3
foo is -L /foo1, should be -L /foo1
foo is -L /foo2	-L /foo1, should be -L /foo2	-L /foo1
foo is -L /foo2	-L /foo1	-L /foo3, should be -L /foo2	-L /foo1	-L /foo3
foo is -L /foo4	-L /foo2	-L /foo1	-L /foo3, should be -L /foo4	-L /foo2	-L /foo1	-L /foo3
foo is -L /foo4	-L /foo2	-L /foo3, should be -L /foo4	-L /foo2	-L /foo3
foo is -L/foo1, should be -L/foo1
foo is -L/foo2 -L/foo1, should be -L/foo2 -L/foo1
foo is -L/foo2 -L/foo1 -L/foo3, should be -L/foo2 -L/foo1 -L/foo3
foo is -L/foo4 -L/foo2 -L/foo1 -L/foo3, should be -L/foo4 -L/foo2 -L/foo1 -L/foo3
foo is -L/foo4 -L/foo2 -L/foo3, should be -L/foo4 -L/foo2 -L/foo3
Prepending: R
R: starting
In R, in between dk_alter, foo=-L/foo1
 (ok)
Changed:
   _dk_inuse=R.0
 (old value)=
         foo=-L/foo2 -L/foo1
 (old value)=
Dropping: R
R: starting
In R, in between dk_alter, foo=-L/foo2
 (ok)
Changed:
   _dk_inuse=
 (old value)=R.0
         foo=
 (old value)=-L/foo2 -L/foo1
###
