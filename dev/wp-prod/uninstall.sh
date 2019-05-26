#!/usr/bin/env bash

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "version")

cd "$SCRIPTPATH"


##
# Removes wp-prod directory (usually used to free up disk space or install another version of wp-prod).
##


if [ -d "$SCRIPTPATH/wp-prod" ]; then
    rm -rf "$SCRIPTPATH/wp-prod/"
else
    echo -e >&2 "\n$SCRIPTPATH/wp-prod not found. Nothing to uninstall. \nTerminated.\n"
    exit 1
fi
