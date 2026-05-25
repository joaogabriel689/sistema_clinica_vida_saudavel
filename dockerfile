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

# Redis PHP Extension
RUN pecl install redis && docker-php-ext-enable redis

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]