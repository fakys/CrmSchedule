FROM php:8.2-fpm

WORKDIR /var/app

RUN apt-get update && apt-get install -y \
    apt-utils \
    libjpeg62-turbo-dev \
    git \
    zip unzip \
    libzip-dev \
    libfreetype6-dev \
    cron

RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd

RUN docker-php-ext-install zip

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo

RUN docker-php-ext-install sockets

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY App/php.ini /usr/local/etc/php/conf.d/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY App/cron/schedule-task-cron /etc/cron.d/schedule-task-cron
RUN chmod 0644 /etc/cron.d/schedule-task-cron && \
    chown root:root /etc/cron.d/schedule-task-cron && \
    touch /var/log/cron.log && \
    chmod 0666 /var/log/cron.log
