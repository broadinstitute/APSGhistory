echo "Check operation of SEPARATOR for dk_alter, alter, unalter"

setenv foo ""

# Use COLON as a SEPARATOR, no whitespace within fields.
alter foo -L/foo1
echo "foo is $foo, should be -L/foo1"
alter foo -L/foo2
echo "foo is $foo, should be -L/foo2:-L/foo1"
alter -a foo -L/foo3
echo "foo is $foo, should be -L/foo2:-L/foo1:-L/foo3"
alter foo -L/foo4
echo "foo is $foo, should be -L/foo4:-L/foo2:-L/foo1:-L/foo3"
unalter foo -L/foo1
echo "foo is $foo, should be -L/foo4:-L/foo2:-L/foo3"
setenv foo ""

# Use TAB as a SEPARATOR, SPACE for whitespace within a field.
alter foo "-L /foo1" '	'
echo "foo is $foo, should be -L /foo1"
alter foo "-L /foo2" '	'
echo "foo is $foo, should be -L /foo2	-L /foo1"
alter -a foo "-L /foo3" '	'
echo "foo is $foo, should be -L /foo2	-L /foo1	-L /foo3"
alter foo "-L /foo4" '	'
echo "foo is $foo, should be -L /foo4	-L /foo2	-L /foo1	-L /foo3"
unalter foo "-L /foo1" '	'
echo "foo is $foo, should be -L /foo4	-L /foo2	-L /foo3"
setenv foo ""

# Set DK_IFS=TAB, SPACE for whitespace within a field.
setenv DK_IFS '	'
alter foo "-L /foo1"
echo "foo is $foo, should be -L /foo1"
alter foo "-L /foo2"
echo "foo is $foo, should be -L /foo2	-L /foo1"
alter -a foo "-L /foo3"
echo "foo is $foo, should be -L /foo2	-L /foo1	-L /foo3"
alter foo "-L /foo4"
echo "foo is $foo, should be -L /foo4	-L /foo2	-L /foo1	-L /foo3"
unalter foo "-L /foo1"
echo "foo is $foo, should be -L /foo4	-L /foo2	-L /foo3"
setenv foo ""
unsetenv DK_IFS

# Use SPACE as a SEPARATOR, no whitespace within fields.
alter foo "-L/foo1" ' '
echo "foo is $foo, should be -L/foo1"
alter foo "-L/foo2" ' '
echo "foo is $foo, should be -L/foo2 -L/foo1"
alter -a foo "-L/foo3" ' '
echo "foo is $foo, should be -L/foo2 -L/foo1 -L/foo3"
alter foo "-L/foo4" ' '
echo "foo is $foo, should be -L/foo4 -L/foo2 -L/foo1 -L/foo3"
unalter foo "-L/foo1" ' '
echo "foo is $foo, should be -L/foo4 -L/foo2 -L/foo3"
setenv foo ""

./env0
use R
./env1

./env0
unuse R
./env1
