#!/usr/bin/env bash

set -euo pipefail

PROJECT_ROOT="/var/www/autoquiray"
APP_ENV_FILE="$PROJECT_ROOT/.env"
EXAMPLE_ENV_FILE="$PROJECT_ROOT/.env.example"

# Cambia solo estos valores cuando quieras mover la app a otra IP o dominio.
TARGET_SCHEME="http"
TARGET_HOST="192.168.1.248"
PLAUSIBLE_SCHEME="http"
PLAUSIBLE_HOST="192.168.1.248"
PLAUSIBLE_PORT="8000"
PLAUSIBLE_SCRIPT_PATH="/js/script.js"

APP_URL="${TARGET_SCHEME}://${TARGET_HOST}"
PLAUSIBLE_DOMAIN="${TARGET_HOST}"
PLAUSIBLE_SCRIPT_URL="${PLAUSIBLE_SCHEME}://${PLAUSIBLE_HOST}:${PLAUSIBLE_PORT}${PLAUSIBLE_SCRIPT_PATH}"

update_env_value() {
    local file="$1"
    local key="$2"
    local value="$3"

    if grep -q "^${key}=" "$file"; then
        sed -i "s|^${key}=.*|${key}=${value}|" "$file"
    else
        printf '\n%s=%s\n' "$key" "$value" >> "$file"
    fi
}

for env_file in "$APP_ENV_FILE" "$EXAMPLE_ENV_FILE"; do
    update_env_value "$env_file" "APP_URL" "$APP_URL"
    update_env_value "$env_file" "PLAUSIBLE_DOMAIN" "$PLAUSIBLE_DOMAIN"
    update_env_value "$env_file" "PLAUSIBLE_SCRIPT_URL" "$PLAUSIBLE_SCRIPT_URL"
done

php "$PROJECT_ROOT/artisan" optimize:clear

printf 'Host actualizado.\n'
printf 'APP_URL=%s\n' "$APP_URL"
printf 'PLAUSIBLE_DOMAIN=%s\n' "$PLAUSIBLE_DOMAIN"
printf 'PLAUSIBLE_SCRIPT_URL=%s\n' "$PLAUSIBLE_SCRIPT_URL"
