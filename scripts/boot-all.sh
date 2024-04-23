#!/usr/bin/env bash

# Base directory containing source code
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

# exit when any command fails
set -e

COMPOSER_FLAGS=${1:-""}

bash "$DIR"/boot.sh "$COMPOSER_FLAGS" 8.1
bash "$DIR"/boot.sh "$COMPOSER_FLAGS" 8.0
bash "$DIR"/boot.sh "$COMPOSER_FLAGS" 7.4
bash "$DIR"/boot.sh "$COMPOSER_FLAGS" 7.3
