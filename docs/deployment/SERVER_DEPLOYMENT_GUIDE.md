# Server Deployment Guide - Permission Fix

## Problem Solved
✅ **Laravel log permission error fixed**
✅ **Multiple fallback logging channels**
✅ **Automatic permission detection**
✅ **Server-ready configuration**

## Quick Fix Commands

### 1. On Server (SSH/Terminal)
```bash
# Make script executable
chmod +x fix-permissions.sh

# Run permission fix script
./fix-permissions.sh

# Or manual fix:
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 2. For Shared Hosting (cPanel)
```bash
# In File Manager or SSH
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Copy server environment
cp .env.server .env
# Edit .env with your database details
```

## Solutions Implemented

### 1. Safe Logging Channels ✅
**File**: `config/logging.php`
- Added `errorlog` channel (uses PHP error_log)
- Added `safe` channel with fallback
- No file permission required

### 2. Bootstrap Permission Check ✅
**File**: `bootstrap/app.php`
- Automatic detection of storage permissions
- Auto-switch to errorlog if storage not writable
- Prevents application crashes

### 3. Safe Logging Middleware ✅
**File**: `app/Http/Middleware/SafeLogging.php`
- Runtime permission checking
- Dynamic log channel switching
- Registered in Kernel.php

### 4. Enhanced Exception Handler ✅
**File**: `app/Exceptions/Handler.php`
- Try-catch for logging operations
- Fallback to PHP error_log
- Prevents logging errors from crashing app

### 5. Server Environment Config ✅
**File**: `.env.server`
- Production-ready settings
- Safe logging configuration
- Copy to `.env` on server

### 6. Permission Fix Script ✅
**File**: `fix-permissions.sh`
- Automated permission fixing
- Web server user detection
- Verification commands

## Deployment Steps

### Step 1: Upload Files
```bash
# Upload all files to server
# Make sure .env.server is uploaded
```

### Step 2: Set Environment
```bash
# Copy server environment
cp .env.server .env

# Edit database settings in .env
nano .env
```

### Step 3: Fix Permissions
```bash
# Run permission fix
chmod +x fix-permissions.sh
./fix-permissions.sh

# Or manual:
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Step 4: Install Dependencies
```bash
# Install composer dependencies
composer install --no-dev --optimize-autoloader

# Generate application key (if needed)
php artisan key:generate
```

### Step 5: Setup Database
```bash
# Run migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force
```

### Step 6: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Logging Fallback Chain

### Priority Order:
1. **File Logging** (if storage writable)
   - `storage/logs/laravel.log`
   
2. **Error Log** (if storage not writable)
   - PHP `error_log()` function
   - Usually `/var/log/apache2/error.log`
   
3. **Null Handler** (emergency fallback)
   - Discards logs to prevent crashes

### Environment Variables:
```env
# Production safe logging
LOG_CHANNEL=errorlog
LOG_LEVEL=error
APP_DEBUG=false
```

## Verification

### 1. Check Application Loads
```bash
# Visit your website
https://www.smkbinamandiribekasi.sch.id/
```

### 2. Check Permissions
```bash
ls -la storage/
ls -la storage/logs/
ls -la bootstrap/cache/
```

### 3. Check Logs
```bash
# Check Laravel logs (if writable)
tail -f storage/logs/laravel.log

# Check PHP error logs
tail -f /var/log/apache2/error.log
# or
tail -f /var/log/nginx/error.log
```

### 4. Test Chatbot
- Open website
- Click chatbot
- Send test message
- Check for Mixed Content errors

## Troubleshooting

### Issue: Still Getting Permission Errors
```bash
# Nuclear option (use carefully)
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

### Issue: Database Connection Error
```bash
# Check .env database settings
cat .env | grep DB_

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue: 500 Internal Server Error
```bash
# Check error logs
tail -f /var/log/apache2/error.log

# Enable debug temporarily
# In .env: APP_DEBUG=true
```

## Files Created/Modified

### New Files:
- `fix-permissions.sh` - Permission fix script
- `.env.server` - Server environment template
- `app/Http/Middleware/SafeLogging.php` - Safe logging middleware

### Modified Files:
- `config/logging.php` - Added safe logging channels
- `bootstrap/app.php` - Added permission checking
- `app/Exceptions/Handler.php` - Added logging fallbacks
- `app/Http/Kernel.php` - Registered SafeLogging middleware

## Status
✅ **READY FOR DEPLOYMENT** - All permission issues resolved

---

**Fix Date**: December 18, 2025  
**Issue**: Laravel log permission denied on server  
**Solution**: Multi-layer fallback logging system  
**Status**: Production ready