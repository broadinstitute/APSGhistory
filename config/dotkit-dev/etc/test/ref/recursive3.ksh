Test: recursive3.t
recursive3, exit status of use and unuse
0=no errors; 1=found, but already loaded; 2=_dk_err; 4+ =not found

O should be found
Prepending: O (Found: ././O.dk)
O begins
use P
Prepending: P (Found: ././P.dk)
P begins
P ends
 (ok)
O: use P succeeded
O ends
 (ok)
 ... O found on first attempt

At top level, now attempt to use P -- should be ignored
Prepending: P (already loaded)
 ... Yes, use P did not succeed

Attempt to reuse O
Prepending: O (already loaded)
 ... Yes, use O did not succeed

Unuse O
Dropping: O (Found: ././O.dk)
O begins
unuse P
Dropping: P (Found: ././P.dk)
P begins
P ends
 (ok)
O: unuse P succeeded
O ends
 (ok)
 ... Yes, unuse O succeeded
==================================================
Repeat tests with rec3=1
recursive3, exit status of use and unuse
0=no errors; 1=found, but already loaded; 2=_dk_err; 4+ =not found

O should be found and succeed, but P should fail
Prepending: O (Found: ././O.dk)
O begins
use P
Prepending: P (Found: ././P.dk)
P begins
P ends
P FAILURE
O: use P failed
O ends
 (ok)
 ... O found on first attempt

At top level, now attempt to use P -- should be found, but fail
Prepending: P (Found: ././P.dk)
P begins
P ends
P FAILURE
 ... Yes, use P did not succeed

Attempt to reuse O, should be ignored
Prepending: O (already loaded)
 ... Yes, use O did not succeed

Unuse O, should succeed, with P not found
Dropping: O (Found: ././O.dk)
O begins
unuse P
Dropping: P (not found)
O: unuse P failed
O ends
 (ok)
 ... Yes, unuse O succeeded
==================================================
Test operation of dk_smask, dk_taciturn

Look for non-existent dotkits, with dk_smask=0.  Should be silent
(1: Did not find aa bb)

Look for non-existent dotkits, with dk_smask=4.  Should NOT be silent
 (aa: not found) (bb: not found)
(2: Did not find aa bb)

Check masking for dk_err, first with dk_smask=0

O begins
use P

P begins
P ends
O: use P failed
O ends

O begins
unuse P
O: unuse P failed
O ends

And now with dk_smask=2

O begins
use P

P begins
P ends
P FAILURE
O: use P failed
O ends

Now with dk_smask=1, check for already loaded
 (O: already loaded)
###
