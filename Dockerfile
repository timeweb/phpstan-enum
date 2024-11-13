FROM php:7.4

# Enable phpdebug
RUN apt-get update \
    && apt-get install -y --no-install-recommends libxml2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-source extract \
    && cd /usr/src/php \
    && ./configure --enable-phpdbg \
    && docker-php-source delete

# Install composer and required packages
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
