#!/bin/bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
npm install
npm run build

# Cache Laravel configurations for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"