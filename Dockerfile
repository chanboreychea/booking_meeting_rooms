FROM php:8.1 as php

RUN apt-get update -y
#RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure calendar \
    && docker-php-ext-install calendar
RUN apt-get install libzip-dev -y

RUN docker-php-ext-install pdo pdo_mysql bcmath

#RUN pecl install -o -f redis \
#   && rm -rf /tmp/pear \
#  && docker-php-ext-enable redis

WORKDIR /var/www
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "Docker/entrypoint.sh" ]

