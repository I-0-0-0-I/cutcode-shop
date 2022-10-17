FROM php:8.1-fpm-alpine

RUN apk add \
    libpq-dev \
    npm \
    mc \
    git \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_pgsql \
    pdo_mysql \
    pcntl \
    exif \
    zip

RUN apk add $PHPIZE_DEPS \
&& pecl install  \
    xdebug \
&& docker-php-ext-enable  \
    xdebug
COPY .docker/app/dev/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY .docker/app/dev/usr/local/etc/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY .docker/app/dev/usr/local/etc/php/php.ini /usr/local/etc/php/php.ini
COPY .docker/app/dev/usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html
