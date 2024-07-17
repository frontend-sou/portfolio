#!/bin/bash
cd /var/www/html
service nginx start
php-fpm
