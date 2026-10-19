FROM php:8.2-apache

# ১. প্রয়োজনীয় সিস্টেম প্যাকেজ ইনস্টল
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# ২. শুধুমাত্র ডাটাবেজের জন্য আবশ্যক pdo_mysql ইনস্টল
RUN docker-php-ext-install pdo_mysql

# ৩. Apache mod_rewrite চালু করা
RUN a2enmod rewrite

# ৪. Apache রুট ডিরেক্টরি Laravel-এর public ফোল্ডারে সেট করা
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# ৫. Composer যুক্ত করা
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ৬. গিটহাবের সমস্ত প্রজেক্ট ফাইল কপি করা
COPY . .

# ৭. প্রয়োজনীয় সব ক্যাশ ও স্টোরেজ ফোল্ডার স্বয়ংক্রিয়ভাবে তৈরি ও পারমিশন ফিক্স
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ৮. মেমরি ক্র্যাশ মুক্ত রেখে Composer প্যাকেজ ইনস্টল
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

EXPOSE 80

# ৯. সার্ভার চালু হওয়ার সময় অটো-মাইগ্রেশন ও Apache স্টার্ট
CMD sh -c "php artisan key:generate --force || true; php artisan storage:link || true; php artisan migrate --force || true; exec apache2-foreground"
