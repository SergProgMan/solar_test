FROM php:7.4.5-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        exiftool \
    && docker-php-ext-install -j$(nproc) iconv \
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure exif && docker-php-ext-install exif && docker-php-ext-enable exif \
    && docker-php-ext-install -j$(nproc) pdo_mysql mysqli

RUN apt-get install git unzip -y

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update \
 && apt-get install -y \
 nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /application
