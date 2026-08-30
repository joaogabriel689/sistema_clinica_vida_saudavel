FROM alpine:3.20

RUN apk add --no-cache \
    dcron \
    tini \
    mariadb-client \
    apache2-utils \
    curl \
    bash

COPY docker/alpine/crontab.txt /crontab.txt
COPY docker/alpine/entrypoint.sh /entrypoint.sh
COPY docker/alpine/backup.sh /backup.sh
COPY docker/alpine/restore.sh /restore.sh
COPY docker/alpine/load-test.sh /load-test.sh

RUN chmod +x /entrypoint.sh /backup.sh /restore.sh /load-test.sh

ENTRYPOINT ["/sbin/tini", "--", "/entrypoint.sh"]
