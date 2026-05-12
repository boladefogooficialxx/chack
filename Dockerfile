FROM php:8.2-apache

# Remove conflicting MPMs and ensure prefork is enabled
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80