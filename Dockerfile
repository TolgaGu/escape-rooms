FROM php:8.2-alpine3.16

RUN apk add --no-cache linux-headers
RUN apk update && apk add --no-cache git zip unzip \
    && docker-php-ext-install pdo_mysql \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk add --no-cache linux-headers \
    && apk del .build-deps


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN composer install

RUN cp .env.example .env

EXPOSE 8000