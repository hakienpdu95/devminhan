#!/bin/bash
# deploy.sh — thuchocvn.vn (devminhan) deploy
# Chạy thủ công: bash deploy.sh
# Chạy migrate (chỉ khi quản trị chủ động muốn): bash deploy.sh --with-migrations
set -euo pipefail

APP_DIR="/var/www/devminhan"
PHP="/usr/bin/php8.4"
BRANCH="main"

cd "$APP_DIR"

# ── 0. Kéo code mới + re-exec ─────────────────────────────────
# QUAN TRỌNG: script này tự git reset đè lên chính file đang chạy. Nếu không
# re-exec, bash tiếp tục đọc phần còn lại từ file descriptor ĐÃ MỞ TRƯỚC khi
# git reset ghi đè — tức là chạy logic của LẦN DEPLOY TRƯỚC, không phải code
# vừa pull về. Re-exec đảm bảo toàn bộ phần sau bước này luôn đọc từ file
# mới nhất trên đĩa.
if [ -z "${DEPLOY_REEXEC:-}" ]; then
    echo "[$(date '+%H:%M:%S')] [0/6] Pulling latest code..."
    [ -f "$APP_DIR/.env" ] && cp "$APP_DIR/.env" /tmp/.env.devminhan-deploy.bak
    git fetch origin
    git reset --hard "origin/$BRANCH"
    [ -f /tmp/.env.devminhan-deploy.bak ] && mv /tmp/.env.devminhan-deploy.bak "$APP_DIR/.env"
    echo "[$(date '+%H:%M:%S')] ✓ Code updated → $(git log --oneline -1)"

    export DEPLOY_REEXEC=1
    exec bash "$APP_DIR/deploy.sh" "$@"
fi

# ── Flags ──────────────────────────────────────────────────────
# Mặc định KHÔNG chạy migrate VÀ KHÔNG tự build frontend trong deploy tự
# động — quản trị chủ động chạy tay khi cần:
#   php artisan migrate --force
#   npm run build   (đã map đúng vite.config.frontend.js trong package.json)
#
# Dùng flag dòng lệnh thay vì biến môi trường — biến môi trường có thể bị
# rò rỉ/đè bởi shell profile còn sót lại trên VPS, flag tường minh thì không.
SKIP_MIGRATIONS=true
SKIP_BUILD=true
for arg in "$@"; do
    case "$arg" in
        --with-migrations) SKIP_MIGRATIONS=false ;;
        --with-build)      SKIP_BUILD=false ;;
    esac
done

log() { echo "[$(date '+%H:%M:%S')] $*"; }
ok()  { echo "[$(date '+%H:%M:%S')] ✓ $*"; }
err() { echo "[$(date '+%H:%M:%S')] ✗ $*" >&2; }

log "═══════════════════════════════════════"
log "  Deploy thuchocvn.vn (devminhan) — $(date '+%Y-%m-%d %H:%M:%S')"
log "  Branch: $BRANCH | Commit: $(git log --oneline -1) | Skip migrations: $SKIP_MIGRATIONS | Skip build: $SKIP_BUILD"
log "═══════════════════════════════════════"

# ── 1. PHP dependencies ────────────────────────────────────────
log "[1/6] Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --quiet
ok "Composer done"

# ── 2. Frontend build ──────────────────────────────────────────
if [ "$SKIP_BUILD" = "true" ]; then
    log "[2/6] Skipping frontend build (mặc định — dùng --with-build để bật, hoặc quản trị tự chạy: npm run build)"
else
    log "[2/6] Building frontend assets..."
    npm ci --prefer-offline --silent
    npm run build --silent
    ok "Frontend built → public/build/"
fi

# ── 3. Maintenance mode ────────────────────────────────────────
log "[3/6] Enabling maintenance mode..."
$PHP artisan config:clear
$PHP artisan down --retry=10
trap '$PHP artisan up; err "Deploy failed — maintenance mode disabled"' ERR

# ── 4. Migration ────────────────────────────────────────────────
if [ "$SKIP_MIGRATIONS" = "true" ]; then
    log "[4/6] Skipping migrations (mặc định — dùng --with-migrations để bật)"
else
    log "[4/6] Running database migrations..."
    $PHP artisan migrate --force
    ok "Migrations done"
fi

# ── 5. Rebuild cache ────────────────────────────────────────────
log "[5/6] Rebuilding application cache..."
$PHP artisan config:clear  && $PHP artisan config:cache
$PHP artisan route:clear   && $PHP artisan route:cache
$PHP artisan view:clear    && $PHP artisan view:cache
$PHP artisan event:clear   && $PHP artisan event:cache
ok "Cache rebuilt"

# ── 6. Reload PHP-FPM (xóa opcache) ──────────────────────────────
log "[6/6] Reloading PHP-FPM..."
# Opcache giữ bytecode compiled view/class cũ trong RAM của các worker PHP-FPM
# đang chạy — view:cache ghi file mới trên đĩa nhưng FPM không tự đọc lại nếu
# opcache.validate_timestamps=0. Reload PHP-FPM để worker mới load code mới.
if sudo systemctl reload php8.4-fpm 2>/dev/null; then
    ok "PHP-FPM reloaded (opcache cleared)"
else
    err "Không reload được PHP-FPM — opcache có thể vẫn giữ code cũ! Cần cấu hình sudoers cho lệnh: systemctl reload php8.4-fpm"
fi

$PHP artisan up
trap - ERR   # bỏ trap sau khi up thành công

# Không có Horizon/Reverb trong project này (QUEUE_CONNECTION=database, không
# dùng broadcast) — nếu sau này có queue worker chạy nền qua supervisor, thêm
# bước restart ở đây tương tự minhan/deploy.sh.

log ""
log "✅ Deploy hoàn tất — $(date '+%Y-%m-%d %H:%M:%S')"
log "   Commit: $(git log --oneline -1)"
