FROM php:8.1-fpm-buster
MAINTAINER Tzvetelin Tzvetkov "tzvetelin.tzvetkov@gmail.com"

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
        curl \
        git \
        unzip \
        libzip-dev && \
    docker-php-ext-install zip mysqli pdo_mysql && \
    apt-get autoclean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
ENTRYPOINT ["./entrypoint.sh"]
