FROM phpdockerio/php:8.1-fpm

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        php8.1-amqp \
        php8.1-gd \
        php8.1-mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
WORKDIR /app
COPY . /app
RUN composer install
