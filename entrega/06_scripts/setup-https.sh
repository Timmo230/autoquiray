#!/usr/bin/env bash
#
# setup-https.sh — provision Let's Encrypt TLS for AUTOQUIRAY.
#
# Requirements:
#   - Ubuntu Server 22.04+ with Apache 2.4 already serving AUTOQUIRAY on :80
#   - Public DNS A/AAAA record pointing autoquiray.local -> server IP
#     (in production replace with the real public FQDN, e.g. autoquiray.es)
#   - Outbound 443 to Let's Encrypt API
#
# What this script does:
#   1. Installs certbot + apache plugin.
#   2. Enables required apache modules (ssl, rewrite, headers, http2).
#   3. Issues a certificate via the apache plugin (HTTP-01 challenge).
#   4. Forces HTTP -> HTTPS redirect.
#   5. Hardens TLS (Mozilla "intermediate" profile) + HSTS.
#   6. Installs a systemd timer for automated renewal (already shipped by certbot).
#   7. Verifies renewal with --dry-run.

set -euo pipefail

DOMAIN="${1:-autoquiray.es}"
EMAIL="${2:-admin@autoquiray.es}"

[[ "$EUID" -eq 0 ]] || { echo "[FATAL] run as root"; exit 1; }

echo "[*] Installing certbot + python3-certbot-apache…"
apt-get update -qq
apt-get install -y certbot python3-certbot-apache

echo "[*] Enabling apache modules…"
a2enmod ssl rewrite headers http2

echo "[*] Issuing certificate for ${DOMAIN}…"
certbot --apache \
    --non-interactive \
    --agree-tos \
    --email "$EMAIL" \
    --domain "$DOMAIN" \
    --redirect \
    --hsts \
    --must-staple

# -------- Harden TLS profile (Mozilla "intermediate") --------
SSL_CONF="/etc/apache2/conf-available/ssl-hardening.conf"
cat > "$SSL_CONF" <<'EOF'
# Mozilla intermediate, generated 2026-05-20.
# https://ssl-config.mozilla.org/#server=apache&version=2.4&config=intermediate&openssl=3.0
SSLProtocol             all -SSLv3 -TLSv1 -TLSv1.1
SSLCipherSuite          ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384
SSLHonorCipherOrder     off
SSLSessionTickets       off
SSLUseStapling          on
SSLStaplingCache        "shmcb:logs/ssl_stapling(32768)"

Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
Header always set X-Content-Type-Options "nosniff"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"
EOF
a2enconf ssl-hardening

# -------- Reload + verify --------
apache2ctl configtest
systemctl reload apache2

echo "[*] Renewal dry-run…"
certbot renew --dry-run

echo "[OK] HTTPS provisioned for ${DOMAIN}"
echo "    Certificate path: /etc/letsencrypt/live/${DOMAIN}/"
echo "    Renewal timer:    systemctl status certbot.timer"
