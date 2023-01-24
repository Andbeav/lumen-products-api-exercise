#!/bin/sh

SCRIPT_PATH=$(dirname "$0" | tr -d '\r')

cd "$SCRIPT_PATH/.."

./bin/wait-for-db.sh

php artisan db:wipe

php artisan migrate:fresh

./vendor/bin/phpunit --testdox
