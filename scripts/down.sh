#!/usr/bin/env bash

# exit when any command fails
set -e

if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
else
    BRANCH="${TRAVIS_BRANCH}"
fi

PHP_VERSION=$(php --version)
PHP_VERSION=${PHP_VERSION:4:3}

# Allow for a php-composer image tag argument
PHP_COMPOSER_TAG=${1-$PHP_VERSION}

TAG="$PHP_COMPOSER_TAG-$BRANCH"
export TAG

docker-compose down -v --remove-orphans
