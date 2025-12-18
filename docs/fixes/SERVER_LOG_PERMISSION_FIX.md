# Server Log Permission Fix

## Problem
Error saat deploy ke server:
```
The stream or file "/var/www/html/sibm/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied
```

## Root Cause
- Laravel tidak memiliki permission untuk menulis ke folder `storage/logs/`
- Web server (Apache/Nginx) tidak memiliki akses write ke storage directory
- File ownership tidak sesuai dengan web server user

## Solutions

### 1. Fix Folder Permissions (Server)
```bash
# Set correct permissions for storage and bootstrap/cache
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/

# Set correct ownership (replace 'www-data' with your web server user)
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/

# Alternative: if using different web server user
sudo chown -R apache:apache storage/
sudo chown -R apache:apache bootstrap/cache/
```

### 2. Create Log File Manually (if needed)
```bash
# Create log file with correct permissions
sudo touch storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log
sudo chown www-data:www-data storage/logs/laravel.log
```

### 3. Alternative: Use Different Log Channel
Update `.env` to use a different log channel that doesn't require file permissions:

```env
# Change from 'stack' to 'errorlog' (uses system error log)
LOG_CHANNEL=errorlog

# Or use 'syslog' (uses system syslog)
LOG_CHANNEL=syslog
```

### 4. Disable Logging Temporarily (Emergency Fix)
If you need immediate access, temporarily disable detailed logging:

```env
LOG_LEVEL=emergency
APP_DEBUG=false
```

## Deployment Commands

### For cPanel/Shared Hosting:
```bash
# Usually permissions are handled automatically
# But you can try:
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### For VPS/Dedicated Server:
```bash
# Full permission fix
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### For Docker:
```bash
# Inside container
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
```

## Prevention

### 1. Add to Deployment Script
Create `deploy.sh`:
```bash
#!/bin/bash
# Set permissions after deployment
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 2. Update .gitignore for Logs
Ensure log files are ignored but folder structure is maintained:
```
# In storage/logs/.gitignore
*.log
!.gitignore
```

## Web Server Configuration

### Apache (.htaccess already configured)
The existing `.htaccess` should handle most cases.

### Nginx
Add to server block:
```nginx
location ~ ^/(storage|bootstrap/cache) {
    deny all;
    return 404;
}
```

## Troubleshooting

### Check Current Permissions:
```bash
ls -la storage/
ls -la storage/logs/
ls -la bootstrap/cache/
```

### Check Web Server User:
```bash
# For Apache
ps aux | grep apache
# For Nginx
ps aux | grep nginx
```

### Test Write Permission:
```bash
# Test if web server can write
sudo -u www-data touch storage/logs/test.log
```

## Status
Ready for server deployment with proper permissions

---

**Fix Date**: December 18, 2025  
**Issue**: Laravel log permission denied  
**Solution**: Set correct folder permissions and ownership  
**Status**: Server deployment ready