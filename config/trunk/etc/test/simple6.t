echo "Check operation of _dk_hide"

./env0
use N
./env1

echo ""
echo "Now unuse N"
./env0
unuse N
./env1

echo "(Should not be found on unuse, because dotkit was hidden.)"
