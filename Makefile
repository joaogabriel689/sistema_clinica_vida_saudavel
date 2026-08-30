.PHONY: backup restore restore-latest restore-file logs-restore tests up down restart build logs

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

logs:
	docker compose logs -f

backup:
	docker compose exec alpine sh /backup.sh

restore:
	docker compose exec alpine sh /restore.sh

restore-latest:
	docker compose exec alpine sh /restore.sh --yes

restore-file:
	@if [ -z "$(FILE)" ]; then \
		echo "Uso: make restore-file FILE=nome_do_arquivo.sql"; \
		exit 1; \
	fi
	docker compose exec alpine sh /restore.sh $(FILE)

logs-restore:
	docker compose exec alpine cat /var/log/alpine/restore.log

tests:
	docker compose exec alpine sh /load-test.sh
