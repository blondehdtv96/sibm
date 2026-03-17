# Storage Directories Access - FIXED

## Problem
Files in `principal` and `brochures` directories returning 404 errors on production server:
- `/storage/principal/principal_1762498731.jpg` - 404
- `/storage/brochures/46n359RVbsDItsmmzejWEJfpkEJeF83smrrYUbmb.png` - 404

## Root Cause
The storage route fallback in `routes/web.php` only allowed specific directories. The `principal` and `brochures` directories were not in the allowed list.

## Solution Applied
Added `principal` and `brochures` to the allowed directories list in `routes/web.php`:

```php
$allowedDirs = [
    'sliders', 
    'home_sliders', 
    'uploads', 
    'images', 
    'news', 
    'gallery', 
    'competencies', 
    'settings', 
    'logos', 
    'banners', 
    'industry-partners',
    'principal',      // Added
    'brochures'       // Added
];
```

## Files Modified
- `routes/web.php` - Added 'principal' and 'brochures' to allowed directories

## How It Works
The storage route fallback serves files from `storage/app/public/` when symlink is not available:

1. Request: `/storage/principal/principal_1762498731.jpg`
2. Route extracts first directory: `principal`
3. Checks if in allowed list: YES ✓
4. Serves file from: `storage/app/public/principal/principal_1762498731.jpg`

## Affected Features
- **Principal Photo**: Settings > School Content > Principal Message
- **PPDB Brochure**: Settings > School Content > PPDB Brochure

## Testing
1. Go to: `https://smkbinamandiribekasi.sch.id/admin/settings/school-content`
2. Check browser console (F12)
3. No 404 errors should appear
4. Principal photo should display
5. PPDB brochure should display

## Complete Allowed Directories List
```php
[
    'sliders',           // Home sliders
    'home_sliders',      // Home sliders (alternative)
    'uploads',           // General uploads
    'images',            // General images
    'news',              // News images & files
    'gallery',           // Gallery images
    'competencies',      // Program keahlian images
    'settings',          // Settings images
    'logos',             // School logos
    'banners',           // Banners
    'industry-partners', // Industry partner logos
    'principal',         // Principal photos
    'brochures'          // PPDB brochures
]
```

## Security
- Only whitelisted directories are accessible
- No directory traversal possible
- File type validation on upload
- Cache headers for performance

## Future Additions
If you add new upload directories, remember to add them to the `$allowedDirs` array in `routes/web.php`.

Example:
```php
$allowedDirs = [..., 'new-directory'];
```

Then clear cache:
```bash
php artisan cache:clear
php artisan route:clear
```
