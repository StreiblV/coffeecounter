FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY *.php /var/www/html/
# COPY *.html /var/www/html/
COPY *.css /var/www/html/
# COPY *.js /var/www/html/
