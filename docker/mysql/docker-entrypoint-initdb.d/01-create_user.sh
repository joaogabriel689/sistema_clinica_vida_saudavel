#!/usr/bin/env bash
set -e

if [ -z "$MYSQL_ROOT_PASSWORD" ] || [ -z "$MYSQL_DATABASE" ] || [ -z "$MYSQL_USER" ] || [ -z "$MYSQL_PASSWORD" ] || [ -z "$MYSQL_BACKUP_PASSWORD" ]; then
    echo "ERRO: Variáveis MYSQL_ROOT_PASSWORD, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD e MYSQL_BACKUP_PASSWORD precisam estar definidas."
    exit 1
fi

mysql -u root -p"$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS \`${MYSQL_DATABASE}\`;

    -- Usuário da Aplicação
    CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';
    ALTER USER '${MYSQL_USER}'@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_PASSWORD}';
    GRANT ALL PRIVILEGES ON \`${MYSQL_DATABASE}\`.* TO '${MYSQL_USER}'@'%';

    -- Usuário DEDICADO de Backup (Privilégio mínimo para mysqldump)
    CREATE USER IF NOT EXISTS 'backup_user'@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_BACKUP_PASSWORD}';
    ALTER USER 'backup_user'@'%' IDENTIFIED WITH mysql_native_password BY '${MYSQL_BACKUP_PASSWORD}';
    GRANT SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER, RELOAD, PROCESS ON *.* TO 'backup_user'@'%';

    FLUSH PRIVILEGES;
EOSQL

echo "Usuários do MySQL (aplicação e backup_user) inicializados com sucesso."
