#!/usr/bin/env bash

for link in $*
do
    ln -sf `readlink $link` $link
done
