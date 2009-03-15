echo "Check operation of dk_setdef, _dk_pream"

echo "#################################################"
echo "foo starts out nil"

setenv foo ""
echo "Use S"
./env0
use S
./env1
echo "Unuse S"
./env0
unuse S
./env1

echo "#################################################"
echo "foo starts out XXXXX"

setenv foo "XXXXX"
echo "Use S"
./env0
use S
./env1
echo "Unuse S"
./env0
unuse S
./env1

echo "#################################################"
echo "foo starts out XXXXX, should be just the same as previous section"

setenv foo "XXXXX"
echo "Use S"
./env0
use -a S
./env1
echo "Unuse S"
./env0
unuse S
./env1
