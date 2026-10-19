FROM php:8.2-apache

# প্রয়োজনীয় প্যাকেজ ও এক্সটেনশন ইনস্টল
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    ca-certificates

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

# Apache Document Root পরিবর্তন
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Composer ইনস্টল
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# কোড কপি করা
COPY . .

# মিসিং থাকা লারাভেল স্টোরেজ ফোল্ডারগুলো ডকার নিজেই বানিয়ে নেবে
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# ফোল্ডার পারমিশন ঠিক করা
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# প্যাকেজ ইনস্টল
RUN composer install --no-dev --optimize-autoloader --no-interaction

# entrypoint ফাইল সচল করা
RUN chmod +x /var/www/html/entrypoint.sh

EXPOSE 80

CMD ["/var/www/html/entrypoint.sh"]
