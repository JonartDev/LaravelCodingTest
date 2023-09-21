FROM php:8.1-fpm

# Install extensions
RUN docker-php-ext-install pdo_mysql bcmath
RUN apt-get -y update \ 
&& apt-get install -y libicu-dev \ 
&& docker-php-ext-configure intl \ 
&& docker-php-ext-install intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer