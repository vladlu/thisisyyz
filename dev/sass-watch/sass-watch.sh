#!/usr/bin/env bash

##
# Activates sass-watch.
#
# Parses the rules and activates sass-watch based on the rules.
##

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

cd "$SCRIPTPATH"


sass --watch --no-source-map $(cat "rules" | awk '{ if ( length($1) > 0 && substr($1,1,1) !~ /^#/ ) { if ( length($2) > 0 ) { print "../.." $1 ":../../" $2 } else { print "../../" $1 } } }')