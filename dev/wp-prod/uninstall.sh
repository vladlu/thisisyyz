#!/usr/bin/env bash

##
# Removes wp-prod-core directory (usually used to free up the disk space because node_modules directory can be large).
##

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

cd "$SCRIPTPATH"


if [ -d "$SCRIPTPATH/wp-prod-core" ]; then
    rm -rf "$SCRIPTPATH/wp-prod-core/"
else
    echo -e >&2 "\n$SCRIPTPATH/wp-prod-core not found. Nothing to uninstall. \nTerminated.\n"
    exit 1
fi
