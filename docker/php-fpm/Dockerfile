FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && pecl install \
        xdebug \
    && docker-php-ext-enable \
        xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]