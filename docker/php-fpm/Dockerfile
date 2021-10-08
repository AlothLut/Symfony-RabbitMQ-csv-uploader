FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    librabbitmq-dev \
    libpq-dev \
    libssh-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && pecl install \
        xdebug \
        amqp \
    && docker-php-ext-enable \
        xdebug \
        amqp \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

RUN usermod -u 1000 www-data

EXPOSE 9000

CMD ["php-fpm"]