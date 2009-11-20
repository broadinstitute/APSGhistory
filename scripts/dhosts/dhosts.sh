#!/bin/bash

# for LSF support
# this will set MANPATH, LD_LIBRARY_PATH, PATH and other lsf things
if [ -f /broad/lsf/conf/profile.lsf ]; then
        . /broad/lsf/conf/profile.lsf
fi

for i in `egrep -v "^#|^$" /root/dhosts`
  do badmin hclose -C "see po:/root/dhosts" $i
done
