#!/usr/bin/env bash
#
# restore-autoquiray.sh — restore a previously generated AUTOQUIRAY backup.
#
# Usage:
#   sudo ./restore-autoquiray.sh /mnt/nas-backups/daily/autoquiray_daily_2026-05-18_0330.tar.gpg
#
# Safety:
#   - Refuses to run if APP_PATH is not empty and --force is not given.
#   - DB is restored to a *new* schema first, then renamed atomically.

set -euo pipefail

ARCHIVE="${1:-}"
FORCE="${2:-}"
APP_PATH="/var/www/autoquiray"
DB_HOST="127.0.0.1"
DB_NAME="autoquiray"
DB_USER="root"

[[ -n "$ARCHIVE" ]]     || { echo "Usage: $0 <archive.tar.gpg> [--force]"; exit 1; }
[[ -r "$ARCHIVE" ]]     || { echo "[FATAL] archive not readable"; exit 1; }
[[ "$EUID" -eq 0 ]]     || { echo "[FATAL] run as root"; exit 1; }

if [[ -d "$APP_PATH" && -n "$(ls -A "$APP_PATH" 2>/dev/null)" && "$FORCE" != "--force" ]]; then
    echo "[FATAL] $APP_PATH not empty. Re-run with --force to overwrite."
    exit 1
fi

TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT

echo "[*] decrypting…"
gpg --batch --yes --output "${TMP}/payload.tar" --decrypt "$ARCHIVE"

echo "[*] extracting…"
tar --extract --file="${TMP}/payload.tar" -C "$TMP"
INNER="$(find "$TMP" -maxdepth 1 -type d -name 'autoquiray_*' | head -n1)"

echo "[*] verifying checksums…"
(cd "$INNER" && sha256sum -c <(grep -E '^[a-f0-9]{64}  ' MANIFEST.txt))

echo "[*] restoring DB to staging schema…"
STAGING="${DB_NAME}_restore_$$"
mysql --host="$DB_HOST" --user="$DB_USER" -e "CREATE DATABASE \`$STAGING\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
zcat "${INNER}/${DB_NAME}.sql.gz" | mysql --host="$DB_HOST" --user="$DB_USER" "$STAGING"

echo "[*] swapping schemas…"
mysql --host="$DB_HOST" --user="$DB_USER" <<SQL
DROP DATABASE IF EXISTS \`${DB_NAME}_old\`;
RENAME TABLE
$(mysql -N -B --user="$DB_USER" "$DB_NAME" -e "SHOW TABLES" 2>/dev/null \
    | awk -v old="$DB_NAME" -v new="${DB_NAME}_old" '{print "  `"old"`.`"$1"` TO `"new"`.`"$1"`,"}' \
    | sed '$ s/,$//');
SQL

mysql --host="$DB_HOST" --user="$DB_USER" -e "DROP DATABASE IF EXISTS \`${DB_NAME}\`; CREATE DATABASE \`${DB_NAME}\` CHARACTER SET utf8mb4;"
mysql --host="$DB_HOST" --user="$DB_USER" -N -B "$STAGING" -e "SHOW TABLES" \
    | while read -r t; do
        mysql --host="$DB_HOST" --user="$DB_USER" \
            -e "RENAME TABLE \`${STAGING}\`.\`${t}\` TO \`${DB_NAME}\`.\`${t}\`;"
      done
mysql --host="$DB_HOST" --user="$DB_USER" -e "DROP DATABASE \`${STAGING}\`;"

echo "[*] restoring app files…"
rm -rf "$APP_PATH"
mkdir -p "$(dirname "$APP_PATH")"
tar --extract --gzip --file="${INNER}/app.tar.gz" -C "$(dirname "$APP_PATH")"
chown -R www-data:www-data "$APP_PATH"

echo "[*] running composer + migrations…"
sudo -u www-data composer install --no-dev --optimize-autoloader -d "$APP_PATH"
sudo -u www-data php "$APP_PATH/artisan" migrate --force
sudo -u www-data php "$APP_PATH/artisan" config:cache

systemctl reload apache2
systemctl restart autoquiray-queue.service

echo "[OK] restore complete."
