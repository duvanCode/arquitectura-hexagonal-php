# ─────────────────────────────────────────────────────────────────────────────
# Imagen de producción: PHP 8.2-FPM + Nginx + Supervisor (Alpine)
# ─────────────────────────────────────────────────────────────────────────────
FROM php:8.2-fpm-alpine

LABEL maintainer="duvanCode"
LABEL description="Arquitectura Hexagonal PHP — contenedor de producción"

# ── Dependencias del sistema ──────────────────────────────────────────────────
RUN apk add --no-cache \
        nginx \
        supervisor \
        bash \
        netcat-openbsd \
        gettext \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/cache/apk/*

# ── Configuración PHP de producción ──────────────────────────────────────────
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# ── Configuración Nginx ───────────────────────────────────────────────────────
# Usar www-data como usuario de Nginx (igual que php-fpm)
RUN sed -i 's/user nginx;/user www-data;/' /etc/nginx/nginx.conf 2>/dev/null || true
# Plantilla — el entrypoint genera el .conf definitivo con envsubst
COPY docker/nginx/default.conf.template /etc/nginx/http.d/default.conf.template

# ── Configuración Supervisor ──────────────────────────────────────────────────
COPY docker/supervisor/supervisord.conf /etc/supervisor.d/app.ini

# ── Script de entrada ─────────────────────────────────────────────────────────
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# ── Código de la aplicación ───────────────────────────────────────────────────
WORKDIR /var/www/html
COPY . .

# Eliminar archivos sensibles que no deben estar en la imagen
RUN rm -f .env \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE ${APP_PORT:-8080}

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
