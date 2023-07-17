FROM php:8.2-fpm

RUN apt-get update 2>/dev/null | grep packages | cut -d '.' -f 1 && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev vim && apt clean
RUN docker-php-ext-install -j$(nproc) iconv pdo_mysql gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql 
    
# Install MongoDB Driver
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/html
