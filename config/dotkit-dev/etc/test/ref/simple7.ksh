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
In R, in between dk_alter, foo=-L/foo1 x
Checking multiple value dk_alter handling
R: ending
 (ok)
Changed:
   _dk_inuse=R.0
 (old value)=
Wordlist variables altered:
  Removed from: foo
           1=x
  Added to: foo
           1=/foo/bar
           2=/bar/foo
           3=-L/foo2 -L/foo1 x
Dropping: R
R: starting
In R, in between dk_alter, foo=/foo/bar:/bar/foo:-L/foo2 x
Checking multiple value dk_alter handling
R: ending
 (ok)
Changed:
   _dk_inuse=
 (old value)=R.0
Wordlist variables altered:
  Removed from: foo
           1=/foo/bar
           2=/bar/foo
           3=-L/foo2 -L/foo1 x
  Added to: foo
           1=-L/foo2 x
###
