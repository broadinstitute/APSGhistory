Test: recursive2.t
use K, which uses L, which uses M
use: opt_q=1
K1: pream=Prepending, a=0, q=1, v=0
L1: pream=Prepending, a=0, q=1, v=0
M1: pream=Prepending, a=0, q=1, v=0
L2: pream=Prepending, a=0, q=1, v=0
K2: pream=Prepending, a=0, q=1, v=0

unuse: opt_q=1
K1: pream=Dropping, a=0, q=1, v=0
L1: pream=Dropping, a=0, q=1, v=0
M1: pream=Dropping, a=0, q=1, v=0
L2: pream=Dropping, a=0, q=1, v=0
K2: pream=Dropping, a=0, q=1, v=0

use: opt_v=1
Prepending: K (Found: ././K.dk)K1: pream=Prepending, a=0, q=0, v=1
Prepending: L (Found: ././L.dk)L1: pream=Prepending, a=0, q=0, v=1
Prepending: M (Found: ././M.dk)M1: pream=Prepending, a=0, q=0, v=1
 (ok)
L2: pream=Prepending, a=0, q=0, v=1
 (ok)
K2: pream=Prepending, a=0, q=0, v=1
 (ok)

unuse: opt_v=1
Dropping: K (Found: ././K.dk)K1: pream=Dropping, a=0, q=0, v=1
Dropping: L (Found: ././L.dk)L1: pream=Dropping, a=0, q=0, v=1
Dropping: M (Found: ././M.dk)M1: pream=Dropping, a=0, q=0, v=1
 (ok)
L2: pream=Dropping, a=0, q=0, v=1
 (ok)
K2: pream=Dropping, a=0, q=0, v=1
 (ok)

use: opt_a=1, pream=Appending
Appending: KK1: pream=Appending, a=1, q=0, v=0
Appending: LL1: pream=Appending, a=1, q=0, v=0
Appending: MM1: pream=Appending, a=1, q=0, v=0
 (ok)
L2: pream=Appending, a=1, q=0, v=0
 (ok)
K2: pream=Appending, a=1, q=0, v=0
 (ok)

unuse: opt_a=1, pream=Dropping
Dropping: KK1: pream=Dropping, a=1, q=0, v=0
Dropping: LL1: pream=Dropping, a=1, q=0, v=0
Dropping: MM1: pream=Dropping, a=1, q=0, v=0
 (ok)
L2: pream=Dropping, a=1, q=0, v=0
 (ok)
K2: pream=Dropping, a=1, q=0, v=0
 (ok)

use: pream=Appending, opt_a=1, opt_q=1, opt_v=1
Appending: K (Found: ././K.dk)K1: pream=Appending, a=1, q=1, v=1
Appending: L (Found: ././L.dk)L1: pream=Appending, a=1, q=1, v=1
Appending: M (Found: ././M.dk)M1: pream=Appending, a=1, q=1, v=1
 (ok)
L2: pream=Appending, a=1, q=1, v=1
 (ok)
K2: pream=Appending, a=1, q=1, v=1
 (ok)

unuse: pream=Dropping, opt_a=1, opt_q=1, opt_v=1
Dropping: K (Found: ././K.dk)K1: pream=Dropping, a=1, q=1, v=1
Dropping: L (Found: ././L.dk)L1: pream=Dropping, a=1, q=1, v=1
Dropping: M (Found: ././M.dk)M1: pream=Dropping, a=1, q=1, v=1
 (ok)
L2: pream=Dropping, a=1, q=1, v=1
 (ok)
K2: pream=Dropping, a=1, q=1, v=1
 (ok)
###
