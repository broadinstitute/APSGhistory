setenv foo1 "startfoo1"
setenv foo2 "startfoo2"

echo "use A: Set foo1, foo2, and alter Foo1 several times"
echo "Note that foo1 and foo2 have initial values, which should"
echo "be restored by the unuse operation."
./env0
use -q A
./env1

echo ""
echo "Now unuse A to undo changes"
./env0
unuse -q A
./env1

echo ""
echo "Now check operation of the -a flag"
./env0
use -qa A
./env1

echo ""
echo "And undo once again"
./env0
unuse -qa A
./env1
