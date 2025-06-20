#!/bin/bash

# Run database migrations
php artisan migrate --force

# Start the PHP built-in server
php -S 0.0.0.0:$PORT -t public