FROM php:8.4-fpm AS base

RUN apt-get update && apt-get install -y \
	libfreetype-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libicu-dev \
	libmagickwand-dev \
	libpq-dev \
	&& rm -rf /var/lib/apt/lists/*

FROM base AS dependencies

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install \
		intl \
		bcmath \
		opcache \
		pdo \
		pdo_pgsql \
		gd

RUN pecl install imagick \
	&& docker-php-ext-enable imagick

RUN pecl install xdebug \
	&& docker-php-ext-enable xdebug

FROM dependencies AS configure

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer/composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./app /var/www/html
