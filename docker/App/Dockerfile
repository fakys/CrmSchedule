FROM php:8.2-fpm

WORKDIR /var/app

RUN apt-get update && apt-get install -y \
    apt-utils \
    libjpeg62-turbo-dev \
    git \
    zip unzip \
    libzip-dev \
    libfreetype6-dev

RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo

COPY App/php.ini /usr/local/etc/php/conf.d/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
