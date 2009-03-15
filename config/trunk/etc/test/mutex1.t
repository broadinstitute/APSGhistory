echo "use F1"
./env0
use F1
./env1

echo ""
echo "Now use F2, which should unuse F1"
./env0
use F2
./env1

echo ""
echo "Now use F3, which should unuse F2"
./env0
use F3
./env1

echo ""
echo "Return to the starting state by unusing F3"
./env0
unuse F3
./env1
