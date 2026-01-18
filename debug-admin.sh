#!/bin/bash

# ===========================================
# Admin Panel Debug Script
# ===========================================

echo "🔍 Debugging admin panel access issue..."
echo "========================================"

# 1. Check if admin user exists
echo ""
echo "👤 Checking admin users..."
php artisan tinker --execute="echo '  Users with admin role: ' . \App\Models\User::role('admin')->count(); echo PHP_EOL;"
php artisan tinker --execute="\App\Models\User::role('admin')->get(['id', 'name', 'email'])->each(fn(\$u) => print('  - ' . \$u->email . PHP_EOL));"

# 2. Check roles and permissions
echo ""
echo "🔐 Checking roles..."
php artisan tinker --execute="echo '  Total roles: ' . Spatie\Permission\Models\Role::count(); echo PHP_EOL;"
php artisan tinker --execute="Spatie\Permission\Models\Role::all(['name'])->each(fn(\$r) => print('  - ' . \$r->name . PHP_EOL));"

# 3. Check Filament Shield setup
echo ""
echo "🛡️  Checking Filament Shield..."
php artisan shield:check 2>/dev/null || echo "  ⚠️  Shield check command not available"

# 4. Clear and cache everything
echo ""
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan permission:cache-reset

echo ""
echo "⚡ Rebuilding caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Check route list for admin
echo ""
echo "🔍 Checking admin routes..."
php artisan route:list --path=admin --columns=Method,URI,Name | head -20

echo ""
echo "✅ Debug completed!"
echo ""
echo "If admin panel still doesn't work:"
echo "  1. Ensure you're logged in with an admin user"
echo "  2. Run: php artisan shield:generate --all"
echo "  3. Check logs: tail -f storage/logs/laravel.log"
