FROM php:7.4.1-fpm
COPY php.ini /usr/local/etc/php/

# Install Node.js and npm
RUN apt-get update && apt-get install -y gnupg2 && \
    curl -sL https://deb.nodesource.com/setup_19.x | bash - && \
    apt-get install -y nodejs

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


# install xdebug
RUN pecl install xdebug-3.1.5 && docker-php-ext-enable xdebug

WORKDIR /var/www/laravel
ADD . /var/www/laravel
RUN chown -R www-data:www-data /var/www/laravel