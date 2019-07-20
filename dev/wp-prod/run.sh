#!/usr/bin/env bash

##
# Installs the specified version of wp-prod-core if needed and runs it.
##

set -Eeuo pipefail
trap 'echo >&2 "ERROR on line $LINENO ($(tail -n+$LINENO $0 | head -n1)). Terminated."' ERR
trap '[ $? = 0 ] && echo "Done." ' EXIT

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
core_version=$(cat "core-version")

cd "$SCRIPTPATH"



install_wp-prod-core() {
    echo -e "Getting wp-prod-core $core_version...\n"
    wget "https://github.com/vladlu/wp-prod-core/archive/$core_version.tar.gz"
    tar -xzf "$core_version.tar.gz"
    rm -f "$core_version.tar.gz"
    mv "wp-prod-core-$core_version" "wp-prod-core"
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
# Checks for the core version.
##

current_core_version=$(cat "wp-prod-core/version")
specified_core_version="$core_version"
if [[ "$current_core_version" != "$specified_core_version" ]]; then
    echo -e "The currently installed core version ($current_core_version) differs from the specified one ($specified_core_version).
Deleting it and installing the specified core version.. \n"

    # If they differ, deletes the current core version and installs the specified one.

    uninstall_wp-prod-core
    install_wp-prod-core
fi


run_wp-prod-core