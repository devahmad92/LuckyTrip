# Use the official PHP image with FPM
FROM php:8.2-fpm

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer without hash verification for simplicity
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"
