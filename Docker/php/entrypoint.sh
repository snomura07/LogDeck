#!/bin/sh
set -eu

if [ -d /var/www/html/storage ]; then
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache || true
fi

exec "$@"
