FROM php:8.4-cli

RUN set -ex \
  && apt update \
  && apt install bash zip \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

