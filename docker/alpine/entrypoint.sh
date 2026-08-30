#!/usr/bin/env sh
set -e

# Carrega crontab
crontab /crontab.txt

echo "[$(date)] Container de Backup/Restore/Teste de Carga (Alpine) iniciado."
echo "[$(date)] Agendamento cron configurado:"
crontab -l

# Executa crond em foreground sob supervisão do tini
exec crond -f -l 2
