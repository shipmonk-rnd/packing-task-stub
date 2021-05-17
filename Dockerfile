FROM php:7.4-cli-alpine

RUN set -ex \
  && apk --no-cache add bash mysql-dev \
  && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

