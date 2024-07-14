#!/bin/bash
cd /var/www/html
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
service nginx start
php-fpm
# nginx -g daemon-off
