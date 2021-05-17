FROM php:7.4-cli-alpine

RUN set -ex \
  && apk --no-cache add bash postgresql-dev \
  && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

