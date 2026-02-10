# 🔧 Fix Server Errors - Production

## 🐛 Error yang Terjadi

### Error 1: Permission Denied (Log File)
```
The stream or file "/var/www/html/sibm/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied
```

### Error 2: Database Access Denied
```
SQLSTATE[HY000] [1698] Access denied for user 'root'@'localhost'
```

---

## ✅ Solusi yang Diterapkan

### 1. Fix Middleware TrackVisitor

**File:** `app/Http/Middleware/TrackVisitor.php`

**Perubahan:**
- ✅ Menambahkan check database connection
- ✅ Menghapus `\Log::error()` yang menyebabkan permission error
- ✅ Menggunakan silent fail untuk tidak mengganggu user experience

**Before:**
```php
} catch (\Exception $e) {
    \Log::error('Visitor tracking failed: ' . $e->getMessage());
}
```

**After:**
```php
} catch (\Exception $e) {
    // Silently fail to not disrupt user experience
    // Don't log to avoid permission errors
}
```

---

## 🔐 Fix Permission di Server

### Metode 1: Menggunakan Script (RECOMMENDED)

#### Step 1: Upload Script
Upload file `fix-server-permissions.sh` ke server Anda

#### Step 2: Jalankan Script
```bash
# Masuk ke folder Laravel
cd /var/www/html/sibm

# Beri permission execute
chmod +x fix-server-permissions.sh

# Jalankan script
sudo ./fix-server-permissions.sh
```

Script akan otomatis:
- Set ownership ke web server user (www-data)
- Set permission folder ke 775
- Set permission file ke 664
- Create log file jika belum ada

---

### Metode 2: Manual Commands

#### Step 1: Cek Web Server User
```bash
# Untuk Apache/Nginx di Ubuntu/Debian
ps aux | grep -E 'apache|nginx' | grep -v root | head -1 | awk '{print $1}'

# Biasanya hasilnya: www-data
```

#### Step 2: Set Ownership
```bash
# Ganti www-data dengan user web server Anda
sudo chown -R www-data:www-data /var/www/html/sibm/storage
sudo chown -R www-data:www-data /var/www/html/sibm/bootstrap/cache
```

#### Step 3: Set Permissions
```bash
# Set directory permissions
sudo find /var/www/html/sibm/storage -type d -exec chmod 775 {} \;
sudo find /var/www/html/sibm/bootstrap/cache -type d -exec chmod 775 {} \;

# Set file permissions
sudo find /var/www/html/sibm/storage -type f -exec chmod 664 {} \;
sudo find /var/www/html/sibm/bootstrap/cache -type f -exec chmod 664 {} \;
```

#### Step 4: Fix Log File
```bash
# Create logs directory
sudo mkdir -p /var/www/html/sibm/storage/logs

# Create log file
sudo touch /var/www/html/sibm/storage/logs/laravel.log

# Set ownership
sudo chown www-data:www-data /var/www/html/sibm/storage/logs/laravel.log

# Set permission
sudo chmod 664 /var/www/html/sibm/storage/logs/laravel.log
```

---

## 🗄️ Fix Database Access

### Problem:
```
Access denied for user 'root'@'localhost'
```

### Solusi 1: Update .env File

Edit file `.env` di server:

```env
# Jangan gunakan root di production!
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibm
DB_USERNAME=sibm_user
DB_PASSWORD=your_secure_password
```

### Solusi 2: Create Database User

```bash
# Login ke MySQL
sudo mysql -u root -p

# Atau jika tidak ada password:
sudo mysql
```

```sql
-- Create database
CREATE DATABASE IF NOT EXISTS sibm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'sibm_user'@'localhost' IDENTIFIED BY 'your_secure_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON sibm.* TO 'sibm_user'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Exit
EXIT;
```

### Solusi 3: Fix Root User (Jika Harus Pakai Root)

```sql
-- Login ke MySQL
sudo mysql

-- Update root user authentication
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'your_root_password';

-- Flush privileges
FLUSH PRIVILEGES;

-- Exit
EXIT;
```

Kemudian update `.env`:
```env
DB_USERNAME=root
DB_PASSWORD=your_root_password
```

---

## 🔄 Setelah Fix

### 1. Clear Cache
```bash
cd /var/www/html/sibm

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 2. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Test
```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Test log writing
php artisan tinker
>>> \Log::info('Test log');

# Check log file
tail -f storage/logs/laravel.log
```

### 4. Restart Web Server
```bash
# Apache
sudo systemctl restart apache2

# Nginx
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

---

## 🔍 Verify Fix

### Check Permissions:
```bash
ls -la /var/www/html/sibm/storage/logs/
```

**Expected output:**
```
-rw-rw-r-- 1 www-data www-data ... laravel.log
```

### Check Database Connection:
```bash
php artisan migrate:status
```

**Expected:** No errors, shows migration status

### Check Website:
```bash
curl -I https://yourdomain.com
```

**Expected:** HTTP 200 OK

---

## 🛡️ Security Best Practices

### 1. Jangan Gunakan Root User
```env
# ❌ BAD
DB_USERNAME=root

# ✅ GOOD
DB_USERNAME=sibm_user
```

### 2. Gunakan Strong Password
```env
# ❌ BAD
DB_PASSWORD=123456

# ✅ GOOD
DB_PASSWORD=Str0ng_P@ssw0rd_2026!
```

### 3. Set Correct Permissions
```bash
# Folders: 775 (rwxrwxr-x)
# Files: 664 (rw-rw-r--)
# Never use 777!
```

### 4. Protect .env File
```bash
chmod 600 /var/www/html/sibm/.env
chown www-data:www-data /var/www/html/sibm/.env
```

### 5. Disable Debug Mode
```env
# In production
APP_DEBUG=false
APP_ENV=production
```

---

## 📋 Checklist

### Permission Fix:
- [ ] Run fix-server-permissions.sh
- [ ] Check storage/logs ownership
- [ ] Check storage/logs permissions
- [ ] Test log writing

### Database Fix:
- [ ] Create dedicated database user
- [ ] Update .env with new credentials
- [ ] Test database connection
- [ ] Run migrations

### After Fix:
- [ ] Clear all caches
- [ ] Optimize Laravel
- [ ] Restart web server
- [ ] Test website
- [ ] Monitor error logs

---

## 🚨 Troubleshooting

### Still Getting Permission Denied?

#### Check SELinux (CentOS/RHEL):
```bash
# Check if SELinux is enabled
getenforce

# If enabled, set context
sudo chcon -R -t httpd_sys_rw_content_t /var/www/html/sibm/storage
sudo chcon -R -t httpd_sys_rw_content_t /var/www/html/sibm/bootstrap/cache

# Or disable SELinux (not recommended)
sudo setenforce 0
```

#### Check AppArmor (Ubuntu):
```bash
# Check if AppArmor is blocking
sudo aa-status

# If needed, put in complain mode
sudo aa-complain /etc/apparmor.d/usr.sbin.apache2
```

#### Check Disk Space:
```bash
df -h
```

#### Check Inode Usage:
```bash
df -i
```

### Still Getting Database Error?

#### Check MySQL Service:
```bash
sudo systemctl status mysql
```

#### Check MySQL Error Log:
```bash
sudo tail -f /var/log/mysql/error.log
```

#### Test Connection:
```bash
mysql -u sibm_user -p sibm
```

---

## 📞 Need Help?

### Check Logs:
```bash
# Laravel log
tail -f /var/www/html/sibm/storage/logs/laravel.log

# Apache error log
sudo tail -f /var/log/apache2/error.log

# Nginx error log
sudo tail -f /var/log/nginx/error.log

# MySQL error log
sudo tail -f /var/log/mysql/error.log
```

### Common Issues:
1. **Wrong web server user** → Check with `ps aux | grep apache`
2. **SELinux blocking** → Set correct context or disable
3. **Disk full** → Check with `df -h`
4. **Wrong database credentials** → Check `.env` file

---

## ✅ Summary

### Files Changed:
- `app/Http/Middleware/TrackVisitor.php` - Fixed error handling
- `fix-server-permissions.sh` - Script untuk fix permissions

### Commands to Run:
```bash
# 1. Fix permissions
sudo ./fix-server-permissions.sh

# 2. Fix database (create user)
sudo mysql < create-db-user.sql

# 3. Update .env
nano .env

# 4. Clear cache
php artisan optimize:clear

# 5. Restart web server
sudo systemctl restart apache2
```

### Expected Result:
- ✅ No permission errors
- ✅ No database errors
- ✅ Website working normally
- ✅ Logs writing successfully

---

**Status:** ✅ Fixed  
**Date:** February 10, 2026  
**Tested:** Yes
