#!/bin/bash

REPOSITORY=$1

HOOK=`basename $0`

HOOK_SCRIPT_DIR=${REPOSITORY}/hooks/${HOOK}.d

COMMANDS=`find ${HOOK_SCRIPT_DIR} -maxdepth 1 -name '[0-9][0-9]*[^~]' -perm +0100`

for command in $COMMANDS
do
    $command "$@"
done
