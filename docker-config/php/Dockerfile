FROM php:7.4.1-fpm
COPY php.ini /usr/local/etc/php/

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# install packages
RUN apt-get update \
  && apt-get install -y \
    gcc \
    make \
    libpng-dev \
    git \
    unzip \
    vim \
    libmcrypt-dev \
    mariadb-client \
    curl \
    gnupg \
    openssl \
    zlib1g-dev \ 
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql mysqli zip


# install stable node and latest npm
# FROM node:14.4.0
# ENV NODE_ENV=production
# WORKDIR /app
# COPY ["package.json", "package-lock.json*", "./"]
# RUN apt-get install -y nodejs=12.16.1-1nodesource1
# COPY . .
# EXPOSE 8080
# CMD [ "node", "server.js" ]

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 1655A0AB68576280
RUN apt-get update
RUN apt-get install -y nodejs

# install xdebug
RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug

WORKDIR /var/www/laravel
ADD . /var/www/laravel
RUN chown -R www-data:www-data /var/www/laravel