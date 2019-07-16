FROM php:7.3

# Install composer and required packages
RUN apt-get update \
    && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/3c21a2c1affd88dd3fec6251e91a53e440bc2198/web/installer | php -- --quiet \
    && mv composer.phar /usr/bin/composer

# Enable phpdebug
RUN apt-get install -y libxml2-dev \
    && docker-php-source extract \
    && cd /usr/src/php \
    && ./configure --enable-phpdbg \
&& docker-php-source delete

WORKDIR /app
