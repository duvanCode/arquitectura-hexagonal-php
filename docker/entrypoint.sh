#!/bin/sh
set -e

# ─────────────────────────────────────────────────────────────────────────────
# Genera el archivo .env en tiempo de ejecución a partir de las
# variables de entorno inyectadas por Docker / Dokploy.
# ─────────────────────────────────────────────────────────────────────────────
cat > /var/www/html/.env <<EOF
# Generado automáticamente por el entrypoint — no editar a mano
DB_HOST=${DB_HOST:-db}
DB_PORT=${DB_PORT:-3306}
DB_NAME=${DB_NAME:-crud_usuarios}
DB_USER=${DB_USER:-appuser}
DB_PASSWORD=${DB_PASSWORD}
DB_CHARSET=${DB_CHARSET:-utf8mb4}

MAIL_HOST=${MAIL_HOST}
MAIL_PORT=${MAIL_PORT:-587}
MAIL_USERNAME=${MAIL_USERNAME}
MAIL_PASSWORD=${MAIL_PASSWORD}
MAIL_FROM=${MAIL_FROM}
MAIL_FROM_NAME=${MAIL_FROM_NAME:-App}
MAIL_ENCRYPTION=${MAIL_ENCRYPTION:-tls}
EOF

chmod 640 /var/www/html/.env

# ─────────────────────────────────────────────────────────────────────────────
# Ejecutar el Seeder si se solicita (útil en el primer despliegue)
# Para activarlo: variable de entorno RUN_SEEDER=true
# ─────────────────────────────────────────────────────────────────────────────
if [ "${RUN_SEEDER:-false}" = "true" ]; then
    echo "[entrypoint] Ejecutando Seeder de base de datos..."
    php /var/www/html/database/Seeder.php
    echo "[entrypoint] Seeder completado."
fi

echo "[entrypoint] Iniciando servicios..."
exec "$@"
