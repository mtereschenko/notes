FROM composer:1.10.10 AS composer
FROM php:7.4.10-fpm

# Let's use bash as a default shell with login each time
SHELL ["/bin/bash", "--login", "-c"]

# Decrale used arguments from `docker-compose.yml` file
ARG HOST_UID=1000
ARG HOST_GID=1000

# Declare constants
ENV PATH "$PATH:/home/dev/.composer/vendor/bin:/app/vendor/bin:/app/bin"

# Update package list and install necessary libraries
RUN apt-get update && apt-get install -y \
    zlib1g-dev libzip-dev libxml2-dev libicu-dev g++ nano vim git unzip jq bash-completion iproute2 sudo \
    && rm -rf /var/lib/apt/lists/*

# Enable all necessary PHP packages
RUN docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install zip \
    && pecl install xdebug-2.9.6 \
    && docker-php-ext-enable xdebug

# Install APCu and APC backward compatibility
RUN pecl install apcu \
    && pecl install apcu_bc-1.0.5 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

# Copy the Composer PHAR from the Composer image into the PHP image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Update Composer to latest version
RUN composer self-update

# Copy development `php.ini` configuration to container
COPY ./php.ini /usr/local/etc/php/php.ini

# Define used work directory
WORKDIR /app

# Add everything inside docker image
COPY . .

## Add the wait script to the image
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.7.3/wait /wait

# Ensure that all required files has execute rights
RUN chmod +x /app/entrypoint.sh \
    && chmod +x /usr/bin/composer \
    && chmod +x /wait

RUN chmod -R o+s+w /usr/local/etc/php

RUN groupadd --gid ${HOST_GID} dev \
    && useradd --password dev --uid ${HOST_UID} --gid ${HOST_GID} --shell /bin/bash --create-home dev \
    && usermod -a -G www-data,sudo dev \
    && chgrp -hR dev /app

USER dev

EXPOSE 9000

ENTRYPOINT ["/app/docker/local/php/entrypoint.sh"]
