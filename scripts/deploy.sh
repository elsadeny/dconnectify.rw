#!/usr/bin/env bash

set -euo pipefail

if [[ "${EUID}" -ne 0 ]]; then
    echo "Run this script as root or with sudo."
    exit 1
fi

APP_HOST="${1:-}"
APP_DIR="${2:-/var/www/connectify}"
APP_USER="www-data"
PHP_VERSION="8.3"
SOURCE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
ENV_FILE="${APP_DIR}/.env"
SQLITE_FILE="${APP_DIR}/database/database.sqlite"
QUEUE_SERVICE="connectify-queue"
SCHEDULE_SERVICE="connectify-schedule"
SCHEDULE_TIMER="${SCHEDULE_SERVICE}.timer"
NGINX_SITE="connectify"

if [[ -z "${APP_HOST}" ]]; then
    echo "Usage: sudo bash scripts/fresh-vps-deploy.sh <domain-or-ip> [app-dir]"
    exit 1
fi

export DEBIAN_FRONTEND=noninteractive

require_command() {
    local command_name="$1"

    if ! command -v "${command_name}" >/dev/null 2>&1; then
        echo "Missing required command: ${command_name}"
        exit 1
    fi
}

set_env_var() {
    local key="$1"
    local value="$2"
    local file="$3"

    if grep -q "^${key}=" "${file}"; then
        sed -i "s#^${key}=.*#${key}=${value}#" "${file}"
    else
        printf '\n%s=%s\n' "${key}" "${value}" >>"${file}"
    fi
}

write_systemd_units() {
    cat <<EOF >/etc/systemd/system/${QUEUE_SERVICE}.service
[Unit]
Description=Connectify queue worker
After=network.target

[Service]
User=${APP_USER}
Group=${APP_USER}
Restart=always
RestartSec=5
WorkingDirectory=${APP_DIR}
ExecStart=/usr/bin/php ${APP_DIR}/artisan queue:work --sleep=3 --tries=3 --timeout=90

[Install]
WantedBy=multi-user.target
EOF

    cat <<EOF >/etc/systemd/system/${SCHEDULE_SERVICE}.service
[Unit]
Description=Run Connectify scheduler
After=network.target

[Service]
Type=oneshot
User=${APP_USER}
Group=${APP_USER}
WorkingDirectory=${APP_DIR}
ExecStart=/usr/bin/php ${APP_DIR}/artisan schedule:run
EOF

    cat <<EOF >/etc/systemd/system/${SCHEDULE_TIMER}
[Unit]
Description=Run Connectify scheduler every minute

[Timer]
OnBootSec=30s
OnUnitActiveSec=60s
Unit=${SCHEDULE_SERVICE}.service

[Install]
WantedBy=timers.target
EOF
}

write_nginx_site() {
    cat <<EOF >/etc/nginx/sites-available/${NGINX_SITE}
server {
    listen 80;
    listen [::]:80;
    server_name ${APP_HOST};

    root ${APP_DIR}/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php${PHP_VERSION}-fpm.sock;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

    ln -sfn /etc/nginx/sites-available/${NGINX_SITE} /etc/nginx/sites-enabled/${NGINX_SITE}
    rm -f /etc/nginx/sites-enabled/default
}

echo "Installing system packages..."
apt-get update
apt-get install -y software-properties-common ca-certificates curl gnupg unzip git rsync nginx sqlite3 acl

echo "Installing Node.js 22..."
mkdir -p /etc/apt/keyrings
if [[ ! -f /etc/apt/keyrings/nodesource.gpg ]]; then
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
fi
cat <<EOF >/etc/apt/sources.list.d/nodesource.list
deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_22.x nodistro main
EOF

apt-get update
apt-get install -y nodejs

echo "Installing PHP ${PHP_VERSION} and Composer..."
apt-get install -y \
    composer \
    php${PHP_VERSION} \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-sqlite3 \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-zip

require_command composer
require_command npm
require_command php
require_command rsync

mkdir -p "${APP_DIR}"

echo "Syncing application into ${APP_DIR}..."
rsync -a --delete \
    --exclude='.env' \
    --exclude='.git/' \
    --exclude='node_modules/' \
    --exclude='vendor/' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='storage/logs/*' \
    --exclude='bootstrap/cache/*.php' \
    "${SOURCE_DIR}/" "${APP_DIR}/"

mkdir -p \
    "${APP_DIR}/storage/app/public" \
    "${APP_DIR}/storage/framework/cache/data" \
    "${APP_DIR}/storage/framework/sessions" \
    "${APP_DIR}/storage/framework/views" \
    "${APP_DIR}/storage/logs" \
    "${APP_DIR}/bootstrap/cache" \
    "${APP_DIR}/database"

touch "${SQLITE_FILE}"

if ! id -u "${APP_USER}" >/dev/null 2>&1; then
    echo "Expected application user ${APP_USER} to exist."
    exit 1
fi

chown -R ${APP_USER}:${APP_USER} "${APP_DIR}"
chmod -R ug+rwx "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache"

if [[ ! -f "${ENV_FILE}" ]]; then
    cp "${APP_DIR}/.env.example" "${ENV_FILE}"
fi

set_env_var APP_ENV production "${ENV_FILE}"
set_env_var APP_DEBUG false "${ENV_FILE}"
set_env_var APP_URL http://${APP_HOST} "${ENV_FILE}"
set_env_var DB_CONNECTION sqlite "${ENV_FILE}"
set_env_var SESSION_DRIVER file "${ENV_FILE}"
set_env_var CACHE_STORE file "${ENV_FILE}"
set_env_var QUEUE_CONNECTION database "${ENV_FILE}"

echo "Installing PHP dependencies..."
sudo -u ${APP_USER} composer install \
    --working-dir="${APP_DIR}" \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

echo "Installing Node dependencies and building assets..."
if [[ -f "${APP_DIR}/package-lock.json" ]]; then
    sudo -u ${APP_USER} npm ci --prefix "${APP_DIR}"
else
    sudo -u ${APP_USER} npm install --prefix "${APP_DIR}"
fi
sudo -u ${APP_USER} npm run build --prefix "${APP_DIR}"

echo "Running Laravel production tasks..."
sudo -u ${APP_USER} php "${APP_DIR}/artisan" key:generate --force
sudo -u ${APP_USER} php "${APP_DIR}/artisan" storage:link || true
sudo -u ${APP_USER} php "${APP_DIR}/artisan" migrate --force
sudo -u ${APP_USER} php "${APP_DIR}/artisan" optimize:clear
sudo -u ${APP_USER} php "${APP_DIR}/artisan" config:cache
sudo -u ${APP_USER} php "${APP_DIR}/artisan" route:cache
sudo -u ${APP_USER} php "${APP_DIR}/artisan" view:cache
sudo -u ${APP_USER} php "${APP_DIR}/artisan" event:cache

write_systemd_units
write_nginx_site

echo "Enabling services..."
systemctl daemon-reload
systemctl enable --now php${PHP_VERSION}-fpm
systemctl enable --now ${QUEUE_SERVICE}.service
systemctl enable --now ${SCHEDULE_TIMER}

nginx -t
systemctl enable nginx
systemctl restart nginx

echo
echo "Connectify is deployed."
echo "App directory: ${APP_DIR}"
echo "Host: http://${APP_HOST}"
echo "Queue worker service: ${QUEUE_SERVICE}.service"
echo "Scheduler timer: ${SCHEDULE_TIMER}"
echo "For HTTPS, add a certificate after DNS points to this server."