#!/usr/bin/env bash

for link in $*
do
    if [[ -L $link ]]
    then
	ln -sf `readlink $link` $link
    else
	echo skipping $link:  not a symbolic link >&2
    fi
done
