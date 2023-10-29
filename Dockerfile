# Use the official PHP image with FPM
FROM php:8.2-fpm

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# If you're using Redis and need the Redis extension, install it as well
RUN pecl install redis && docker-php-ext-enable redis
