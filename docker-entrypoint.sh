#!/bin/bash
cd /var/www/html
php artisan migrate
service nginx start
php-fpm
# nginx -g daemon-off
