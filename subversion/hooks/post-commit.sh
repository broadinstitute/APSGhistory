#!/bin/bash

REPOSITORY=$1

set -e

COMMANDS=`find "$REPOSITORY"/hooks/post-commit.d -name '[0-9][0-9]*[^~]' -perm +0100`

for command in $COMMANDS
do
    $command "$@"
done
