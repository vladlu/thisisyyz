#!/usr/bin/env bash
set -Eeuo pipefail


SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
version=$(cat "_wp-prod/version")

cd "$SCRIPTPATH"


wget "https://github.com/vladlu/wp-prod/archive/$version.tar.gz"
tar -xzf "$version.tar.gz"
rm -f "$version.tar.gz"
mv "wp-prod-$version" "wp-prod"


mkdir -p bin

cat << 'EOF' > bin/to_dev.sh
#!/usr/bin/env bash

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
cd "$SCRIPTPATH"

../wp-prod/bin/to_dev.sh
EOF


cat << 'EOF' > bin/to_prod.sh
#!/usr/bin/env bash

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
cd "$SCRIPTPATH"

../wp-prod/bin/to_prod.sh
EOF

chmod -R 755 bin