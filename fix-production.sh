#!/bin/bash

# ===========================================
# Fix Production Issues Script
# Fixes storage symlink, permissions, and access issues
# ===========================================

set -e  # Exit on any error

echo "🔧 Fixing production issues..."
echo "=============================="

# 1. Recreate storage symlink
echo ""
echo "🔗 Recreating storage symlink..."
rm -rf public/storage 2>/dev/null || true
php artisan storage:link --force
echo "✅ Storage symlink created"

# 2. Fix all permissions
echo ""
echo "🔒 Fixing permissions..."

# Storage and bootstrap cache - need to be writable by web server
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
echo "  ✓ Storage and cache permissions set to 775"

# Public directory and subdirectories - need to be readable
chmod -R 755 public 2>/dev/null || true
echo "  ✓ Public directory permissions set to 755"

# Make public/storage readable
chmod -R 755 public/storage 2>/dev/null || true
echo "  ✓ Public storage permissions set to 755"

# 3. Set ownership (may need sudo)
echo ""
echo "👤 Setting ownership..."
if chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null; then
    echo "  ✅ Ownership set to www-data:www-data"
else
    echo "  ⚠️  Could not set ownership automatically"
    echo "  ℹ️  Run manually: sudo chown -R www-data:www-data storage bootstrap/cache public/storage"
fi

# 4. Clear all caches
echo ""
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
echo "✅ Caches cleared"

# 5. Rebuild caches
echo ""
echo "⚡ Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
echo "✅ Caches rebuilt"

# 6. Check storage structure
echo ""
echo "📁 Verifying storage structure..."
required_dirs=(
    "storage/app/public"
    "storage/framework/cache"
    "storage/framework/sessions"
    "storage/framework/views"
    "storage/logs"
)

for dir in "${required_dirs[@]}"; do
    if [ ! -d "$dir" ]; then
        mkdir -p "$dir"
        echo "  ✓ Created: $dir"
    else
        echo "  ✓ Exists: $dir"
    fi
done

# 7. Verify symlink
echo ""
echo "🔍 Verifying storage symlink..."
if [ -L "public/storage" ]; then
    target=$(readlink public/storage)
    echo "  ✅ Symlink exists: public/storage -> $target"
    if [ -d "$target" ]; then
        echo "  ✅ Target directory exists"
    else
        echo "  ❌ Target directory missing!"
    fi
else
    echo "  ❌ Symlink does not exist!"
fi

# 8. Test file creation
echo ""
echo "✍️  Testing write permissions..."
test_file="storage/logs/permission-test-$(date +%s).txt"
if echo "test" > "$test_file" 2>/dev/null; then
    echo "  ✅ Storage is writable"
    rm "$test_file"
else
    echo "  ❌ Storage is NOT writable!"
fi

echo ""
echo "✅ Fix completed!"
echo "================"
echo ""
echo "Next steps:"
echo "  1. If ownership warnings appeared, run: sudo chown -R www-data:www-data storage bootstrap/cache public/storage"
echo "  2. Restart PHP-FPM: sudo systemctl restart php-fpm"
echo "  3. Restart web server: sudo systemctl restart nginx (or apache2)"
echo "  4. Check Laravel logs: tail -f storage/logs/laravel.log"
