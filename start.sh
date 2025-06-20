#!/bin/bash

# Generate app key if not exists
php artisan key:generate --force

# Run database migrations (skip if no database)
php artisan migrate --force || echo "No database configured, skipping migrations"

# Clear and cache configurations
php artisan config:clear
php artisan config:cache

# Start the PHP built-in server
php -S 0.0.0.0:${PORT:-8000} -t public