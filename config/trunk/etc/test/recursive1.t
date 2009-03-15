echo "use B, which uses C, which uses D, which uses E, which uses A"
./env0
use -q B
./env1

echo ""
echo "Now unuse B, which should also unuse C, D, E, A"
./env0
unuse -q B
./env1
