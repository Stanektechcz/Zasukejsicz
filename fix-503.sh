#!/bin/bash

# ===========================================
# 503 Error Troubleshooting & Fix Script
# ===========================================

echo "🔍 Troubleshooting 503 Service Unavailable..."
echo "============================================="

# 1. Check if app is in maintenance mode
echo ""
echo "1️⃣  Checking maintenance mode..."
if [ -f "storage/framework/down" ]; then
    echo "❌ App is in MAINTENANCE MODE!"
    echo "   Bringing application online..."
    php artisan up
    echo "✅ Maintenance mode disabled"
else
    echo "✅ App is not in maintenance mode"
fi

# 2. Check storage permissions
echo ""
echo "2️⃣  Checking storage permissions..."
if [ ! -w "storage/logs" ]; then
    echo "❌ Storage directory not writable!"
    echo "   Fixing permissions..."
    chmod -R 775 storage bootstrap/cache
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "⚠️  Run with sudo to change ownership"
    echo "✅ Permissions fixed"
else
    echo "✅ Storage is writable"
fi

# 3. Check .env file
echo ""
echo "3️⃣  Checking .env file..."
if [ ! -f ".env" ]; then
    echo "❌ .env file is MISSING!"
    echo "   Please run: ./env-switch.sh production"
    exit 1
else
    echo "✅ .env file exists"
    APP_ENV=$(grep "^APP_ENV=" .env | cut -d '=' -f2)
    APP_DEBUG=$(grep "^APP_DEBUG=" .env | cut -d '=' -f2)
    echo "   Environment: $APP_ENV"
    echo "   Debug: $APP_DEBUG"
fi

# 4. Clear all caches
echo ""
echo "4️⃣  Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
echo "✅ Caches cleared"

# 5. Rebuild caches
echo ""
echo "5️⃣  Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
echo "✅ Caches rebuilt"

# 6. Check database connection
echo ""
echo "6️⃣  Testing database connection..."
php artisan db:show 2>/dev/null && echo "✅ Database connected" || echo "❌ Database connection failed!"

# 7. Clear OPcache
echo ""
echo "7️⃣  Clearing OPcache..."
php artisan opcache:clear 2>/dev/null && echo "✅ OPcache cleared" || echo "⚠️  OPcache not available"

# 8. Restart PHP-FPM
echo ""
echo "8️⃣  Restarting PHP-FPM..."
echo "   Trying common PHP-FPM service names..."
if sudo systemctl restart php8.3-fpm 2>/dev/null; then
    echo "✅ php8.3-fpm restarted"
elif sudo systemctl restart php8.2-fpm 2>/dev/null; then
    echo "✅ php8.2-fpm restarted"
elif sudo systemctl restart php-fpm 2>/dev/null; then
    echo "✅ php-fpm restarted"
else
    echo "⚠️  Could not restart PHP-FPM automatically"
    echo "   Please manually restart: sudo systemctl restart php-fpm"
fi

# 9. Check logs
echo ""
echo "9️⃣  Recent errors in Laravel log:"
echo "=================================="
if [ -f "storage/logs/laravel.log" ]; then
    tail -n 20 storage/logs/laravel.log
else
    echo "⚠️  No log file found"
fi

# 10. Final status
echo ""
echo "✅ Troubleshooting complete!"
echo "============================"
echo ""
echo "If 503 persists, check:"
echo "  • Web server error logs: /var/log/nginx/error.log or /var/log/apache2/error.log"
echo "  • PHP-FPM logs: /var/log/php-fpm/error.log"
echo "  • Laravel logs: storage/logs/laravel.log"
echo ""
echo "Common fixes:"
echo "  1. Restart web server: sudo systemctl restart nginx"
echo "  2. Check PHP-FPM status: sudo systemctl status php-fpm"
echo "  3. Increase PHP memory: update php.ini memory_limit"
echo "  4. Check disk space: df -h"
