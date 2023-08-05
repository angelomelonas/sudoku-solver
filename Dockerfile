# syntax = docker/dockerfile:experimental

# Default to PHP 8.2, but we attempt to match
# the PHP version from the user (wherever `flyctl launch` is run)
# Valid version values are PHP 7.4+
ARG PHP_VERSION=8.2
FROM fideloper/fly-laravel:${PHP_VERSION} as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="symfony"

# Create a directory to store binaries
#RUN mkdir /var/www/html/bin

# RUN apt-get update && apt-get install -y \
#    git curl zip unzip rsync ca-certificates vim htop cron \
#    && apt-get clean \
#    && rm -rf /var/lib/apt/lists/*

# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

#WORKDIR /backend
WORKDIR backend

RUN composer install --optimize-autoloader --no-dev --no-scripts \
    && cp .fly/FlySymfonyRuntime.php /var/www/html/backend/src/FlySymfonyRuntime.php \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && cp .fly/entrypoint.sh /entrypoint \
    && chmod +x /entrypoint

#WORKDIR frontend

#FROM node:19 as build_frontend_assets
#
#RUN mkdir /app

# RUN #mkdir -p  /app
#WORKDIR /app
#COPY .. .

#RUN npm ci --no-audit && npm run build
#
#FROM base
#
COPY /frontend /var/www/html/public
#COPY --from=build_frontend_assets /app/public/build /var/www/html/public/build

EXPOSE 8080

ENTRYPOINT ["/entrypoint"]
