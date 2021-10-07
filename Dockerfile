FROM php:7.4-cli-alpine

RUN set -ex \
  && apk --no-cache add bash zip mysql-dev \
  && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

