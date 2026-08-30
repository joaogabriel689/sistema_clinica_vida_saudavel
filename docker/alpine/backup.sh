#!/usr/bin/env sh
set -e

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
DB_HOST=${MYSQL_HOST:-db}
DB_NAME=${MYSQL_DATABASE:-clinica}
BACKUP_USER="backup_user"
BACKUP_PASS=${MYSQL_BACKUP_PASSWORD:-$MYSQL_PASSWORD}
BACKUP_DIR="/backups"

mkdir -p "$BACKUP_DIR"

FILE_PATH="${BACKUP_DIR}/${DB_NAME}_${TIMESTAMP}.sql"

echo "[$(date)] Iniciando backup do banco '${DB_NAME}'..."

if mysqldump --default-auth=mysql_native_password -h "$DB_HOST" -u "$BACKUP_USER" -p"$BACKUP_PASS" --single-transaction --quick "$DB_NAME" > "$FILE_PATH"; then
    echo "[$(date)] Backup concluído com sucesso: ${FILE_PATH}"
else
    echo "[$(date)] ERRO ao realizar backup do banco '${DB_NAME}'." >&2
    exit 1
fi
