#!/bin/bash

# ===========================================
# Check Web Server Configuration
# ===========================================

echo "🔍 Checking web server setup..."
echo "================================"

# 1. Check which web server is running
echo ""
echo "🌐 Web server check..."
if systemctl is-active --quiet nginx; then
    echo "✅ Nginx is running"
    WEB_SERVER="nginx"
elif systemctl is-active --quiet apache2; then
    echo "✅ Apache is running"
    WEB_SERVER="apache2"
else
    echo "⚠️  No web server detected"
    WEB_SERVER="none"
fi

# 2. Check document root
echo ""
echo "📂 Document root check..."
echo "Current directory: $(pwd)"
echo "Public directory exists: $([ -d "public" ] && echo "✅ Yes" || echo "❌ No")"
echo "index.php exists: $([ -f "public/index.php" ] && echo "✅ Yes" || echo "❌ No")"

# 3. Check .htaccess
echo ""
echo "📄 .htaccess check..."
if [ -f "public/.htaccess" ]; then
    echo "✅ public/.htaccess exists"
    echo "Contents:"
    head -10 public/.htaccess
else
    echo "❌ public/.htaccess missing!"
fi

# 4. Check PHP-FPM
echo ""
echo "🐘 PHP-FPM check..."
if systemctl is-active --quiet php8.3-fpm; then
    echo "✅ php8.3-fpm is running"
elif systemctl is-active --quiet php8.2-fpm; then
    echo "✅ php8.2-fpm is running"
elif systemctl is-active --quiet php-fpm; then
    echo "✅ php-fpm is running"
else
    echo "⚠️  PHP-FPM may not be running"
fi

# 5. Check nginx/apache config
echo ""
echo "⚙️  Web server configuration..."
if [ "$WEB_SERVER" == "nginx" ]; then
    echo "Nginx sites enabled:"
    ls -la /etc/nginx/sites-enabled/ 2>/dev/null || echo "Cannot access nginx config"
    
    echo ""
    echo "Looking for this project in nginx config..."
    grep -r "$(pwd)" /etc/nginx/sites-enabled/ 2>/dev/null | head -5 || echo "Not found in nginx config"
    
elif [ "$WEB_SERVER" == "apache2" ]; then
    echo "Apache sites enabled:"
    ls -la /etc/apache2/sites-enabled/ 2>/dev/null || echo "Cannot access apache config"
fi

# 6. Check web server error logs
echo ""
echo "📋 Recent web server errors..."
if [ "$WEB_SERVER" == "nginx" ]; then
    echo "Nginx error log (last 5 lines):"
    tail -5 /var/log/nginx/error.log 2>/dev/null || echo "Cannot access nginx error log"
elif [ "$WEB_SERVER" == "apache2" ]; then
    echo "Apache error log (last 5 lines):"
    tail -5 /var/log/apache2/error.log 2>/dev/null || echo "Cannot access apache error log"
fi

# 7. Test direct file access
echo ""
echo "🧪 Testing public/index.php accessibility..."
if [ -r "public/index.php" ]; then
    echo "✅ public/index.php is readable"
else
    echo "❌ public/index.php is NOT readable"
fi

echo ""
echo "File permissions:"
ls -la public/index.php
ls -la public/.htaccess 2>/dev/null || echo "No .htaccess"

# 8. Check if document root points to /public
echo ""
echo "⚠️  IMPORTANT: Your web server document root MUST point to:"
echo "   $(pwd)/public"
echo ""
echo "NOT to:"
echo "   $(pwd)"
echo ""
echo "If your document root is wrong, you'll get 500 errors!"

echo ""
echo "✅ Check complete!"
echo ""
echo "Common fixes for 500 errors:"
echo "  1. Web server document root should be: $(pwd)/public (not $(pwd))"
echo "  2. Restart web server: sudo systemctl restart $WEB_SERVER"
echo "  3. Restart PHP-FPM: sudo systemctl restart php-fpm"
echo "  4. Check web server logs for specific errors"
echo "  5. Ensure public/.htaccess exists and is readable"
