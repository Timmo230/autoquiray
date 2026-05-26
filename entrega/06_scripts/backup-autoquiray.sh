#!/usr/bin/env bash
#
# backup-autoquiray.sh
# Backup script for AUTOQUIRAY — dumps MariaDB + tar of Laravel storage/.env,
# encrypts the resulting archive with GPG and pushes it to the NAS.
#
# Retention scheme (handled by find -mtime below):
#   - daily:    keep last 7
#   - weekly:   keep last 4   (saturdays)
#   - monthly:  keep last 12  (1st of month)
#
# Crontab (root):
#   30 03 * * *  /opt/autoquiray/scripts/backup-autoquiray.sh daily   >> /var/log/autoquiray-backup.log 2>&1
#   45 03 * * 6  /opt/autoquiray/scripts/backup-autoquiray.sh weekly  >> /var/log/autoquiray-backup.log 2>&1
#   00 04 1 * *  /opt/autoquiray/scripts/backup-autoquiray.sh monthly >> /var/log/autoquiray-backup.log 2>&1

set -euo pipefail

# -------- Configuration --------
APP_PATH="/var/www/autoquiray"
DB_HOST="127.0.0.1"
DB_NAME="autoquiray"
DB_USER="backup"
DB_PASS_FILE="/etc/autoquiray/backup.pass"   # chmod 600, owned by root
GPG_RECIPIENT="backup@autoquiray.local"
NAS_MOUNT="/mnt/nas-backups"
LOCAL_STAGE="/var/backups/autoquiray"

TIER="${1:-daily}"   # daily | weekly | monthly
DATE="$(date +%F_%H%M)"
NAME="autoquiray_${TIER}_${DATE}"
WORK="${LOCAL_STAGE}/${NAME}"

# -------- Pre-flight checks --------
[[ -d "$APP_PATH" ]]    || { echo "[FATAL] APP_PATH missing"; exit 1; }
[[ -r "$DB_PASS_FILE" ]] || { echo "[FATAL] DB password file unreadable"; exit 1; }
mountpoint -q "$NAS_MOUNT" || { echo "[FATAL] NAS not mounted at $NAS_MOUNT"; exit 1; }

mkdir -p "$WORK"
trap 'rm -rf "$WORK"' EXIT

echo "[$(date -Is)] backup tier=${TIER} start"

# -------- 1. Database dump --------
mysqldump \
    --host="$DB_HOST" \
    --user="$DB_USER" \
    --password="$(cat "$DB_PASS_FILE")" \
    --single-transaction \
    --quick \
    --routines \
    --triggers \
    --events \
    --default-character-set=utf8mb4 \
    "$DB_NAME" \
    | gzip -9 > "${WORK}/${DB_NAME}.sql.gz"

# -------- 2. Application files --------
tar --create --gzip \
    --exclude='vendor' \
    --exclude='node_modules' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='storage/logs/*.log' \
    --file="${WORK}/app.tar.gz" \
    -C "$(dirname "$APP_PATH")" "$(basename "$APP_PATH")"

# -------- 3. Manifest --------
{
    echo "tier=${TIER}"
    echo "date=$(date -Is)"
    echo "host=$(hostname -f)"
    echo "app_path=${APP_PATH}"
    echo "db_name=${DB_NAME}"
    echo "git_rev=$(git -C "$APP_PATH" rev-parse --short HEAD 2>/dev/null || echo unknown)"
    echo
    echo "# sha256"
    (cd "$WORK" && sha256sum ./*)
} > "${WORK}/MANIFEST.txt"

# -------- 4. Pack + encrypt --------
ARCHIVE="${LOCAL_STAGE}/${NAME}.tar"
tar --create --file="$ARCHIVE" -C "$LOCAL_STAGE" "$NAME"

gpg --batch --yes --trust-model always \
    --recipient "$GPG_RECIPIENT" \
    --output "${ARCHIVE}.gpg" \
    --encrypt "$ARCHIVE"
rm -f "$ARCHIVE"

# -------- 5. Ship to NAS --------
DEST="${NAS_MOUNT}/${TIER}"
mkdir -p "$DEST"
mv "${ARCHIVE}.gpg" "$DEST/"

# -------- 6. Rotation --------
case "$TIER" in
    daily)   find "$DEST" -name 'autoquiray_daily_*.tar.gpg'   -type f -mtime +7   -delete ;;
    weekly)  find "$DEST" -name 'autoquiray_weekly_*.tar.gpg'  -type f -mtime +30  -delete ;;
    monthly) find "$DEST" -name 'autoquiray_monthly_*.tar.gpg' -type f -mtime +365 -delete ;;
esac

echo "[$(date -Is)] backup tier=${TIER} ok -> ${DEST}/${NAME}.tar.gpg"
