FROM php:7.4-apache

RUN apt-get update && apt-get -y install apt-utils && apt-get -y install vim

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl channel-update pecl.php.net

RUN docker-php-source extract \
    # EXT Commons
    && docker-php-ext-install calendar pdo_mysql sockets bcmath \
    # Clean up
    && docker-php-source delete

RUN chown -R www-data:www-data /var/www/html
RUN a2enmod rewrite

CMD php artisan serve --host=0.0.0.0 --port=80

EXPOSE 80
