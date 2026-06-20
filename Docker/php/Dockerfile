FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        default-mysql-client \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY Docker/php/entrypoint.sh /usr/local/bin/logdeck-entrypoint.sh

RUN chmod +x /usr/local/bin/logdeck-entrypoint.sh

WORKDIR /var/www/html
