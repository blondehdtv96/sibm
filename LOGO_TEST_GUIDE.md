# 🧪 Logo Management - Testing Guide

Panduan untuk test fitur Logo Management yang baru dibuat.

---

## ✅ Pre-Test Checklist

### 1. Run Migration
```bash
php artisan migrate
```

**Expected Output:**
```
Migrating: 2025_10_15_120000_create_settings_table
Migrated:  2025_10_15_120000_create_settings_table (XX.XXms)
```

### 2. Create Storage Link
```bash
php artisan storage:link
```

**Expected Output:**
```
The [public/storage] link has been connected to [storage/app/public].
The links have been created.
```

### 3. Check Permissions
```bash
# Windows (PowerShell)
icacls storage /grant Users:F /T

# Linux/Mac
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🧪 Testing Steps

### Test 1: Access Settings Page

**Steps:**
1. Login ke admin panel: `http://localhost:8000/admin`
2. Look at sidebar, find "Pengaturan" menu (with gear icon)
3. Click "Pengaturan"

**Expected Result:**
- ✅ URL changes to `/admin/settings`
- ✅ Page loads successfully
- ✅ Shows "Pengaturan Website" title
- ✅ Shows 3 logo upload sections
- ✅ Shows general settings form

**If Failed:**
- Check if routes are added
- Check if controller exists
- Check if view file exists
- Check browser console for errors

---

### Test 2: Upload Logo Utama

**Steps:**
1. Go to Settings page
2. Find "Logo Utama" section
3. Click "Choose File"
4. Select a PNG/JPG file (< 2MB)
5. Click "Upload Logo"

**Expected Result:**
- ✅ Success message appears
- ✅ Logo preview shows uploaded image
- ✅ "Hapus Logo" button appears
- ✅ File saved in `storage/app/public/logos/`

**Test on Homepage:**
1. Open homepage: `http://localhost:8000`
2. Check header

**Expected Result:**
- ✅ Logo appears in header
- ✅ Logo is clickable (links to home)
- ✅ Logo responsive on mobile

---

### Test 3: Upload Favicon

**Steps:**
1. Go to Settings page
2. Find "Favicon" section
3. Click "Choose File"
4. Select ICO/PNG file (32x32px)
5. Click "Upload Favicon"

**Expected Result:**
- ✅ Success message appears
- ✅ Favicon preview shows uploaded icon
- ✅ File saved in storage

**Test in Browser:**
1. Refresh homepage
2. Check browser tab

**Expected Result:**
- ✅ New favicon appears in tab
- ✅ Favicon visible in bookmarks

**Note:** May need to clear browser cache (Ctrl+F5)

---

### Test 4: Update Site Name & Tagline

**Steps:**
1. Go to Settings page
2. Scroll to "Pengaturan Umum"
3. Change "Nama Sekolah" to "Test School Name"
4. Change "Tagline" to "Test Tagline"
5. Click "Simpan Pengaturan"

**Expected Result:**
- ✅ Success message appears
- ✅ Form shows updated values

**Test on Homepage:**
1. Refresh homepage
2. Check header

**Expected Result:**
- ✅ New school name appears
- ✅ New tagline appears
- ✅ Text updated everywhere

---

### Test 5: Delete Logo

**Steps:**
1. Go to Settings page
2. Find logo you want to delete
3. Click "Hapus Logo" (red button)
4. Confirm deletion in popup

**Expected Result:**
- ✅ Success message appears
- ✅ Logo preview shows placeholder
- ✅ "Hapus Logo" button disappears
- ✅ File deleted from storage

**Test on Homepage:**
- ✅ Default placeholder appears
- ✅ No broken image

---

### Test 6: Clear Cache

**Steps:**
1. Go to Settings page
2. Click "Clear Cache" button (top right)

**Expected Result:**
- ✅ Success message: "Cache pengaturan berhasil dibersihkan!"
- ✅ Page reloads
- ✅ Settings still work

---

### Test 7: File Validation

**Test 7a: File Too Large**
1. Try upload file > 2MB

**Expected Result:**
- ✅ Error message about file size
- ✅ Upload rejected

**Test 7b: Wrong File Type**
1. Try upload .txt or .pdf file

**Expected Result:**
- ✅ Error message about file type
- ✅ Upload rejected

**Test 7c: No File Selected**
1. Click "Upload Logo" without selecting file

**Expected Result:**
- ✅ Error message: "The logo field is required"
- ✅ Upload rejected

---

### Test 8: Mobile Responsive

**Steps:**
1. Open Chrome DevTools (F12)
2. Toggle device toolbar (Ctrl+Shift+M)
3. Test on different devices:
   - iPhone SE (375px)
   - iPad (768px)
   - Desktop (1920px)

**Expected Result:**
- ✅ Settings page responsive
- ✅ Logo upload sections stack on mobile
- ✅ Buttons full-width on mobile
- ✅ Forms readable on all sizes

---

### Test 9: Browser Compatibility

**Test on:**
- ✅ Chrome
- ✅ Firefox
- ✅ Safari
- ✅ Edge

**Expected Result:**
- ✅ All features work
- ✅ UI looks consistent
- ✅ No console errors

---

### Test 10: Security

**Test 10a: Unauthorized Access**
1. Logout from admin
2. Try access: `http://localhost:8000/admin/settings`

**Expected Result:**
- ✅ Redirected to login page
- ✅ Cannot access settings

**Test 10b: CSRF Protection**
1. Try upload without CSRF token

**Expected Result:**
- ✅ Request rejected
- ✅ 419 error or redirect

---

## 🐛 Common Issues & Solutions

### Issue 1: "Class 'App\Models\Setting' not found"

**Solution:**
```bash
composer dump-autoload
```

### Issue 2: "Storage link not found"

**Solution:**
```bash
php artisan storage:link
```

### Issue 3: "Permission denied"

**Solution:**
```bash
# Windows
icacls storage /grant Users:F /T

# Linux/Mac
chmod -R 755 storage
chown -R www-data:www-data storage
```

### Issue 4: Logo not showing on homepage

**Solution:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

Then hard refresh browser (Ctrl+F5)

### Issue 5: Favicon not updating

**Solution:**
1. Clear browser cache completely
2. Close and reopen browser
3. Try incognito mode
4. Wait 5-10 minutes

### Issue 6: Upload fails silently

**Check:**
```bash
# Check PHP upload limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Check Laravel logs
tail -f storage/logs/laravel.log
```

---

## 📊 Test Results Template

```
LOGO MANAGEMENT TESTING RESULTS
================================

Date: _______________
Tester: _______________

Pre-Test Checklist:
[ ] Migration run successfully
[ ] Storage link created
[ ] Permissions set

Feature Tests:
[ ] Test 1: Access Settings Page
[ ] Test 2: Upload Logo Utama
[ ] Test 3: Upload Favicon
[ ] Test 4: Update Site Name & Tagline
[ ] Test 5: Delete Logo
[ ] Test 6: Clear Cache
[ ] Test 7: File Validation
[ ] Test 8: Mobile Responsive
[ ] Test 9: Browser Compatibility
[ ] Test 10: Security

Issues Found:
1. _______________
2. _______________
3. _______________

Overall Status: [ ] PASS  [ ] FAIL

Notes:
_______________
_______________
_______________
```

---

## ✅ Success Criteria

All tests should pass with these results:

- ✅ Settings page accessible
- ✅ Can upload all 3 logo types
- ✅ Logos appear on website
- ✅ Can update site info
- ✅ Can delete logos
- ✅ File validation works
- ✅ Mobile responsive
- ✅ Cross-browser compatible
- ✅ Secure (auth required)
- ✅ No console errors

---

## 🎉 If All Tests Pass

**Congratulations!** Logo Management System is working perfectly and ready for production use!

**Next Steps:**
1. Upload actual school logo
2. Upload favicon
3. Update school name & tagline
4. Test on production server
5. Train admin users

---

**Testing Guide Complete! 🧪✨**

*Last Updated: 15 Oktober 2025*
