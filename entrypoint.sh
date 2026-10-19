#!/bin/bash

# অ্যাপ কি তৈরি করা (যদি না থাকে)
php artisan key:generate --force || true

# স্টোরেজ লিংক তৈরি
php artisan storage:link || true

# পুরনো ক্যাশ পরিষ্কার
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# TiDB ডাটাবেজে স্বয়ংক্রিয় টেবিল তৈরি
php artisan migrate --force || true

# Apache সার্ভার চালু করা
exec apache2-foreground
