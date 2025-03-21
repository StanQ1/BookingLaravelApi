#!/bin/sh

mkdir -p /var/www/html/src/storage /var/www/html/src/bootstrap/cache
chown -R www-data:www-data /var/www/html/src/storage /var/www/html/src/bootstrap/cache
chmod -R 775 /var/www/html/src/storage /var/www/html/src/bootstrap/cache

exec "$@"
