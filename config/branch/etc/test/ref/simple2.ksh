Test: simple2.t
G1 should set X to ./env0
Prepending: G1 (ok)
Added:
           X=./env0
Changed:
   _dk_inuse=G1.0
 (old value)=

Now unuse G1
Dropping: G1 (ok)
Removed:
           X=./env0
Changed:
   _dk_inuse=
 (old value)=G1.0

G2 should set X to ./env1
Prepending: G2 (ok)
Added:
           X=./env1
Changed:
   _dk_inuse=G2.0
 (old value)=

Now unuse G2
Dropping: G2 (ok)
Removed:
           X=./env1
Changed:
   _dk_inuse=
 (old value)=G2.0
###
