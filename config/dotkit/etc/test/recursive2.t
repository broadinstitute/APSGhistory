# Test stickiness of options during recursion:

echo "use K, which uses L, which uses M"

echo "use: opt_q=1"
use -q K
echo ""
echo "unuse: opt_q=1"
unuse -q K
echo ""

echo "use: opt_v=1"
use -v K
echo ""
echo "unuse: opt_v=1"
unuse -v K
echo ""

echo "use: opt_a=1, pream=Appending"
use -a K
echo ""
echo "unuse: opt_a=1, pream=Dropping"
unuse -a K
echo ""

echo "use: pream=Appending, opt_a=1, opt_q=1, opt_v=1"
use -aqv K
echo ""
echo "unuse: pream=Dropping, opt_a=1, opt_q=1, opt_v=1"
unuse -aqv K
