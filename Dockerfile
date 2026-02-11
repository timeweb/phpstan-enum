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

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php -v || exit 1

# Run as non-root user
RUN useradd -m -u 1000 appuser && chown -R appuser:appuser /app
USER appuser
