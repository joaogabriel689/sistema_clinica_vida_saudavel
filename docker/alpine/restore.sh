#!/usr/bin/env sh
set -e

DB_HOST=${MYSQL_HOST:-db}
DB_NAME=${MYSQL_DATABASE:-clinica}
DB_USER=${MYSQL_USER:-clinica_user}
DB_PASS=${MYSQL_PASSWORD:-clinica_password}
BACKUP_DIR="/backups"
LOG_FILE="/var/log/alpine/restore.log"

mkdir -p "$(dirname "$LOG_FILE")"

SPECIFIED_FILE=""
AUTO_CONFIRM=false

for arg in "$@"; do
    case $arg in
        --yes|-y)
            AUTO_CONFIRM=true
            ;;
        *)
            if [ -z "$SPECIFIED_FILE" ]; then
                SPECIFIED_FILE="$arg"
            fi
            ;;
    esac
done

if [ -n "$SPECIFIED_FILE" ]; then
    if [ -f "$SPECIFIED_FILE" ]; then
        RESTORE_TARGET="$SPECIFIED_FILE"
    elif [ -f "${BACKUP_DIR}/${SPECIFIED_FILE}" ]; then
        RESTORE_TARGET="${BACKUP_DIR}/${SPECIFIED_FILE}"
    else
        echo "ERRO: Arquivo de backup '${SPECIFIED_FILE}' não foi encontrado." >&2
        exit 1
    fi
else
    RESTORE_TARGET=$(ls -t "${BACKUP_DIR}/${DB_NAME}_"*.sql 2>/dev/null | head -n 1 || true)
    if [ -z "$RESTORE_TARGET" ]; then
        echo "ERRO: Nenhum arquivo de backup encontrado em ${BACKUP_DIR}." >&2
        exit 1
    fi
fi

echo "=========================================="
echo "ALVO DE RESTAURAÇÃO: ${RESTORE_TARGET}"
echo "BANCO DE DADOS: ${DB_NAME} (Host: ${DB_HOST})"
echo "=========================================="

if [ "$AUTO_CONFIRM" = false ]; then
    echo -n "⚠️ ATENÇÃO: Esta ação sobrescreverá os dados existentes! Digite 'sim' para continuar: "
    read CONFIRM
    if [ "$CONFIRM" != "sim" ]; then
        echo "Operação de restauração cancelada pelo usuário."
        exit 0
    fi
fi

# 1. Cria Snapshot de Segurança Pré-Restauração
PRE_TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
SNAPSHOT_FILE="${BACKUP_DIR}/pre_restore_${DB_NAME}_${PRE_TIMESTAMP}.sql"
echo "[$(date)] Criando snapshot de segurança automático em ${SNAPSHOT_FILE}..."
mysqldump --default-auth=mysql_native_password -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" --single-transaction "$DB_NAME" > "$SNAPSHOT_FILE" || echo "Aviso: Falha ao gerar snapshot pré-restauração (banco pode estar vazio)."

# 2. Executa a restauração
echo "[$(date)] Restaurando ${RESTORE_TARGET} no banco ${DB_NAME}..."
if mysql --default-auth=mysql_native_password -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$RESTORE_TARGET"; then
    MSG="[$(date)] SUCESSO: Restauração concluída de ${RESTORE_TARGET}"
    echo "$MSG"
    echo "$MSG" >> "$LOG_FILE"
else
    MSG="[$(date)] ERRO: Falha ao restaurar ${RESTORE_TARGET}"
    echo "$MSG" >&2
    echo "$MSG" >> "$LOG_FILE"
    exit 1
fi
