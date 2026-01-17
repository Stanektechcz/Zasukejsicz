#!/bin/bash

# ===========================================
# Deployment Script for Staging/Production
# ===========================================

set -e  # Exit on any error

echo "🚀 Starting deployment..."
echo "========================="

# Pull latest changes from git
echo ""
echo "📥 Pulling latest changes from git..."
git pull

# Install/update composer dependencies (optional, uncomment if needed)
# echo ""
# echo "📦 Installing composer dependencies..."
# composer install --no-dev --optimize-autoloader

# Install/update npm dependencies (optional, uncomment if needed)
# echo ""
# echo "📦 Installing npm dependencies..."
# npm ci

# Build frontend assets
echo ""
echo "🔨 Building frontend assets..."
npm run build

# Clear all caches
echo ""
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run staging seed (includes migrate:fresh when --fresh is used)
# NOTE: The --fresh flag will run migrate:fresh internally and WIPE ALL DATA
# Remove --fresh if you only want to add more data without wiping
echo ""
echo "🌱 Running staging seeder..."
php artisan staging:seed --fresh --count=40 --force

echo ""
echo "✅ Deployment completed successfully!"
echo "========================="
