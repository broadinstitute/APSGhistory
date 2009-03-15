# Test exit status and dk_smask operation

# Variable used inside O.dk
setenv vflag "-v"

# Flag for controlling P "success"
setenv rec3 0

echo "recursive3, exit status of use and unuse"
echo "0=no errors; 1=found, but already loaded; 2=_dk_err; 4+ =not found"

echo ""
echo "O should be found"
use -v O && echo " ... O found on first attempt" || echo " ... FAILED"

echo ""
echo "At top level, now attempt to use P -- should be ignored"
use -v P && \
  echo " ... PROBLEM: use P succeeded" || \
  echo " ... Yes, use P did not succeed"

echo ""
echo "Attempt to reuse O"
use -v O && \
  echo " ... PROBLEM: reuse O succeeded" || \
  echo " ... Yes, use O did not succeed"

echo ""
echo "Unuse O"
unuse -v O && \
  echo " ... Yes, unuse O succeeded" || \
  echo " ... PROBLEM: unuse O failed"

echo "=================================================="
echo "Repeat tests with rec3=1"
setenv rec3 1

echo "recursive3, exit status of use and unuse"
echo "0=no errors; 1=found, but already loaded; 2=_dk_err; 4+ =not found"

echo ""
echo "O should be found and succeed, but P should fail"
use -v O && echo " ... O found on first attempt" || echo " ... FAILED"

echo ""
echo "At top level, now attempt to use P -- should be found, but fail"
use -v P && \
  echo " ... PROBLEM: use P succeeded" || \
  echo " ... Yes, use P did not succeed"

echo ""
echo "Attempt to reuse O, should be ignored"
use -v O && \
  echo " ... PROBLEM: reuse O succeeded" || \
  echo " ... Yes, use O did not succeed"

echo ""
echo "Unuse O, should succeed, with P not found"
unuse -v O && \
  echo " ... Yes, unuse O succeeded" || \
  echo " ... PROBLEM: unuse O failed"

echo "=================================================="
echo "Test operation of dk_smask, dk_taciturn"
setenv vflag ""
setenv rec3 0
setenv dk_taciturn 1
setenv dk_smask 0
echo ""
echo "Look for non-existent dotkits, with dk_smask=0.  Should be silent"
use aa bb || \
  echo "(1: Did not find aa bb)"

echo ""
echo "Look for non-existent dotkits, with dk_smask=4.  Should NOT be silent"
setenv dk_smask 4
use aa bb || \
  echo "(2: Did not find aa bb)"

echo ""
echo "Check masking for dk_err, first with dk_smask=0"
setenv rec3 1 # (This makes P fail.)
setenv dk_smask 0
use O || \
  echo "(3: You should not see this message.)"

# reset
unuse -q O P

echo ""
echo "And now with dk_smask=2"
setenv rec3 1 # (This makes P fail.)
setenv dk_smask 2
use O || \
  echo "(4: This should be seen.)"

echo ""
echo "Now with dk_smask=1, check for already loaded"
setenv dk_smask 1
use O
