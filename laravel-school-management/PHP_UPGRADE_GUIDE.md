# PHP Upgrade Guide for Windows (XAMPP)

## Current Status
- **Current PHP Version**: 7.0.0
- **Required PHP Version**: 8.1 or higher
- **Installation Path**: C:\xampp\php\

## Option 1: Upgrade XAMPP (Recommended - Easiest)

### Step 1: Download Latest XAMPP
1. Visit: https://www.apachefriends.org/download.html
2. Download XAMPP with PHP 8.1 or 8.2 (latest stable version)
3. Choose the Windows installer

### Step 2: Backup Current XAMPP (Optional)
```cmd
# Backup your databases and projects
# Copy C:\xampp\htdocs to a safe location
# Export your MySQL databases if needed
```

### Step 3: Install New XAMPP
1. Run the downloaded installer
2. You can either:
   - **Install to a new location** (e.g., C:\xampp82) - keeps old version
   - **Uninstall old XAMPP first** then install to C:\xampp

### Step 4: Update System PATH
1. Press `Win + X` and select "System"
2. Click "Advanced system settings"
3. Click "Environment Variables"
4. Under "System variables", find "Path"
5. Edit and update the PHP path to your new XAMPP installation:
   - Old: `C:\xampp\php`
   - New: `C:\xampp\php` (or `C:\xampp82\php` if installed to new location)

### Step 5: Verify Installation
```cmd
# Close and reopen your terminal/command prompt
php --version
# Should show PHP 8.1.x or 8.2.x

php -m
# Should list all enabled extensions including fileinfo
```

## Option 2: Manual PHP Upgrade (Advanced)

### Step 1: Download PHP
1. Visit: https://windows.php.net/download/
2. Download PHP 8.1 or 8.2 (Thread Safe version for XAMPP)
3. Choose the ZIP package

### Step 2: Backup Current PHP
```cmd
# Rename current PHP folder
cd C:\xampp
rename php php_old_7.0
```

### Step 3: Extract New PHP
1. Extract the downloaded ZIP to `C:\xampp\php`
2. Copy `php.ini-development` to `php.ini`

### Step 4: Configure php.ini
Open `C:\xampp\php\php.ini` and enable these extensions (remove the semicolon):

```ini
extension=curl
extension=fileinfo
extension=gd
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip

# Set timezone
date.timezone = Asia/Jakarta

# Increase limits
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
memory_limit = 256M
```

### Step 5: Update Apache Configuration
Edit `C:\xampp\apache\conf\extra\httpd-xampp.conf`:

Find lines with PHP 7 references and update to PHP 8:
```apache
LoadModule php_module "C:/xampp/php/php8apache2_4.dll"
```

### Step 6: Restart Services
1. Open XAMPP Control Panel
2. Stop Apache and MySQL
3. Start Apache and MySQL
4. Check for errors

## Option 3: Use Laravel Herd (Modern Alternative)

### Why Laravel Herd?
- Includes PHP 8.2+ out of the box
- Automatic PHP version management
- No manual configuration needed
- Optimized for Laravel development

### Installation
1. Visit: https://herd.laravel.com/windows
2. Download and install Laravel Herd
3. It automatically handles PHP, Nginx, and database

## Verification Steps

After upgrading, run these commands:

```cmd
# Check PHP version
php --version

# Check installed extensions
php -m

# Verify fileinfo extension
php -m | findstr fileinfo

# Check composer
composer --version

# Test PHP configuration
php -r "echo 'PHP is working!';"
```

## Required PHP Extensions for Laravel

Ensure these extensions are enabled in `php.ini`:

```ini
✓ BCMath
✓ Ctype
✓ cURL
✓ DOM
✓ Fileinfo
✓ JSON
✓ Mbstring
✓ OpenSSL
✓ PCRE
✓ PDO
✓ Tokenizer
✓ XML
```

## After Successful Upgrade

Once PHP is upgraded, run these commands in your project:

```cmd
# Navigate to project
cd C:\xampp\htdocs\sibm\laravel-school-management

# Install dependencies
composer install

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seeders
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

## Troubleshooting

### Issue: "php is not recognized"
**Solution**: Update your PATH environment variable to include the new PHP directory

### Issue: "extension not found"
**Solution**: 
1. Check if the extension DLL exists in `C:\xampp\php\ext\`
2. Ensure the extension line in `php.ini` doesn't have a semicolon
3. Restart Apache

### Issue: Apache won't start
**Solution**:
1. Check Apache error logs: `C:\xampp\apache\logs\error.log`
2. Verify PHP module path in `httpd-xampp.conf`
3. Ensure no port conflicts (port 80, 443)

### Issue: Composer still uses old PHP
**Solution**:
```cmd
# Update composer to use new PHP
composer self-update
composer clear-cache
```

## Quick Reference

### XAMPP Control Panel Locations
- **Config**: C:\xampp\xampp-control.ini
- **Apache Config**: C:\xampp\apache\conf\httpd.conf
- **PHP Config**: C:\xampp\php\php.ini
- **MySQL Config**: C:\xampp\mysql\bin\my.ini

### Important Paths
- **PHP**: C:\xampp\php\
- **Apache**: C:\xampp\apache\
- **htdocs**: C:\xampp\htdocs\
- **MySQL**: C:\xampp\mysql\

## Next Steps

1. ✅ Upgrade PHP to 8.1+
2. ✅ Verify PHP version and extensions
3. ✅ Run `composer install` in project directory
4. ✅ Configure `.env` file
5. ✅ Run migrations and seeders
6. ✅ Start development server

## Need Help?

If you encounter issues:
1. Check XAMPP error logs
2. Verify PHP configuration with `php --ini`
3. Test PHP with `php -r "phpinfo();"`
4. Ensure all required extensions are enabled

---

**Note**: After upgrading, you may need to restart your computer for all PATH changes to take effect.
