setenv PATH .:/bin:/usr/bin

echo "G1 should set X to ./env0"
./env0
use G1
./env1

echo ""
echo "Now unuse G1"
./env0
unuse G1
./env1

echo ""
echo "G2 should set X to ./env1"
./env0
use G2
./env1

echo ""
echo "Now unuse G2"
./env0
unuse G2
./env1
