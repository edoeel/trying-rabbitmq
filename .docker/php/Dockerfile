FROM php:7.2-fpm-alpine

RUN apk update && \
    apk upgrade && \
    docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
