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

# Additional unit tests for dk_alter, alter, unalter.

# Prepend multiple non-null components.
setenv foo "b:y"
alter foo "x:b:a"
dk_test "$foo" = "x:b:a:b:y" || echo "dk_alter error 01"

# Append multiple non-null components.
alter -a foo "z:t"
dk_test "$foo" = "x:b:a:b:y:z:t" || echo "dk_alter error 02"

# Remove multiple non-null components from the interior of a string.
unalter foo "a:b"
dk_test "$foo" = "x:b:y:z:t" || echo "dk_alter error 03"

# Remove the first (non-null) component with unalter.
unalter foo "x"
dk_test "$foo" = "b:y:z:t" || echo "dk_alter error 04"

# Put it back.
alter foo "x"
dk_test "$foo" = "x:b:y:z:t" || echo "dk_alter error 05"

# Remove the first (non-null) component with unalter -a.
unalter -a foo "x"
dk_test "$foo" = "b:y:z:t" || echo "dk_alter error 06"

# Remove the last (non-null) component with unalter.
unalter foo "t"
dk_test "$foo" = "b:y:z" || echo "dk_alter error 07"

# Put it back.
alter -a foo "t"
dk_test "$foo" = "b:y:z:t" || echo "dk_alter error 08"

# Remove the last (non-null) component with unalter -a.
unalter -a foo "t"
dk_test "$foo" = "b:y:z" || echo "dk_alter error 09"

# Remove two leading components.
unalter foo "b:y"
dk_test "$foo" = "z" || echo "dk_alter error 10"

# Remove the only non-null component, leaving an empty string.
unalter foo "z"
dk_test "$foo" = "" || echo "dk_alter error 11"

# Check that string is unchanged if pattern does not match.
setenv foo "x:a:b:y"
unalter foo "a:b:c"
dk_test "$foo" = "x:a:b:y" || echo "dk_alter error 12"

# Remove pattern, but leave behind a partial pattern at the end.
setenv foo "x:a:b:c:y:a:b"
unalter foo "a:b:c"
dk_test "$foo" = "x:y:a:b" || echo "dk_alter error 13"

# Remove pattern, but leave behind a partial pattern at the end, with -a flag.
setenv foo "x:a:b:c:y:a:b"
unalter -a foo "a:b:c"
dk_test "$foo" = "x:y:a:b" || echo "dk_alter error 14"

# Remove the first pattern of two in a string.
setenv foo "x:a:b:c:y:a:b:c:z"
unalter foo "a:b:c"
dk_test "$foo" = "x:y:a:b:c:z" || echo "dk_alter error 15"

# Remove the last pattern of two in a string.
setenv foo "x:a:b:c:y:a:b:c:z"
unalter -a foo "a:b:c"
dk_test "$foo" = "x:a:b:c:y:z" || echo "dk_alter error 16"

# Remove the first pattern of two in a string that only has the two.
setenv foo "a:b:c:a:b:c"
unalter foo "a:b:c"
dk_test "$foo" = "a:b:c" || echo "dk_alter error 17"

# Remove the last pattern of two in a string that only has the two.
setenv foo "a:b:c:a:b:c"
unalter -a foo "a:b:c"
dk_test "$foo" = "a:b:c" || echo "dk_alter error 18"

# Add a null component at the start of a string.
setenv foo "a:b"
alter foo ""
dk_test "$foo" = ":a:b" || echo "dk_alter error 19"

# Add a null component at the end of a string.
setenv foo "a:b"
alter -a foo ""
dk_test "$foo" = "a:b:" || echo "dk_alter error 20"

# Remove a null component at the start of a string with unalter.
setenv foo ":a:b"
unalter foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 21"

# Remove a null component at the start of a string with unalter -a.
setenv foo ":a:b"
unalter -a foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 22"

# Remove a null component at the end of a string with unalter.
setenv foo "a:b:"
unalter foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 23"

# Remove a null component at the end of a string with unalter -a.
setenv foo "a:b:"
unalter -a foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 24"

# Remove a null component in the middle of a string with unalter.
setenv foo "a::b"
unalter foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 25"

# Remove a null component in the middle of a string with unalter -a.
setenv foo "a::b"
unalter -a foo ""
dk_test "$foo" = "a:b" || echo "dk_alter error 26"

# Add component with white space to the start of a string.
setenv foo "a a:b b"
alter foo "x x"
dk_test "$foo" = "x x:a a:b b" || echo "dk_alter error 27"

# Add component with white space to the end of a string.
alter -a foo "x x"
dk_test "$foo" = "x x:a a:b b:x x" || echo "dk_alter error 28"

# Remove the first such component.
unalter foo "x x"
dk_test "$foo" = "a a:b b:x x" || echo "dk_alter error 29"

# And remove the last such component.
unalter foo "x x"
dk_test "$foo" = "a a:b b" || echo "dk_alter error 30"

# Repeat the removals using the -a flag.
setenv foo "x x:a a:b b:x x"
unalter -a foo "x x"
dk_test "$foo" = "x x:a a:b b" || echo "dk_alter error 31"
unalter -a foo "x x"
dk_test "$foo" = "a a:b b" || echo "dk_alter error 32"

# Add to an undefined variable using alter.
unset foo
dk_test $_dk_shell = csh -o $_dk_shell = tcsh && unsetenv foo
alter foo "x"
dk_test "$foo" = "x" || echo "dk_alter error 33"

./env0
use R
./env1

./env0
unuse R
./env1
