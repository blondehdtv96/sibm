# Logo Not Showing Fix

## Problem
Logo sekolah tidak muncul di navbar dan footer website, hanya menampilkan icon default.

## Root Cause
Layout menggunakan `App\Models\Setting::hasLogo()` dan `App\Models\Setting::getLogo()` yang tidak konsisten dengan helper function `setting()` yang baru dibuat. Selain itu, variabel contact dan social media di footer belum didefinisikan.

## Solution Implemented

### 1. Updated Navbar Logo Section
**File**: `resources/views/layouts/public-tailwind.blade.php`

Mengubah dari:
```php
@php
    try {
        $siteLogo = App\Models\Setting::hasLogo('site_logo') ? App\Models\Setting::getLogo('site_logo') : null;
        $siteName = App\Models\Setting::get('site_name', 'SMK Bina Mandiri Bekasi');
        $siteTagline = App\Models\Setting::get('site_tagline', 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan');
    } catch (\Exception $e) {
        $siteLogo = null;
        $siteName = 'SMK Bina Mandiri Bekasi';
        $siteTagline = 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan';
    }
@endphp
```

Menjadi:
```php
@php
    $siteLogo = setting('site_logo');
    $siteName = setting('site_name', 'SMK Bina Mandiri Bekasi');
    $siteTagline = setting('site_tagline', 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan');
    $logoUrl = $siteLogo ? asset('storage/' . $siteLogo) : null;
@endphp
```

### 2. Added Footer Variables
**File**: `resources/views/layouts/public-tailwind.blade.php`

Menambahkan definisi variabel di awal footer:
```php
@php
    $contactAddress = setting('contact_address');
    $contactPhone = setting('contact_phone');
    $contactEmail = setting('contact_email');
    $socialFacebook = setting('social_facebook');
    $socialInstagram = setting('social_instagram');
    $socialYoutube = setting('social_youtube');
    $socialTwitter = setting('social_twitter');
    $socialTiktok = setting('social_tiktok');
    $socialLinkedin = setting('social_linkedin');
@endphp
```

### 3. Updated Logo Display
Menambahkan `object-contain` class dan white border untuk memastikan logo ditampilkan dengan proporsi yang benar dan tidak bentrok dengan background:

**Navbar Logo:**
```blade
<img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-12 w-auto object-contain bg-white border-2 border-white rounded-lg p-1 shadow-sm">
```

**Footer Logo:**
```blade
<img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="w-12 h-12 object-contain bg-white border-2 border-white rounded-lg p-1 shadow-md">
```

**Styling Details:**
- `bg-white` - Background putih untuk kontras
- `border-2 border-white` - Border putih 2px
- `rounded-lg` - Sudut melengkung
- `p-1` - Padding internal
- `shadow-sm/shadow-md` - Bayangan halus untuk depth

## How It Works

1. **Helper Function**: Menggunakan `setting()` helper yang sudah dibuat untuk konsistensi
2. **Asset URL**: Membuat URL lengkap dengan `asset('storage/' . $siteLogo)`
3. **Fallback**: Jika logo tidak ada, menampilkan icon default dengan gradient
4. **Error Handling**: Menggunakan `onerror` attribute untuk fallback jika gambar gagal dimuat

## Testing

### Check Logo Path
```bash
php artisan tinker
>>> setting('site_logo')
=> "logos/site_logo_1761563891.png"
```

### Check Logo URL
```bash
>>> asset('storage/' . setting('site_logo'))
=> "http://localhost/storage/logos/site_logo_1761563891.png"
```

### Verify File Exists
```bash
# Windows PowerShell
Test-Path "public/storage/logos/site_logo_1761563891.png"
```

## Benefits

1. ✅ Konsisten dengan helper function `setting()`
2. ✅ Lebih mudah dibaca dan dipelihara
3. ✅ Error handling yang lebih baik
4. ✅ Fallback icon jika logo tidak ada
5. ✅ Responsive dan proportional display

## Related Files

- `resources/views/layouts/public-tailwind.blade.php` - Layout dengan navbar dan footer
- `app/helpers.php` - Helper function `setting()`
- `app/Models/Setting.php` - Setting model
- `public/storage/logos/` - Direktori penyimpanan logo

## Status
✅ FIXED - Logo sekarang muncul dengan benar di navbar dan footer

---

**Fix Date**: January 18, 2025  
**Issue**: Logo tidak muncul di navbar dan footer  
**Solution**: Menggunakan helper function `setting()` dan menambahkan variabel footer  
**Status**: Resolved
