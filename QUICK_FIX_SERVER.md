# ⚡ Quick Fix - Server Errors

## 🚨 Error di Server Production

Ada 2 error utama:
1. ❌ Permission denied untuk log file
2. ❌ Database access denied

---

## ✅ Quick Fix (5 Menit)

### Step 1: Fix Permissions
```bash
cd /var/www/html/sibm

# Fix storage permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Create log file
sudo touch storage/logs/laravel.log
sudo chown www-data:www-data storage/logs/laravel.log
sudo chmod 664 storage/logs/laravel.log
```

### Step 2: Fix Database
```bash
# Login ke MySQL
sudo mysql

# Jalankan commands ini:
```

```sql
CREATE DATABASE IF NOT EXISTS sibm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'sibm_user'@'localhost' IDENTIFIED BY 'YourPassword123!';
GRANT ALL PRIVILEGES ON sibm.* TO 'sibm_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 3: Update .env
```bash
nano .env
```

Update baris ini:
```env
DB_USERNAME=sibm_user
DB_PASSWORD=YourPassword123!
```

### Step 4: Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 5: Restart Web Server
```bash
# Apache
sudo systemctl restart apache2

# Nginx
sudo systemctl restart nginx php8.2-fpm
```

---

## ✅ Test

```bash
# Test website
curl -I https://yourdomain.com

# Expected: HTTP 200 OK
```

---

## 📚 Dokumentasi Lengkap

Baca: `FIX_SERVER_ERRORS.md` untuk penjelasan detail

---

**Status:** ✅ Fixed  
**Time:** ~5 minutes
