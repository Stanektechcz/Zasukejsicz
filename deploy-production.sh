#!/bin/bash

# ===========================================
# Production Deployment Script
# ===========================================

set -e  # Exit on any error

echo "🚀 Starting PRODUCTION deployment..."
echo "===================================="

# Check Node.js version (Vite 5 requires Node 18+)
echo ""
echo "🔍 Checking Node.js version..."
NODE_VERSION=$(node -v | cut -d'v' -f2 | cut -d'.' -f1)
if [ "$NODE_VERSION" -lt 18 ]; then
    echo "❌ ERROR: Node.js 18+ required for Vite 5 (current: $(node -v))"
    echo "   Upgrade Node.js: https://nodejs.org/"
    exit 1
fi
echo "✅ Node.js $(node -v) is compatible"

# Automatically switch to production environment
echo ""
echo "🔄 Switching to production environment..."
./env-switch.sh production

# Put application in maintenance mode
echo ""
echo "🔒 Enabling maintenance mode..."
php artisan down --retry=60 || true

# Pull latest changes from git
echo ""
echo "📥 Pulling latest changes from git..."
git pull

# Install/update composer dependencies (production optimized)
echo ""
echo "📦 Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install/update npm dependencies (includes devDependencies needed for build)
echo ""
echo "📦 Installing npm dependencies..."
if [ -f "package-lock.json" ]; then
    npm ci
else
    echo "⚠️  No package-lock.json found, using npm install instead..."
    npm install
fi

# Build frontend assets (production)
echo ""
echo "🔨 Building frontend assets (production)..."
npm run build

# Clear all caches
echo ""
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Run database migrations (safe, no fresh)
echo ""
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Optimize application
echo ""
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan filament:optimize

# Optimize composer autoloader
echo ""
echo "⚡ Optimizing composer autoloader..."
composer dump-autoload --optimize --classmap-authoritative --no-dev

# Clear and optimize various caches
echo ""
echo "🎯 Final cache optimization..."
php artisan optimize
php artisan icons:cache 2>/dev/null || true

# Fix permissions
echo ""
echo "🔧 Fixing storage and cache permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "⚠️  Could not change owner (may need sudo)"

# Clear OPcache
echo ""
echo "🧹 Clearing OPcache..."
php artisan opcache:clear 2>/dev/null || echo "⚠️  OPcache not available or already cleared"

# Restart PHP-FPM (try common service names)
echo ""
echo "🔄 Restarting PHP-FPM..."
sudo systemctl restart php8.3-fpm 2>/dev/null || \
sudo systemctl restart php8.2-fpm 2>/dev/null || \
sudo systemctl restart php-fpm 2>/dev/null || \
echo "⚠️  Could not restart PHP-FPM (may need manual restart)"

# Restart queue workers if using supervisor/horizon
echo ""
echo "🔄 Restarting queue workers..."
php artisan queue:restart || echo "⚠️  No queue workers to restart"

# Bring application back online
echo ""
echo "🔓 Disabling maintenance mode..."
php artisan up

echo ""
echo "✅ PRODUCTION deployment completed successfully!"
echo "================================================"
