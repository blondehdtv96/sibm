# 🔧 Settings Table Fix

**Issue:** SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sibm.settings' doesn't exist  
**Status:** ✅ Fixed  
**Date:** 15 Oktober 2025

---

## 🐛 Problem

Error terjadi karena:
1. Migration `create_settings_table` belum dijalankan
2. Layout public mencoba akses `Setting` model sebelum tabel ada
3. Tidak ada error handling untuk kasus tabel belum ada

**Error Message:**
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'sibm.settings' doesn't exist
```

---

## ✅ Solution

### 1. Run Migration
```bash
php artisan migrate
```

**Result:**
```
INFO  Running migrations.
2025_10_15_120000_create_settings_table ......... DONE
```

### 2. Add Error Handling in Layout

**Before:**
```blade
@if(App\Models\Setting::get('site_logo'))
    <img src="{{ App\Models\Setting::getLogo('site_logo') }}">
@endif
```

**After:**
```blade
@php
    try {
        $siteLogo = App\Models\Setting::get('site_logo');
        $siteName = App\Models\Setting::get('site_name', 'SMK Bina Mandiri Bekasi');
        $siteTagline = App\Models\Setting::get('site_tagline', 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan');
    } catch (\Exception $e) {
        $siteLogo = null;
        $siteName = 'SMK Bina Mandiri Bekasi';
        $siteTagline = 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan';
    }
@endphp

@if($siteLogo)
    <img src="{{ App\Models\Setting::getLogo('site_logo') }}">
@endif
```

### 3. Clear Cache
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## 📊 Verification

### Check Table Exists
```bash
php artisan tinker --execute="echo count(DB::select('SELECT * FROM settings'));"
```

**Expected Output:**
```
5
```

### Check Default Data
```sql
SELECT * FROM settings;
```

**Expected Result:**
```
+----+------------------+-------+-------+------------+-------------+
| id | key              | value | type  | group      | description |
+----+------------------+-------+-------+------------+-------------+
| 1  | site_logo        | NULL  | image | appearance | Logo sekolah|
| 2  | site_logo_dark   | NULL  | image | appearance | Logo dark   |
| 3  | site_favicon     | NULL  | image | appearance | Favicon     |
| 4  | site_name        | SMK..| text  | general    | Nama sekolah|
| 5  | site_tagline     | Ungg..| text  | general    | Tagline     |
+----+------------------+-------+-------+------------+-------------+
```

---

## 🎯 What Was Fixed

### 1. Database
- ✅ Created `settings` table
- ✅ Inserted 5 default settings
- ✅ Table structure correct

### 2. Code
- ✅ Added try-catch in public layout
- ✅ Fallback values if table doesn't exist
- ✅ Safe error handling

### 3. Cache
- ✅ Cleared view cache
- ✅ Cleared config cache
- ✅ Fresh start

---

## 🚀 Testing

### Test 1: Homepage Loads
```
Visit: http://localhost:8000
Expected: ✅ Homepage loads without error
```

### Test 2: Settings Page
```
Visit: http://localhost:8000/admin/settings
Expected: ✅ Settings page loads
```

### Test 3: Upload Logo
```
1. Go to Settings
2. Upload logo
3. Check homepage
Expected: ✅ Logo appears
```

---

## 🔄 For Fresh Installation

If you're setting up on a new server:

```bash
# 1. Clone repository
git clone [repo-url]
cd sibm

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=sibm
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Create storage link
php artisan storage:link

# 7. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 8. Test
php artisan serve
```

---

## 📝 Files Modified

### 1. Migration (Already exists)
```
database/migrations/2025_10_15_120000_create_settings_table.php
```

### 2. Public Layout (Updated)
```
resources/views/layouts/public-tailwind.blade.php
```

**Changes:**
- Added try-catch block
- Safe fallback values
- Error handling

---

## 🎓 Lessons Learned

### Best Practices
1. **Always run migrations** after pulling new code
2. **Add error handling** for database queries in views
3. **Use fallback values** for critical data
4. **Clear cache** after database changes

### Error Prevention
```php
// Good: With error handling
try {
    $value = Setting::get('key', 'default');
} catch (\Exception $e) {
    $value = 'default';
}

// Bad: No error handling
$value = Setting::get('key'); // Will crash if table doesn't exist
```

---

## 🐛 Troubleshooting

### Issue: Migration already ran but still error

**Solution:**
```bash
# Check if table exists
php artisan tinker --execute="DB::select('SHOW TABLES');"

# If not exists, run migration again
php artisan migrate

# If exists but empty, check migration file
# Make sure it has DB::table('settings')->insert([...])
```

### Issue: Error persists after migration

**Solution:**
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Restart server
php artisan serve
```

### Issue: Can't access settings page

**Solution:**
```bash
# Check routes
php artisan route:list | grep settings

# Check controller exists
ls app/Http/Controllers/Admin/SettingController.php

# Check model exists
ls app/Models/Setting.php
```

---

## ✅ Success Criteria

After fix, you should be able to:
- ✅ Visit homepage without error
- ✅ Access admin settings page
- ✅ Upload logo
- ✅ Update site name & tagline
- ✅ See changes on website

---

## 📞 Support

If issue persists:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check database connection in `.env`
3. Verify table exists in database
4. Check file permissions on storage folder

---

**Settings Table Fix Complete! ✅**

*Last Updated: 15 Oktober 2025*
