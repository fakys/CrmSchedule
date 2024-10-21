FROM php:8.2-fpm

WORKDIR /var/app

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpng-dev \
    libjpeg62-turbo-dev \
    git \
    zip unzip \
    libzip-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip

COPY App/php.ini /usr/local/etc/php/conf.d/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
