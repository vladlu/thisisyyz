#!/usr/bin/env bash

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "version")

cd "$SCRIPTPATH"


##
# Runs wp-prod.
##


if [ ! -d "$SCRIPTPATH/wp-prod" ]; then
    echo -e "Getting wp-prod $version...\n"
    wget "https://github.com/vladlu/wp-prod/archive/$version.tar.gz"
    tar -xzf "$version.tar.gz"
    rm -f "$version.tar.gz"
    mv "wp-prod-$version" "wp-prod"
fi


wp-prod/bin/run.sh
