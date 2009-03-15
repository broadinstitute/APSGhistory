echo "Test eval inside a dotkit, and some common quoting needs"
echo ""
setenv A AAA

# ([t]csh cannot presently add space-separated components to a
# colon-separated list:)
#setenv B "B1 B2 B3"

setenv B "BBB"
setenv C E
setenv D PATH
setenv E EEE
echo "1: Starting values A=$A, B=$B, C=$C, D=$D, E=$E"

./env0
use H
./env1

echo ""
echo "Now unuse H"
./env0
unuse H
./env1
