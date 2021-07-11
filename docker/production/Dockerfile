FROM phpswoole/swoole:php8.0-alpine

LABEL maintainer="Nick Pratley <nick@npratley.net>"

WORKDIR /var/www/html

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk add --no-cache supervisor icu-dev \
    && apk add --no-cache --virtual .build-deps linux-headers \
        make automake autoconf gcc g++ zlib-dev bzip2-dev \
        libzip-dev libxml2-dev gmp-dev openssl-dev yaml-dev \
    && docker-php-ext-install mysqli pdo_mysql pcntl intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

COPY docker/production/start-container /usr/local/bin/start-container
COPY docker/production/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/production/php.ini /etc/php/8.0/cli/conf.d/99-sail.ini
RUN chmod +x /usr/local/bin/start-container

ADD . /var/www/html

EXPOSE 80

ENTRYPOINT ["start-container"]
