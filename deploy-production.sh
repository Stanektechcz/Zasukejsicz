#!/bin/bash

# ===========================================
# Production Deployment Script
# ===========================================

set -e  # Exit on any error

echo "🚀 Starting PRODUCTION deployment..."
echo "===================================="

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

# Install/update npm dependencies
echo ""
echo "📦 Installing npm dependencies..."
npm ci --production

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
