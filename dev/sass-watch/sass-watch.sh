#!/usr/bin/env bash

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

cd "$SCRIPTPATH"


sass --no-source-map --watch $(cat "rules" | awk -F':' '{if (length($2) == 0) {print "../../" $1} else  {print "../../" $1 ":../../" $2}}')