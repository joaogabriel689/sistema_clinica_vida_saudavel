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

echo "==> Limpando cache de views..."
php artisan view:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true

php artisan migrate --force 2>/dev/null || true

echo "==> Iniciando php-fpm..."
exec php-fpm