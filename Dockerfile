FROM php:8.2-apache

# TiDB ও MySQL এর জন্য pdo_mysql ইনস্টল
RUN docker-php-ext-install pdo_mysql

# Apache mod_rewrite চালু
RUN a2enmod rewrite

# প্রজেক্টের সব ফাইল Apache সার্ভারে কপি
COPY . /var/www/html/

# পারমিশন ঠিক করা
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
