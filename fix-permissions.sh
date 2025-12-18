#!/bin/bash

# Laravel Permission Fix Script
# Run this script on your server after deployment

echo "==================================="
echo "Laravel Permission Fix Script"
echo "==================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Get the web server user
WEB_USER="www-data"
if [ -f /etc/redhat-release ]; then
    WEB_USER="apache"
fi

echo -e "${YELLOW}Detected web server user: $WEB_USER${NC}"
echo ""

# Fix storage permissions
echo -e "${GREEN}Fixing storage permissions...${NC}"
chmod -R 775 storage/
chown -R $WEB_USER:$WEB_USER storage/

# Fix bootstrap/cache permissions
echo -e "${GREEN}Fixing bootstrap/cache permissions...${NC}"
chmod -R 775 bootstrap/cache/
chown -R $WEB_USER:$WEB_USER bootstrap/cache/

# Create log file if it doesn't exist
echo -e "${GREEN}Creating log file...${NC}"
touch storage/logs/laravel.log
chmod 664 storage/logs/laravel.log
chown $WEB_USER:$WEB_USER storage/logs/laravel.log

# Clear Laravel caches
echo -e "${GREEN}Clearing Laravel caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Verify permissions
echo ""
echo -e "${YELLOW}Verifying permissions...${NC}"
ls -la storage/
ls -la storage/logs/
ls -la bootstrap/cache/

echo ""
echo -e "${GREEN}==================================="
echo "Permission fix completed!"
echo "===================================${NC}"
echo ""
echo "If you still have permission issues, run:"
echo "  sudo chmod -R 777 storage/"
echo "  sudo chmod -R 777 bootstrap/cache/"
echo ""