FROM php:8.2-apache

RUN a2dismod mpm_event mpm_worker || true && a2enmod mpm_prefork

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80