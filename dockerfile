FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# ... o resto do seu Dockerfile continua igual ...

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node/NPM para buildar os assets do Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /usr/src/myapp

# Copia tudo primeiro, depois instala dependências
COPY . .

# Instala dependências PHP e JS, builda assets
RUN composer install --no-interaction --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# REMOVA O BLOCO "RUN cp .env.example..." DAQUI

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]