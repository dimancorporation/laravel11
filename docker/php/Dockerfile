# Dockerfile
FROM php:8.2-fpm-alpine

ARG WWWGROUP
ARG NODE_VERSION=22
ARG POSTGRES_VERSION=17
ARG TZ=Europe/Moscow

RUN apk add --no-cache tzdata
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime
RUN echo $TZ > /etc/timezone

RUN apk add --no-cache gnupg \
    curl \
    ca-certificates \
    zip \
    unzip \
    git  \
    libpng-dev \
    python3 \
    sqlite \
    sqlite-dev \
    libpq-dev \
    nano

RUN apk add --no-cache  \
    php82-cli  \
    php82-dev \
    php82-pgsql \
    php82-curl \
    php82-imap  \
    php82-mbstring \
    php82-xml  \
    php82-zip  \
    php82-bcmath  \
    php82-soap \
    php82-intl \
    icu-dev \
    php82-ldap \
    php82-pecl-msgpack  \
    php82-pecl-igbinary  \
    php82-pecl-redis  \
    php82-pecl-swoole \
    php82-pecl-pcov

RUN docker-php-ext-install  \
    gd \
    bcmath \
    pdo_pgsql \
    intl

RUN docker-php-ext-enable  \
    gd \
    bcmath \
    pdo_pgsql \
    intl

# Установка Composer
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Установка Node.js и npm
RUN apk add --no-cache nodejs npm && \
    npm install -g npm

# Очистка кеша и временных файлов
RUN rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

# Настройка PHP
COPY ./docker/php/php.ini /etc/php82/conf.d/99-laravel.ini

WORKDIR /var/www/html

EXPOSE 9000/tcp

CMD ["php-fpm"]
