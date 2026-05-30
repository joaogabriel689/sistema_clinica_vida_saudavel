FROM php:8.2-fpm

ENV TMPDIR=/tmp

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nodejs \
    npm \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        intl

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Cria os diretórios ANTES do composer install
RUN mkdir -p bootstrap/cache \
             storage/framework/views \
             storage/framework/cache/data \
             storage/framework/sessions \
             storage/logs \
    && chmod -R 775 bootstrap/cache storage

RUN composer install --no-interaction --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]