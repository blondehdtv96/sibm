# 🎨 Logo Management - README

**Feature:** Logo & Branding Management System  
**Status:** ✅ Production Ready  
**Difficulty:** Easy  
**Time to Setup:** 5 minutes

---

## 🚀 Quick Start

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Create Storage Link
```bash
php artisan storage:link
```

### 3. Access Settings
```
Login → Admin Panel → Pengaturan (Sidebar)
atau
http://your-domain.com/admin/settings
```

### 4. Upload Logo
```
1. Click "Choose File"
2. Select your logo
3. Click "Upload Logo"
4. ✅ Done!
```

---

## 📋 What You Can Do

### Upload & Manage
- ✅ Upload logo sekolah
- ✅ Update logo kapan saja
- ✅ Delete logo
- ✅ Preview real-time
- ✅ Upload favicon
- ✅ Set nama & tagline sekolah

### Auto Integration
Logo otomatis muncul di:
- ✅ Header website
- ✅ Footer website
- ✅ Browser tab (favicon)
- ✅ Mobile responsive

---

## 📐 Logo Specifications

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
```

---

## 📁 Files Created

```
database/migrations/
└── 2025_10_15_120000_create_settings_table.php

app/Models/
└── Setting.php

app/Http/Controllers/Admin/
└── SettingController.php

resources/views/admin/settings/
└── index.blade.php

routes/
└── web.php (updated)

Documentation/
├── LOGO_MANAGEMENT_GUIDE.md (Complete Guide)
├── LOGO_QUICKSTART.md (Quick Start)
└── LOGO_MANAGEMENT_SUMMARY.md (Summary)
```

---

## 🎯 Features

### Logo Types
1. **Logo Utama** - Main logo for header
2. **Logo Dark Mode** - For dark backgrounds (optional)
3. **Favicon** - Browser tab icon

### Management
- Upload new logo
- Update existing logo
- Delete logo
- Preview before/after
- Clear cache

### Settings
- Site name
- Site tagline
- Auto-save
- Cache management

---

## 💻 Usage Examples

### In Blade Templates
```blade
{{-- Display logo --}}
<img src="{{ App\Models\Setting::getLogo('site_logo') }}" 
     alt="{{ App\Models\Setting::get('site_name') }}">

{{-- Display site name --}}
{{ App\Models\Setting::get('site_name') }}

{{-- Display tagline --}}
{{ App\Models\Setting::get('site_tagline') }}
```

### In Controllers
```php
// Get logo URL
$logo = Setting::getLogo('site_logo');

// Get setting value
$siteName = Setting::get('site_name');

// Set setting
Setting::set('site_name', 'New School Name');

// Clear cache
Setting::clearCache();
```

---

## 🛠️ Troubleshooting

### Logo not showing?
```bash
php artisan storage:link
php artisan cache:clear
chmod -R 755 storage
```

### Upload failed?
```
✅ Check file size < 2MB
✅ Check file format (PNG, JPG, SVG)
✅ Check storage permissions
✅ Check internet connection
```

### Favicon not updating?
```
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+F5)
3. Close and reopen browser
4. Wait 5 minutes
```

---

## 📚 Documentation

### Complete Guides
- **LOGO_MANAGEMENT_GUIDE.md** - Comprehensive guide with all details
- **LOGO_QUICKSTART.md** - 5-minute quick start guide
- **LOGO_MANAGEMENT_SUMMARY.md** - Implementation summary

### Topics Covered
- Upload & update logo
- Logo specifications
- File formats
- Best practices
- Troubleshooting
- Technical details
- Security
- Performance

---

## ✅ Testing Checklist

- [ ] Migration run successfully
- [ ] Storage link created
- [ ] Can access settings page
- [ ] Can upload logo
- [ ] Logo appears on homepage
- [ ] Logo appears on all pages
- [ ] Favicon shows in browser tab
- [ ] Mobile responsive works
- [ ] Can update logo
- [ ] Can delete logo
- [ ] Cache clearing works

---

## 🎓 Tips

### Logo Design
```
✅ Use PNG with transparent background
✅ High resolution (min 300 DPI)
✅ Horizontal orientation
✅ Simple and recognizable
✅ Test on different backgrounds
```

### File Optimization
```
✅ Compress before upload (TinyPNG.com)
✅ Remove metadata
✅ Use appropriate format
✅ Keep original backup
```

---

## 📞 Need Help?

### Quick Fixes
- **Logo blurry?** → Use higher resolution
- **Upload failed?** → Check file size
- **Not showing?** → Clear cache
- **Permission error?** → Fix storage permissions

### Full Documentation
See **LOGO_MANAGEMENT_GUIDE.md** for detailed help

---

## 🎉 That's It!

Logo management is now ready to use. Upload your school logo and it will automatically appear across your entire website!

**Total Setup Time:** 5 minutes  
**Difficulty:** Easy  
**Status:** Production Ready ✅

---

**Happy Logo Managing! 🎨✨**
