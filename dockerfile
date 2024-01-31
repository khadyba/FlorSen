FROM php:8.2-apache


WORKDIR /var/www/html

COPY . .



RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install required packages
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
        cron \
        vim \
        locales \
        coreutils \
        apt-utils \
        git \
        libicu-dev \
        g++ \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libxslt-dev \
        unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set up locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Install Composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

# Configure and install PHP extensions
# RUN docker-php-ext-configure intl \
#     && docker-php-ext-install pdo pdo_mysql mysqli gd opcache intl zip calendar dom mbstring gd xsl \
#     && a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql mysqli gd opcache intl calendar dom mbstring zip gd xsl && a2enmod rewrite
# Install and enable APCu extension
RUN pecl install apcu && docker-php-ext-enable apcu

