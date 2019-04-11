#!/usr/bin/env bash

##
# Removes wp-prod directory.
##

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT


SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "version")

cd "$SCRIPTPATH"


if [ ! -d "$SCRIPTPATH/wp-prod" ]; then
    echo -e >&2 "\n$SCRIPTPATH/wp-prod not found. Nothing to uninstall. \nTerminated.\n"
    exit 1
fi


if [ -f "$SCRIPTPATH/wp-prod/locks/prod" ]; then
    echo -e >&2 "\nRun to_dev.sh first! \nTerminated.\n"
    exit 1
fi


rm -rf "$SCRIPTPATH/wp-prod/"