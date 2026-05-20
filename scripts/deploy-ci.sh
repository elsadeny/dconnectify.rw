#!/usr/bin/env bash

set -euo pipefail

if [[ "${EUID}" -ne 0 ]]; then
    echo "Run this script as root."
    exit 1
fi

APP_DIR="${1:-/var/www/connectify}"
APP_USER="${APP_USER:-www-data}"
PHP_VERSION="${PHP_VERSION:-8.4}"
PHP_BIN="${PHP_BIN:-/usr/bin/php${PHP_VERSION}}"
COMPOSER_BIN="${COMPOSER_BIN:-/usr/bin/composer}"
NPM_CACHE_DIR="${APP_DIR}/storage/.npm-cache"
QUEUE_SERVICE="${QUEUE_SERVICE:-connectify-queue}"
LOCK_FILE="/tmp/connectify-deploy.lock"

run_as_app_user() {
    sudo -u "${APP_USER}" "$@"
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

has_env_value() {
    local key="$1"
    local file="$2"

    grep -Eq "^${key}=.+" "${file}"
}

(
    flock -n 9 || {
        echo "Another deployment is already running."
        exit 1
    }

    cd "${APP_DIR}"

    mkdir -p \
        "${NPM_CACHE_DIR}" \
        "${APP_DIR}/storage/app/public" \
        "${APP_DIR}/storage/framework/cache/data" \
        "${APP_DIR}/storage/framework/sessions" \
        "${APP_DIR}/storage/framework/views" \
        "${APP_DIR}/storage/logs" \
        "${APP_DIR}/bootstrap/cache"

    if [[ ! -f "${APP_DIR}/.env" ]]; then
        cp "${APP_DIR}/.env.example" "${APP_DIR}/.env"
    fi

    set_env_var APP_ENV production "${APP_DIR}/.env"
    set_env_var APP_DEBUG false "${APP_DIR}/.env"
    set_env_var DB_CONNECTION mysql "${APP_DIR}/.env"

    if [[ -n "${APP_URL:-}" ]]; then
        set_env_var APP_URL "${APP_URL}" "${APP_DIR}/.env"
    fi

    chown -R "${APP_USER}:${APP_USER}" "${APP_DIR}"
    chmod -R ug+rwx "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache"

    echo "Installing PHP dependencies..."
    run_as_app_user "${PHP_BIN}" "${COMPOSER_BIN}" install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction

    if ! has_env_value APP_KEY "${APP_DIR}/.env"; then
        echo "Generating missing Laravel app key..."
        run_as_app_user "${PHP_BIN}" artisan key:generate --force
    fi

    echo "Installing Node dependencies and building assets..."
    if [[ -f "${APP_DIR}/package-lock.json" ]]; then
        run_as_app_user npm ci --cache "${NPM_CACHE_DIR}"
    else
        run_as_app_user npm install --cache "${NPM_CACHE_DIR}"
    fi
    run_as_app_user npm run build --cache "${NPM_CACHE_DIR}"

    echo "Running Laravel deployment tasks..."
    run_as_app_user "${PHP_BIN}" artisan storage:link || true
    run_as_app_user "${PHP_BIN}" artisan migrate --force
    run_as_app_user "${PHP_BIN}" artisan optimize:clear
    run_as_app_user "${PHP_BIN}" artisan config:cache
    run_as_app_user "${PHP_BIN}" artisan route:cache
    run_as_app_user "${PHP_BIN}" artisan view:cache
    run_as_app_user "${PHP_BIN}" artisan event:cache

    chown -R "${APP_USER}:${APP_USER}" "${APP_DIR}"
    chmod -R ug+rwx "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache"

    if systemctl list-unit-files "${QUEUE_SERVICE}.service" >/dev/null 2>&1; then
        systemctl restart "${QUEUE_SERVICE}.service"
    fi

    if systemctl list-unit-files "php${PHP_VERSION}-fpm.service" >/dev/null 2>&1; then
        systemctl reload "php${PHP_VERSION}-fpm.service" || systemctl restart "php${PHP_VERSION}-fpm.service"
    fi

    echo "Deployment completed."
) 9>"${LOCK_FILE}"
