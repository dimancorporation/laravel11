# Dockerfile
FROM php:8.2-apache

ARG WWWGROUP
ARG NODE_VERSION=22
ARG TZ=Europe/Moscow

RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom

RUN apt-get update && apt-get upgrade -y && apt-get install -y tzdata
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime
RUN echo $TZ > /etc/timezone

RUN apt-get install -y gnupg \
    curl \
    ca-certificates \
    zip \
    unzip \
    git  \
    libpq-dev \
    nano \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install  \
    bcmath \
    pdo \
    pgsql \
    pdo_pgsql \
    && docker-php-ext-enable  \
    bcmath \
    pdo \
    pgsql \
    pdo_pgsql

# Установка Composer
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Установка Node.js и npm
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
      && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
      && apt-get update \
      && apt-get install -y nodejs \
      && npm install -g npm

# Очистка кеша и временных файлов
RUN rm -rf /var/cache/apk/* /tmp/* /var/tmp/*

# Настройка PHP
COPY ./docker/php/php.ini /etc/php82/conf.d/99-laravel.ini
COPY ./docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite
RUN a2ensite 000-default

WORKDIR /var/www/html

# Expose port 80
EXPOSE 80/tcp

# Start Apache in foreground
CMD ["apache2-foreground"]
