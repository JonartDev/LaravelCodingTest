FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    libicu-dev

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo_mysql bcmath zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/*