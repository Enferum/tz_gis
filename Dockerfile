FROM php:8.2.11-fpm

WORKDIR /var/www

RUN cd /tmp \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        gnupg \
        nano \
        wget \
        npm \
        && curl -sL https://deb.nodesource.com/setup_22.x | bash - \
        && apt-get install -y nodejs

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN mkdir -p /home/www/.composer && \
     chown -R www:www /home/www

USER www
