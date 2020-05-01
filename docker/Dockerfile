FROM node:alpine AS frontend-builder

COPY . /app
WORKDIR /app

RUN npm install; \
    npm run build


FROM nginx:alpine AS rtmpie-nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

COPY public /var/www/public
COPY --from=frontend-builder /app/public/build /var/www/public/build

WORKDIR /var/www/public


FROM php:7.4-fpm-alpine AS rtmpie-php

RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
    ; \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j$(nproc) \
    intl \
    zip \
    pdo_mysql \
    ; \
    pecl install apcu; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
    ; \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
    apk del .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/conf.d/php.ini $PHP_INI_DIR/conf.d/rtmpie.ini

COPY ./ /var/www
COPY --from=frontend-builder /app/public/build /var/www/public/build

WORKDIR /var/www

RUN mkdir -p var/cache var/log

ENV APP_ENV prod
ENV SYMFONY_ENV prod
ENV APP_DEBUG 0
ENV DATABASE_URL mysql://root:rtmpie@database:3306/rtmpie?serverVersion=mariadb-10.4.12
ENV MERCURE_PUBLISH_URL http://mercure/.well-known/mercure
ENV RTMP_THUMBNAILS_BASE_URL http://rtmp/thumbnails/

RUN composer install --prefer-dist --no-dev --no-progress --no-suggest --no-interaction --optimize-autoloader

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

RUN chown -R www-data:www-data .

USER www-data

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]


FROM ngrie/nginx-rtmp:latest AS rtmpie-rtmp

RUN apk --no-cache add ffmpeg

RUN mkdir -p /var/thumbnails /tmp/thumbnail_recordings && \
    chown -R nginx:nginx /var/thumbnails && \
    chmod -R 770 /var/thumbnails && \
    chown -R nginx:nginx /tmp/thumbnail_recordings && \
    chmod -R 770 /tmp/thumbnail_recordings

COPY docker/nginx-rtmp/nginx.conf /etc/nginx/nginx.conf

COPY docker/nginx-rtmp/create-thumbnail.sh /opt/create-thumbnail.sh
RUN chmod +x /opt/create-thumbnail.sh
