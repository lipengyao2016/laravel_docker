#!/bin/sh
php artisan apollo:sync
sleep 2s && sh /start.sh