# Dockerfile
FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

RUN a2enmod rewrite