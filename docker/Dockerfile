FROM php:8.1-fpm

WORKDIR /usr/src/app

RUN apt-get update \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git sqlite3 libcap2-bin libpng-dev dnsutils software-properties-common \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN docker-php-ext-install bcmath sysvsem sysvshm sysvmsg

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis