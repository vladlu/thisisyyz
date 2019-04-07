#!/usr/bin/env bash
set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT


SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "version")

cd "$SCRIPTPATH"


if [ ! -d "$SCRIPTPATH/wp-prod" ]; then
    wget -q "https://github.com/vladlu/wp-prod/archive/$version.tar.gz"
    tar -xzf "$version.tar.gz"
    rm -f "$version.tar.gz"
    mv "wp-prod-$version" "wp-prod"
fi


wp-prod/bin/to_prod.sh
