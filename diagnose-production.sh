#!/bin/bash

# ===========================================
# Production Diagnostics and Fix for Pages & Admin
# ===========================================

set -e

echo "🔍 Running production diagnostics..."
echo "===================================="

# 1. Check if pages exist in database
echo ""
echo "📊 Checking database..."
php artisan tinker --execute="
echo 'Pages in database: ' . App\Models\Page::count() . PHP_EOL;
echo 'Published pages: ' . App\Models\Page::where('is_published', true)->count() . PHP_EOL;
echo 'Users: ' . App\Models\User::count() . PHP_EOL;
echo 'Admin users: ' . App\Models\User::role('super_admin')->count() . PHP_EOL;
"

# 2. Seed pages if none exist
echo ""
echo "📄 Ensuring pages exist..."
PAGE_COUNT=$(php artisan tinker --execute="echo App\Models\Page::count();")
if [ "$PAGE_COUNT" == "0" ]; then
    echo "⚠️  No pages found, seeding pages..."
    php artisan db:seed --class=PageSeeder --force
    echo "✅ Pages seeded"
else
    echo "✅ Pages exist ($PAGE_COUNT pages)"
fi

# 3. Clear and rebuild all caches
echo ""
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

echo ""
echo "⚡ Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan filament:optimize

# 4. Check shield setup
echo ""
echo "🛡️  Checking Filament Shield..."
php artisan shield:install --fresh || echo "⚠️  Shield already configured"

# 5. Test database connection
echo ""
echo "🗄️  Testing database connection..."
php artisan db:show --database=mysql 2>/dev/null && echo "✅ Database connected" || echo "❌ Database connection failed!"

# 6. Check storage symlink
echo ""
echo "🔗 Checking storage symlink..."
if [ -L "public/storage" ]; then
    echo "✅ Storage symlink exists"
else
    echo "⚠️  Creating storage symlink..."
    php artisan storage:link --force
fi

# 7. Fix permissions
echo ""
echo "🔧 Fixing permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 755 public 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null || echo "⚠️  Run with sudo to fix ownership"

# 8. List all routes to verify
echo ""
echo "🗺️  Verifying routes..."
echo "Admin route:"
php artisan route:list --path=admin --columns=method,uri,name | head -5

echo ""
echo "Page routes:"
php artisan route:list --path=/ --columns=method,uri,name | grep -E "(pages|GET.*/$)" | head -10

# 9. Check for errors in logs
echo ""
echo "📋 Recent errors in Laravel log:"
if [ -f "storage/logs/laravel.log" ]; then
    tail -100 storage/logs/laravel.log | grep -i "error\|exception" | tail -5 || echo "No recent errors found"
else
    echo "⚠️  No log file found"
fi

# 10. Test page accessibility
echo ""
echo "🧪 Testing Page model..."
php artisan tinker --execute="
try {
    \$page = App\Models\Page::published()->first();
    if (\$page) {
        echo 'Sample page found: ' . \$page->slug . PHP_EOL;
        echo 'Title type: ' . gettype(\$page->title) . PHP_EOL;
        echo 'Content is array: ' . (is_array(\$page->content) ? 'yes' : 'no') . PHP_EOL;
    } else {
        echo '⚠️  No published pages found' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo '❌ Error: ' . \$e->getMessage() . PHP_EOL;
}
"

echo ""
echo "✅ Diagnostics complete!"
echo "======================="
echo ""
echo "If you're still seeing 500 errors:"
echo "  1. Check web server error logs: tail -f /var/log/nginx/error.log"
echo "  2. Check Laravel logs: tail -f storage/logs/laravel.log"
echo "  3. Enable debug mode temporarily in .env: APP_DEBUG=true"
echo "  4. Check PHP-FPM logs: tail -f /var/log/php-fpm/error.log"
echo "  5. Restart services: sudo systemctl restart php-fpm nginx"
