# 🎨 Logo Management System - Complete Guide

Panduan lengkap untuk mengelola logo dan branding sekolah melalui panel admin.

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Access Settings](#access-settings)
4. [Logo Types](#logo-types)
5. [Upload Logo](#upload-logo)
6. [Update Logo](#update-logo)
7. [Delete Logo](#delete-logo)
8. [Logo Specifications](#logo-specifications)
9. [Technical Details](#technical-details)
10. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

Sistem Logo Management memungkinkan admin untuk:
- ✅ Upload dan update logo sekolah
- ✅ Mengelola 3 jenis logo (Utama, Dark Mode, Favicon)
- ✅ Preview logo sebelum dan sesudah upload
- ✅ Hapus logo yang tidak digunakan
- ✅ Update nama dan tagline sekolah
- ✅ Logo otomatis muncul di seluruh website

---

## ✨ Features

### 🖼️ **Logo Management**
- **Logo Utama** - Digunakan di header website publik
- **Logo Dark Mode** - Untuk background gelap (opsional)
- **Favicon** - Icon di tab browser

### 📝 **General Settings**
- **Nama Sekolah** - Nama lengkap sekolah
- **Tagline** - Motto atau tagline sekolah

### 🔄 **Auto Integration**
- Logo otomatis muncul di:
  - Header website publik
  - Admin panel
  - Email notifications
  - PDF documents (jika ada)

### 💾 **Cache Management**
- Clear cache untuk refresh logo
- Auto-clear cache saat update logo

---

## 🚪 Access Settings

### 1. Login ke Admin Panel
```
URL: http://your-domain.com/admin
Email: admin@school.com
Password: [your-password]
```

### 2. Navigate to Settings
```
Admin Panel → Sidebar → Pengaturan (Settings)
atau
Direct URL: http://your-domain.com/admin/settings
```

### 3. Settings Page Layout
```
┌─────────────────────────────────────┐
│  Logo & Branding                    │
├─────────────────────────────────────┤
│  [Logo Utama] [Logo Dark] [Favicon] │
│                                     │
│  Pengaturan Umum                    │
│  - Nama Sekolah                     │
│  - Tagline Sekolah                  │
└─────────────────────────────────────┘
```

---

## 🎨 Logo Types

### 1. **Logo Utama (Primary Logo)**

**Digunakan untuk:**
- Header website publik
- Footer website
- Email header
- Dokumen resmi

**Spesifikasi:**
- Format: PNG, JPG, SVG
- Ukuran: Maksimal 2MB
- Resolusi: Minimum 300x100px
- Aspect Ratio: 3:1 atau 4:1 (landscape)
- Background: Transparan (PNG recommended)

**Best Practices:**
```
✅ DO:
- Gunakan PNG dengan background transparan
- Resolusi tinggi (min. 300 DPI)
- Warna yang kontras dengan background
- Logo horizontal (landscape)

❌ DON'T:
- File terlalu besar (> 2MB)
- Resolusi rendah (pixelated)
- Background putih solid
- Logo vertikal (portrait)
```

### 2. **Logo Dark Mode (Optional)**

**Digunakan untuk:**
- Header dengan background gelap
- Dark theme mode
- Print materials dengan background gelap

**Spesifikasi:**
- Format: PNG, JPG, SVG
- Ukuran: Maksimal 2MB
- Resolusi: Minimum 300x100px
- Warna: Terang (putih/light colors)
- Background: Transparan

**Tips:**
- Gunakan warna terang (putih, cream, light gray)
- Test di background gelap sebelum upload
- Sama dengan logo utama tapi warna berbeda

### 3. **Favicon**

**Digunakan untuk:**
- Tab browser icon
- Bookmark icon
- Mobile home screen icon
- Browser history

**Spesifikasi:**
- Format: ICO, PNG
- Ukuran: 32x32px atau 64x64px
- File size: < 100KB
- Shape: Square (1:1)

**Favicon Sizes:**
```
Recommended sizes:
- 16x16px - Browser tab
- 32x32px - Taskbar (Windows)
- 64x64px - High DPI displays
- 180x180px - Apple touch icon
```

---

## 📤 Upload Logo

### Step-by-Step Guide

#### 1. **Prepare Your Logo**
```bash
# Check file size
- Windows: Right-click → Properties
- Mac: Right-click → Get Info

# Optimize image (if needed)
- Use online tools: TinyPNG, Compressor.io
- Or image editors: Photoshop, GIMP
```

#### 2. **Upload via Admin Panel**

**Logo Utama:**
```
1. Go to: Admin → Settings
2. Find "Logo Utama" section
3. Click "Choose File" button
4. Select your logo file
5. Click "Upload Logo" button
6. Wait for success message
7. Logo will appear in preview box
```

**Logo Dark Mode:**
```
1. Go to: Admin → Settings
2. Find "Logo Dark Mode" section
3. Click "Choose File" button
4. Select your dark logo file
5. Click "Upload Logo" button
6. Preview shows on dark background
```

**Favicon:**
```
1. Go to: Admin → Settings
2. Find "Favicon" section
3. Click "Choose File" button
4. Select your favicon file (32x32px)
5. Click "Upload Favicon" button
6. Check browser tab for new icon
```

#### 3. **Verify Upload**
```
✅ Check preview in settings page
✅ Visit homepage to see logo
✅ Check browser tab for favicon
✅ Test on mobile device
```

---

## 🔄 Update Logo

### When to Update Logo
- Rebranding sekolah
- Logo quality improvement
- Design refresh
- Color scheme change

### Update Process
```
1. Prepare new logo file
2. Go to Admin → Settings
3. Upload new logo (will replace old one)
4. Old logo automatically deleted
5. New logo appears immediately
6. Clear browser cache if needed
```

### Update Tips
```
✅ Backup old logo before update
✅ Test new logo on different devices
✅ Inform users about logo change
✅ Update social media profiles
✅ Update printed materials
```

---

## 🗑️ Delete Logo

### Delete Process
```
1. Go to Admin → Settings
2. Find logo you want to delete
3. Click "Hapus Logo" button (red button)
4. Confirm deletion in popup
5. Logo removed from server
6. Default placeholder appears
```

### After Deletion
- Logo file deleted from server
- Website shows default placeholder
- Can upload new logo anytime
- No impact on other settings

---

## 📐 Logo Specifications

### File Formats

#### **PNG (Recommended)**
```
✅ Advantages:
- Supports transparency
- Lossless compression
- High quality
- Web-friendly

❌ Disadvantages:
- Larger file size than JPG
```

#### **JPG/JPEG**
```
✅ Advantages:
- Smaller file size
- Fast loading
- Universal support

❌ Disadvantages:
- No transparency
- Lossy compression
- Not ideal for logos
```

#### **SVG (Best for Scalability)**
```
✅ Advantages:
- Infinite scalability
- Smallest file size
- Perfect quality at any size
- Editable

❌ Disadvantages:
- Not all browsers support
- Complex to create
```

#### **ICO (Favicon Only)**
```
✅ Advantages:
- Native favicon format
- Multi-size support
- Universal browser support

❌ Disadvantages:
- Only for favicons
- Limited editing tools
```

### Size Guidelines

#### **Logo Utama**
```
Minimum: 300x100px
Recommended: 600x200px
Maximum: 2000x800px
File Size: < 2MB
```

#### **Logo Dark Mode**
```
Same as Logo Utama
Match dimensions with primary logo
```

#### **Favicon**
```
Standard: 32x32px
Retina: 64x64px
Apple Touch: 180x180px
File Size: < 100KB
```

### Color Guidelines

#### **Logo Utama**
```
- Use brand colors
- High contrast with white background
- Avoid pure black (#000000)
- Test on different backgrounds
```

#### **Logo Dark Mode**
```
- Light colors (white, cream, light gray)
- High contrast with dark background
- Avoid pure white (#FFFFFF) if possible
- Use slight tint for better visibility
```

#### **Favicon**
```
- Simple, recognizable design
- 2-3 colors maximum
- High contrast
- Visible at small size
```

---

## 🛠️ Technical Details

### Database Structure

#### **Settings Table**
```sql
CREATE TABLE settings (
    id BIGINT PRIMARY KEY,
    key VARCHAR(255) UNIQUE,
    value TEXT,
    type VARCHAR(50),
    group VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### **Default Settings**
```php
[
    'site_logo' => null,
    'site_logo_dark' => null,
    'site_favicon' => null,
    'site_name' => 'SMK Bina Mandiri Bekasi',
    'site_tagline' => 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan',
]
```

### File Storage

#### **Storage Path**
```
storage/app/public/logos/
├── site_logo_1234567890.png
├── site_logo_dark_1234567890.png
└── site_favicon_1234567890.ico
```

#### **Public URL**
```
https://your-domain.com/storage/logos/site_logo_1234567890.png
```

### Model Methods

#### **Get Logo URL**
```php
// Get primary logo
$logo = Setting::getLogo('site_logo');

// Get dark logo
$darkLogo = Setting::getLogo('site_logo_dark');

// Get favicon
$favicon = Setting::getFavicon();
```

#### **Set Logo**
```php
Setting::set('site_logo', 'logos/logo.png', 'image');
```

#### **Clear Cache**
```php
Setting::clearCache();
```

### Blade Usage

#### **In Layout**
```blade
@if(App\Models\Setting::get('site_logo'))
    <img src="{{ App\Models\Setting::getLogo('site_logo') }}" 
         alt="{{ App\Models\Setting::get('site_name') }}">
@else
    <!-- Default placeholder -->
@endif
```

#### **Favicon in Head**
```blade
<link rel="icon" href="{{ App\Models\Setting::getFavicon() }}">
```

---

## 🔧 Troubleshooting

### Logo Not Showing

**Problem:** Logo uploaded but not showing on website

**Solutions:**
```bash
# 1. Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 2. Clear browser cache
Ctrl+Shift+Delete (Windows)
Cmd+Shift+Delete (Mac)

# 3. Check storage link
php artisan storage:link

# 4. Check file permissions
chmod -R 755 storage/app/public
```

### Upload Failed

**Problem:** Error when uploading logo

**Solutions:**
```
✅ Check file size (< 2MB)
✅ Check file format (PNG, JPG, SVG, ICO)
✅ Check server upload limit
✅ Check storage permissions
✅ Check disk space
```

**Increase Upload Limit:**
```ini
# php.ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

### Logo Quality Issues

**Problem:** Logo looks blurry or pixelated

**Solutions:**
```
✅ Use higher resolution image
✅ Use PNG instead of JPG
✅ Use SVG for perfect scaling
✅ Avoid upscaling small images
✅ Export at 2x or 3x size
```

### Favicon Not Updating

**Problem:** Favicon still shows old icon

**Solutions:**
```
1. Clear browser cache completely
2. Hard refresh: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
3. Close and reopen browser
4. Try incognito/private mode
5. Wait 5-10 minutes for CDN update
```

### Storage Link Missing

**Problem:** 404 error on logo URL

**Solutions:**
```bash
# Create storage link
php artisan storage:link

# Verify link exists
ls -la public/storage

# Should show:
# storage -> ../storage/app/public
```

### Permission Denied

**Problem:** Cannot upload or delete logo

**Solutions:**
```bash
# Fix storage permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Fix ownership (Linux/Mac)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

## 📊 Best Practices

### Logo Design
```
✅ Simple and memorable
✅ Scalable to any size
✅ Works in color and monochrome
✅ Recognizable at small sizes
✅ Timeless design
✅ Appropriate for education sector
```

### File Management
```
✅ Keep original files backed up
✅ Use version control for logos
✅ Document logo changes
✅ Test before uploading
✅ Optimize file size
```

### Branding Consistency
```
✅ Use same logo across all platforms
✅ Maintain color consistency
✅ Follow brand guidelines
✅ Update all materials together
✅ Train staff on logo usage
```

---

## 🎓 Quick Reference

### Upload Checklist
- [ ] Logo file prepared (PNG/JPG/SVG)
- [ ] File size < 2MB
- [ ] Correct dimensions
- [ ] Background transparent (if PNG)
- [ ] Tested on different backgrounds
- [ ] Backup of old logo
- [ ] Ready to upload

### Post-Upload Checklist
- [ ] Logo appears in settings preview
- [ ] Logo shows on homepage
- [ ] Logo shows on all pages
- [ ] Mobile display correct
- [ ] Favicon updated in browser tab
- [ ] Cache cleared
- [ ] Tested on different browsers

---

## 📞 Support

### Need Help?
- **Technical Issues:** Check troubleshooting section
- **Design Questions:** Consult with design team
- **Server Issues:** Contact hosting provider
- **Feature Requests:** Submit to development team

### Resources
- [Laravel Storage Documentation](https://laravel.com/docs/filesystem)
- [Image Optimization Tools](https://tinypng.com)
- [Favicon Generator](https://favicon.io)
- [Logo Design Guidelines](https://www.canva.com/learn/logo-design/)

---

**Logo Management System - Ready to Use! 🎨✨**

*Last Updated: 15 Oktober 2025*
