echo "Check operation of _dk_err"

./env0
use I
./env1

echo ""
echo "Now unuse I"
./env0
unuse I
./env1

echo "(Should not be found on unuse, because dotkit had internal errors.)"
