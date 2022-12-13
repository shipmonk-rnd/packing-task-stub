FROM php:8.2-cli

RUN set -ex \
  && apt update \
  && apt install bash zip \
  && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

