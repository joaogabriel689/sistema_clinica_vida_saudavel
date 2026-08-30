#!/usr/bin/env sh
set -e

TARGET_URL=${BASE_URL:-"http://nginx:80/"}
RESULTS_DIR="/results"

mkdir -p "$RESULTS_DIR"
RESULT_FILE="${RESULTS_DIR}/latest.txt"

echo "==========================================" > "$RESULT_FILE"
echo "TESTE DE CARGA DE APLICAÇÃO (Apache Bench)" >> "$RESULT_FILE"
echo "Alvo: ${TARGET_URL}" >> "$RESULT_FILE"
echo "Data: $(date)" >> "$RESULT_FILE"
echo "==========================================" >> "$RESULT_FILE"

echo "\n--- Rodada 1: 100 requisições / 5 concorrentes ---" >> "$RESULT_FILE"
ab -n 100 -c 5 "$TARGET_URL" >> "$RESULT_FILE" 2>&1

echo "\n--- Rodada 2: 1000 requisições / 20 concorrentes ---" >> "$RESULT_FILE"
ab -n 1000 -c 20 "$TARGET_URL" >> "$RESULT_FILE" 2>&1

echo "\n--- Rodada 3: 5000 requisições / 50 concorrentes ---" >> "$RESULT_FILE"
ab -n 5000 -c 50 "$TARGET_URL" >> "$RESULT_FILE" 2>&1

echo "Teste de carga concluído. Resultados salvos em ${RESULT_FILE}."
cat "$RESULT_FILE"
