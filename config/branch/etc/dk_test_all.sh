#!/bin/bash -l

echo $DK_ROOT

# List of all packages.
DK_ALL=`find $DK_ROOT -name "*dk" -type f -printf "%f\n" | sort -u | sed 's/\(.*\)\.dk/\1/'` 


# List of changed packages.
pushd $DK_ROOT > /dev/null 2>&1 
DK_CHANGED=`for f in $(svn status | awk '/\.dk/ {print $2}'); do basename $f | sed 's/\(.*\)\.dk/\1/'; done`
popd > /dev/null 2>&1

# List of ignored packages
DK_IGNORE=".prompt\+\+ default default\+\+ .X11 .local .broad .hostname .lang .path"

DK_TEST_LIST=$DK_ALL
for kit in $DK_IGNORE
  do
    DK_TEST_LIST=`echo $DK_TEST_LIST | tr ' ' '\n' | egrep -v "^${kit}\$"`
  done

# Clean up current environemnt
unuse -q .subversion-1.5.5
unuse -q .pdsh-2.17
unuse -q .lsf-7.0


for kit in $DK_TEST_LIST 
  do 
    echo "${kit} ################" 
    env | sort > ${kit}.before
    use ${kit}
    env | sort > ${kit}.loaded
    unuse ${kit} 
    env | sort > ${kit}.after
    diff ${kit}.before ${kit}.after
    echo -e "\n\n"
  done

