FROM php:8.2.7-fpm
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update -y && apt-get install -y libpng-dev
RUN docker-php-ext-install gd
