#!/bin/sh
set -e

echo "Aguardando conexão com o banco de dados MySQL..."
until php -r "
try {
    \$host = getenv('DB_HOST') ?: 'db';
    \$port = getenv('DB_PORT') ?: '3306';
    \$db   = getenv('DB_DATABASE') ?: 'clinica';
    \$user = getenv('DB_USERNAME') ?: 'clinica_user';
    \$pass = getenv('DB_PASSWORD') ?: 'clinica_password';
    \$pdo  = new PDO(\"mysql:host=\$host;port=\$port;dbname=\$db\", \$user, \$pass);
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
"; do
    sleep 2
done

echo "Conexão com o banco de dados estabelecida com sucesso!"

if [ ! -f /var/www/vendor/autoload.php ]; then
    echo "Instalando dependências do Composer..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f /var/www/.env ]; then
    echo "Criando arquivo .env..."
    cp .env.example .env
fi

if ! grep -q "APP_KEY=base64" .env; then
    echo "Gerando chave de aplicação (APP_KEY)..."
    php artisan key:generate --force
fi

echo "Executando migrations do banco de dados..."
php artisan migrate --force

echo "Criando link simbólico do storage..."
php artisan storage:link || true

exec "$@"
