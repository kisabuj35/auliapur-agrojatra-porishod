#!/bin/bash

# Generate key if not set
php artisan key:generate --force

# Create storage link
php artisan storage:link

# Clear old cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Auto migrate TiDB database
php artisan migrate --force

# Start Apache Server
apache2-foreground
