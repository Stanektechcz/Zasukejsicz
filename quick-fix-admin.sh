#!/bin/bash

# ===========================================
# Quick Admin Panel Access Fix
# ===========================================

echo "🔧 Quick fix for admin panel access..."
echo "======================================"

# 1. Clear all caches
echo ""
echo "🧹 Clearing caches..."
php artisan config:clear >/dev/null 2>&1
php artisan cache:clear >/dev/null 2>&1
php artisan route:clear >/dev/null 2>&1
php artisan view:clear >/dev/null 2>&1
php artisan permission:cache-reset >/dev/null 2>&1
echo "✅ Caches cleared"

# 2. Rebuild caches
echo ""
echo "⚡ Rebuilding caches..."
php artisan config:cache >/dev/null 2>&1
php artisan route:cache >/dev/null 2>&1
php artisan view:cache >/dev/null 2>&1
echo "✅ Caches rebuilt"

# 3. Generate shield permissions
echo ""
echo "🛡️  Generating permissions..."
php artisan shield:generate --all 2>/dev/null && echo "✅ Permissions generated" || echo "⚠️  Permissions already exist"

# 4. Verify admin user
echo ""
echo "👤 Verifying admin user..."
ADMIN_COUNT=$(php artisan tinker --execute="echo \App\Models\User::role('admin')->count();" 2>/dev/null | tail -1)
if [ "$ADMIN_COUNT" -gt 0 ]; then
    echo "✅ Found $ADMIN_COUNT admin user(s)"
    php artisan tinker --execute="\App\Models\User::role('admin')->get(['email'])->pluck('email')->each(fn(\$e) => print('  • ' . \$e . PHP_EOL));" 2>/dev/null | grep -v "Failed loading"
else
    echo "❌ No admin users found!"
    echo ""
    echo "Creating admin user..."
    read -p "Enter admin email: " ADMIN_EMAIL
    read -sp "Enter admin password: " ADMIN_PASSWORD
    echo ""
    
    php artisan tinker --execute="
        \$user = \App\Models\User::create([
            'name' => 'Admin',
            'email' => '$ADMIN_EMAIL',
            'password' => \Hash::make('$ADMIN_PASSWORD'),
            'email_verified_at' => now()
        ]);
        \$user->assignRole('admin');
        echo 'Admin user created: ' . \$user->email . PHP_EOL;
    " 2>/dev/null | grep -v "Failed loading"
fi

echo ""
echo "✅ Admin panel is ready!"
echo "======================="
echo ""
echo "Access admin panel:"
echo "  🌐 URL: $(php artisan route:list --json 2>/dev/null | grep -o '"uri":"admin[^"]*"' | head -1 | cut -d'"' -f4 || echo '/admin')"
echo "  👤 Login with your admin credentials"
echo ""
echo "Still having issues?"
echo "  • Clear browser cache and cookies"
echo "  • Try incognito/private browsing mode"
echo "  • Check: tail -f storage/logs/laravel.log"
