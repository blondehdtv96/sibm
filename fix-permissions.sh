#!/bin/bash

# Laravel Permission Fix Script
# Run this script on your server after deployment
# Usage: sudo bash fix-permissions.sh

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

# Create required directories FIRST (before storage:link)
echo -e "${GREEN}Creating required directories...${NC}"
mkdir -p storage/app/public
mkdir -p storage/app/public/home_sliders
mkdir -p storage/app/public/uploads
mkdir -p storage/app/public/images
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/logs
mkdir -p bootstrap/cache

echo "  - storage/app/public created"
echo "  - storage/framework directories created"
echo "  - storage/logs created"
echo "  - bootstrap/cache created"
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

# Remove existing storage link if broken
echo -e "${GREEN}Checking storage link...${NC}"
if [ -L "public/storage" ]; then
    if [ ! -e "public/storage" ]; then
        echo "  Removing broken symlink..."
        rm public/storage
    else
        echo "  Storage link exists and is valid"
    fi
fi

# Create storage link
echo -e "${GREEN}Creating storage link...${NC}"
if [ ! -L "public/storage" ]; then
    # Method 1: Try artisan command
    php artisan storage:link 2>/dev/null
    
    if [ $? -ne 0 ]; then
        # Method 2: Create manually with relative path
        echo "  Artisan failed, creating manually..."
        cd public
        ln -sf ../storage/app/public storage
        cd ..
        echo "  Manual symlink created"
    else
        echo "  Storage link created via artisan"
    fi
else
    echo "  Storage link already exists"
fi

# Verify symlink
echo ""
echo -e "${YELLOW}Verifying storage link...${NC}"
if [ -L "public/storage" ]; then
    TARGET=$(readlink public/storage)
    echo "  public/storage -> $TARGET"
    if [ -d "public/storage" ]; then
        echo -e "  ${GREEN}✓ Link is valid${NC}"
    else
        echo -e "  ${RED}✗ Link is broken${NC}"
    fi
else
    echo -e "  ${RED}✗ Storage link not found${NC}"
fi

# Clear Laravel caches
echo ""
echo -e "${GREEN}Clearing Laravel caches...${NC}"
php artisan config:clear 2>/dev/null || echo "  config:clear skipped"
php artisan cache:clear 2>/dev/null || echo "  cache:clear skipped"
php artisan route:clear 2>/dev/null || echo "  route:clear skipped"
php artisan view:clear 2>/dev/null || echo "  view:clear skipped"

# Verify permissions
echo ""
echo -e "${YELLOW}Verifying permissions...${NC}"
ls -la storage/
echo ""
ls -la storage/app/public/
echo ""
ls -la public/ | grep storage

echo ""
echo -e "${GREEN}==================================="
echo "Permission fix completed!"
echo "===================================${NC}"
echo ""
echo "If images still don't show:"
echo "  1. Upload images via admin panel"
echo "  2. Check public/storage link points to storage/app/public"
echo ""
echo "If permission issues persist:"
echo "  sudo chmod -R 777 storage/"
echo "  sudo chmod -R 777 bootstrap/cache/"
echo ""