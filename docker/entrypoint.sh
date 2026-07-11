#!/bin/sh
set -e

echo "==> Corrigindo permissões..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "==> Criando diretórios necessários..."
mkdir -p /var/www/storage/framework/views \
         /var/www/storage/framework/cache/data \
         /var/www/storage/framework/sessions \
         /var/www/storage/logs \
         /var/www/bootstrap/cache

# Gera APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    echo "==> Gerando APP_KEY..."
    php artisan key:generate --force
fi

echo "==> Limpando cache..."
php artisan view:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

echo "==> Rodando migrations..."
php artisan migrate --force 2>/dev/null || true

echo "==> Criando tabelas de sessão e cache..."
php artisan session:table 2>/dev/null || true
php artisan cache:table 2>/dev/null || true
php artisan migrate --force 2>/dev/null || true

echo "==> Iniciando php-fpm..."
exec php-fpm