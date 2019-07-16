#!/usr/bin/env bash

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "version")

cd "$SCRIPTPATH"



install_wp-prod-core() {
    echo -e "Getting wp-prod-core $version...\n"
    wget "https://github.com/vladlu/wp-prod-core/archive/$version.tar.gz"
    tar -xzf "$version.tar.gz"
    rm -f "$version.tar.gz"
    mv "wp-prod-core-$version" "wp-prod-core"
}


run_wp-prod-core() {
    wp-prod-core/bin/run.sh
}


uninstall_wp-prod-core() {
    "$SCRIPTPATH/uninstall.sh"
}



##
# Runs wp-prod.
##

if [ ! -d "$SCRIPTPATH/wp-prod-core" ]; then
    install_wp-prod-core
fi


##
# Checks for the version.
##

current_version=$(cat "wp-prod-core/version")
specified_version=$(cat version)
if [[ "$current_version" != "$specified_version" ]]; then
    echo -e "The currently installed version ($current_version) differs from the specified ($specified_version).
Deleting it and installing the specified version.. \n"

    # If they differ, deletes the current version and installs the specified.

    uninstall_wp-prod-core
    install_wp-prod-core
fi


run_wp-prod-core