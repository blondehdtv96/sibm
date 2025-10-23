# 🚀 Logo Management - Quick Start Guide

Panduan cepat untuk mengganti logo sekolah dalam 5 menit!

---

## ⚡ Quick Steps

### 1️⃣ **Persiapan (2 menit)**

```bash
# Jalankan migration
php artisan migrate

# Create storage link
php artisan storage:link

# Buat folder logos (otomatis saat upload)
```

### 2️⃣ **Siapkan File Logo**

**Logo Utama:**
- Format: PNG (dengan background transparan)
- Ukuran: 600x200px (atau sejenisnya)
- File size: < 2MB

**Favicon:**
- Format: ICO atau PNG
- Ukuran: 32x32px
- File size: < 100KB

---

## 📤 Upload Logo (3 menit)

### Via Admin Panel

1. **Login ke Admin**
   ```
   URL: http://your-domain.com/admin
   ```

2. **Buka Settings**
   ```
   Sidebar → Pengaturan (icon gear)
   ```

3. **Upload Logo Utama**
   ```
   - Click "Choose File" di section "Logo Utama"
   - Pilih file logo Anda
   - Click "Upload Logo"
   - ✅ Done! Logo langsung muncul
   ```

4. **Upload Favicon (Optional)**
   ```
   - Click "Choose File" di section "Favicon"
   - Pilih file favicon Anda
   - Click "Upload Favicon"
   - ✅ Refresh browser untuk lihat favicon baru
   ```

---

## 🎨 Logo Specifications

### Logo Utama
```
Format: PNG, JPG, SVG
Size: 300x100px - 2000x800px
Max File: 2MB
Background: Transparan (recommended)
```

### Favicon
```
Format: ICO, PNG
Size: 32x32px atau 64x64px
Max File: 100KB
Shape: Square
```

---

## ✅ Verification

### Check Logo
```
1. Visit homepage: http://your-domain.com
2. Logo should appear in header
3. Check on mobile device
4. Check favicon in browser tab
```

### If Logo Not Showing
```bash
# Clear cache
php artisan cache:clear
php artisan view:clear

# Hard refresh browser
Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
```

---

## 🔄 Update Logo

**Ganti Logo Lama:**
```
1. Go to Admin → Settings
2. Upload logo baru (akan replace otomatis)
3. Logo lama terhapus otomatis
4. ✅ Done!
```

---

## 🗑️ Delete Logo

**Hapus Logo:**
```
1. Go to Admin → Settings
2. Click "Hapus Logo" (red button)
3. Confirm deletion
4. Logo terhapus, muncul placeholder default
```

---

## 📝 Update Nama & Tagline

**Edit Informasi Sekolah:**
```
1. Go to Admin → Settings
2. Scroll ke "Pengaturan Umum"
3. Edit "Nama Sekolah"
4. Edit "Tagline Sekolah"
5. Click "Simpan Pengaturan"
6. ✅ Updated!
```

---

## 🎯 Where Logo Appears

Logo otomatis muncul di:
- ✅ Header website publik
- ✅ Footer website
- ✅ Admin panel (coming soon)
- ✅ Email notifications
- ✅ Browser tab (favicon)

---

## 🛠️ Troubleshooting

### Logo tidak muncul?
```bash
php artisan storage:link
php artisan cache:clear
chmod -R 755 storage
```

### Upload gagal?
```
✅ Check file size < 2MB
✅ Check format (PNG, JPG, SVG)
✅ Check internet connection
✅ Try different browser
```

### Favicon tidak update?
```
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+F5)
3. Close and reopen browser
4. Wait 5 minutes
```

---

## 📊 Quick Reference

### File Locations
```
Storage: storage/app/public/logos/
Public URL: /storage/logos/
Settings: Admin → Pengaturan
```

### Recommended Tools
```
Image Optimization: TinyPNG.com
Favicon Generator: Favicon.io
Image Editor: Canva.com, Photoshop
```

---

## 🎓 Pro Tips

### Logo Design
```
✅ Use PNG with transparent background
✅ High resolution (min 300 DPI)
✅ Horizontal orientation (landscape)
✅ Simple and recognizable
✅ Test on different backgrounds
```

### File Optimization
```
✅ Compress before upload (TinyPNG)
✅ Remove metadata
✅ Use appropriate format
✅ Keep original backup
```

---

## 📞 Need Help?

**Common Issues:**
- Logo blurry → Use higher resolution
- Upload failed → Check file size
- Not showing → Clear cache
- Permission error → Fix storage permissions

**Full Documentation:**
- See `LOGO_MANAGEMENT_GUIDE.md` for detailed guide

---

**That's it! Logo management made easy! 🎨✨**

**Total Time: 5 minutes**
**Difficulty: Easy**
**Status: Production Ready**

---

*Quick Start Guide - Logo Management System*
*Last Updated: 15 Oktober 2025*
