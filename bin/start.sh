#!/bin/sh

SCRIPT_PATH=$(dirname "$0" | tr -d '\r')

cd "$SCRIPT_PATH/.."

./bin/wait-for-db.sh

php artisan db:wipe --force

php artisan migrate:fresh --force

php artisan db:seed --force

php -S 0.0.0.0:8000 -t public
