FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Instalação de dependências do sistema e extensões do PHP
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    oniguruma-dev \
    icu-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && mkdir -p /usr/src/php/ext/redis \
    && curl -fsSL https://github.com/phpredis/phpredis/archive/refs/tags/6.0.2.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip-components=1 \
    && docker-php-ext-install pdo_mysql mbstring zip intl gd opcache redis \
    && apk del $PHPIZE_DEPS

# Criação de usuário não-root appuser (UID 1000)
RUN addgroup -g 1000 appuser && \
    adduser -u 1000 -G appuser -h /home/appuser -D appuser

# Copia Composer do estágio oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia código da aplicação
COPY --chown=appuser:appuser . /var/www

# Ajuste de permissões
RUN chmod +x /var/www/docker/entrypoint.sh \
    && mkdir -p storage bootstrap/cache logs \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R appuser:appuser /var/www

USER appuser

EXPOSE 9000

ENTRYPOINT ["/var/www/docker/entrypoint.sh"]

CMD ["php-fpm"]
