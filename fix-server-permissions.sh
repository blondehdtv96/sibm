#!/bin/bash

# Fix Laravel Permissions on Server
# Run this script on your production server

echo "🔧 Fixing Laravel Permissions..."

# Get the web server user (usually www-data, apache, or nginx)
WEB_USER="www-data"

# If you're using Apache on CentOS/RHEL, use this:
# WEB_USER="apache"

# If you're using Nginx, use this:
# WEB_USER="nginx"

echo "📁 Setting ownership to $WEB_USER..."

# Set ownership of storage and bootstrap/cache
sudo chown -R $WEB_USER:$WEB_USER storage
sudo chown -R $WEB_USER:$WEB_USER bootstrap/cache

echo "🔐 Setting permissions..."

# Set directory permissions to 775
sudo find storage -type d -exec chmod 775 {} \;
sudo find bootstrap/cache -type d -exec chmod 775 {} \;

# Set file permissions to 664
sudo find storage -type f -exec chmod 664 {} \;
sudo find bootstrap/cache -type f -exec chmod 664 {} \;

# Ensure logs directory exists and has correct permissions
sudo mkdir -p storage/logs
sudo chown -R $WEB_USER:$WEB_USER storage/logs
sudo chmod -R 775 storage/logs

# Create laravel.log if it doesn't exist
sudo touch storage/logs/laravel.log
sudo chown $WEB_USER:$WEB_USER storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log

echo "✅ Permissions fixed!"

# Show current permissions
echo ""
echo "📊 Current permissions:"
ls -la storage/logs/

echo ""
echo "🎉 Done! Your Laravel app should now be able to write logs."
