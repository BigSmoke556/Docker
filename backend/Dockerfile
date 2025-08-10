ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN mkdir -p /var/www/html && composer install --no-scripts --no-dev --prefer-dist || true

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000
CMD ["/entrypoint.sh"]
