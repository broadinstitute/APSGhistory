# Test reusable dotkit
echo "J++ should note internal changes"
./env0
use J++
./env1

echo ""
echo "Now unuse J++"
./env0
unuse J++
./env1

echo ""
echo "Use J++ again"
./env0
use J++
./env1

echo ""
echo "And again"
./env0
use J++
./env1

echo "At the end, PATH should have doubled /foo/bar, because dk_alter"
echo "is not idempotent.  However, _dk_inuse should not change after"
echo "the second use."
