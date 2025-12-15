# PPDB Brochure on Homepage

## Overview
Fitur untuk menampilkan brosur PPDB di homepage yang dapat dikelola oleh admin melalui panel admin.

## Features

### 1. Homepage Display
- Card brosur PPDB yang menarik dengan gradient background
- Menampilkan gambar brosur
- Judul dan deskripsi yang dapat dikustomisasi
- Tombol "Lihat Brosur" dan "Download"
- Link ke halaman pendaftaran PPDB

### 2. Admin Management
- Upload gambar brosur (JPG, PNG, PDF)
- Edit judul brosur
- Edit deskripsi brosur
- Preview brosur saat ini
- Hapus brosur

## Implementation

### 1. Database (Settings Table)
Menggunakan tabel `settings` yang sudah ada dengan keys:
- `ppdb_brochure` - Path file brosur
- `ppdb_brochure_title` - Judul brosur
- `ppdb_brochure_description` - Deskripsi brosur

### 2. Homepage Section
**File**: `resources/views/public/home-new.blade.php`

```blade
@php
    $ppdbBrochure = setting('ppdb_brochure');
    $ppdbBrochureTitle = setting('ppdb_brochure_title', 'Brosur PPDB');
    $ppdbBrochureDescription = setting('ppdb_brochure_description', '...');
@endphp

@if($ppdbBrochure)
<section class="py-16 bg-gradient-to-br from-orange-50 to-red-50">
    <!-- Card with image and content -->
</section>
@endif
```

**Position**: Setelah Statistics Section, sebelum Quick Links Section

### 3. Admin Panel
**File**: `resources/views/admin/settings/school-content.blade.php`

**Features**:
- File upload input (max 5MB)
- Title input field
- Description textarea
- Current brochure preview
- View and Delete buttons

### 4. Controller Methods
**File**: `app/Http/Controllers/Admin/SettingController.php`

#### updatePpdbBrochure()
```php
public function updatePpdbBrochure(Request $request)
{
    // Validate file and text inputs
    // Delete old brochure if exists
    // Store new brochure
    // Update title and description
}
```

#### deletePpdbBrochure()
```php
public function deletePpdbBrochure()
{
    // Find brochure setting
    // Delete file from storage
    // Delete database record
}
```

### 5. Routes
**File**: `routes/web.php`

```php
Route::post('settings/update-ppdb-brochure', [SettingController::class, 'updatePpdbBrochure'])
    ->name('settings.update-ppdb-brochure');
Route::delete('settings/delete-ppdb-brochure', [SettingController::class, 'deletePpdbBrochure'])
    ->name('settings.delete-ppdb-brochure');
```

## Design

### Homepage Card Design

#### Layout
```
┌─────────────────────────────────────────────┐
│  ┌──────────┐  ┌──────────────────────┐    │
│  │          │  │  Badge: Info PPDB    │    │
│  │  Image   │  │                      │    │
│  │  Brosur  │  │  Title (Large)       │    │
│  │          │  │  Description         │    │
│  │          │  │                      │    │
│  └──────────┘  │  [Lihat] [Download]  │    │
│                │  → Daftar Sekarang   │    │
│                └──────────────────────┘    │
└─────────────────────────────────────────────┘
```

#### Colors
- **Background**: Orange-50 to Red-50 gradient
- **Card**: White with shadow
- **Image Container**: Orange-100 to Red-100 gradient
- **Badge**: Orange-100 background, Orange-600 text
- **Primary Button**: Orange-600 to Red-600 gradient
- **Secondary Button**: White with Orange-600 border

### Admin Panel Design

#### Form Layout
```
┌─────────────────────────────────────────┐
│ 📄 Brosur PPDB                          │
├─────────────────────────────────────────┤
│                                         │
│ Current Brochure (if exists):          │
│ ┌─────────────────────────────────┐   │
│ │ [Preview] [View] [Delete]       │   │
│ └─────────────────────────────────┘   │
│                                         │
│ Upload New Brochure:                   │
│ [Choose File]                          │
│ Format: JPG, PNG, PDF. Max 5MB         │
│                                         │
│ Title:                                 │
│ [________________]                     │
│                                         │
│ Description:                           │
│ [________________]                     │
│ [________________]                     │
│                                         │
│                    [Simpan Brosur]     │
└─────────────────────────────────────────┘
```

## Usage

### For Admin

1. **Upload Brosur**:
   - Login ke admin panel
   - Buka "Pengaturan" → "Konten Sekolah"
   - Scroll ke section "Brosur PPDB"
   - Upload file brosur
   - Isi judul dan deskripsi
   - Klik "Simpan Brosur"

2. **Update Brosur**:
   - Buka section "Brosur PPDB"
   - Upload file baru (opsional)
   - Edit judul/deskripsi
   - Klik "Simpan Brosur"

3. **Hapus Brosur**:
   - Klik tombol "Hapus Brosur"
   - Konfirmasi penghapusan

### For Visitors

1. **View Brochure**:
   - Buka homepage
   - Scroll ke section brosur PPDB
   - Klik "Lihat Brosur" untuk preview
   - Klik "Download" untuk download file

2. **Register**:
   - Klik "Daftar Sekarang" untuk ke halaman pendaftaran

## File Storage

### Directory Structure
```
storage/
└── app/
    └── public/
        └── brochures/
            └── [filename].jpg/png/pdf
```

### Public Access
```
public/
└── storage/
    └── brochures/
        └── [filename].jpg/png/pdf (symlink)
```

## Validation Rules

### File Upload
- **Type**: image (jpeg, png, jpg) or PDF
- **Max Size**: 5MB (5120 KB)
- **Required**: No (optional)

### Text Fields
- **Title**: Max 255 characters
- **Description**: Max 500 characters

## Security

### File Upload Security
- ✅ File type validation
- ✅ File size limit
- ✅ Stored in protected directory
- ✅ Accessed via public symlink

### Access Control
- ✅ Admin authentication required
- ✅ CSRF protection on forms
- ✅ File deletion confirmation

## Benefits

### For School
✅ **Easy Management** - Upload dan update brosur dengan mudah  
✅ **No Code Required** - Admin dapat mengelola tanpa coding  
✅ **Flexible Content** - Judul dan deskripsi dapat dikustomisasi  
✅ **Professional Display** - Tampilan yang menarik di homepage  

### For Visitors
✅ **Easy Access** - Brosur mudah ditemukan di homepage  
✅ **Multiple Options** - View online atau download  
✅ **Clear Information** - Judul dan deskripsi yang jelas  
✅ **Quick Action** - Link langsung ke pendaftaran  

## Testing Checklist

- [ ] Upload brosur JPG berhasil
- [ ] Upload brosur PNG berhasil
- [ ] Upload brosur PDF berhasil
- [ ] File size validation bekerja (>5MB ditolak)
- [ ] File type validation bekerja (format lain ditolak)
- [ ] Preview brosur tampil di admin
- [ ] Tombol "Lihat Brosur" berfungsi
- [ ] Tombol "Download" berfungsi
- [ ] Hapus brosur berhasil
- [ ] Update judul dan deskripsi berhasil
- [ ] Section tidak tampil jika brosur belum diupload
- [ ] Responsive di mobile, tablet, desktop

## Future Enhancements

### Possible Improvements
1. **Multiple Brochures** - Support untuk beberapa brosur
2. **Expiry Date** - Auto hide brosur setelah tanggal tertentu
3. **Analytics** - Track berapa kali brosur dilihat/didownload
4. **Version History** - Simpan history brosur sebelumnya
5. **Multi-language** - Support brosur dalam berbagai bahasa

## Status
✅ IMPLEMENTED - Fitur brosur PPDB sudah berfungsi penuh

---

**Implementation Date**: January 18, 2025  
**Feature**: PPDB Brochure on Homepage  
**Status**: Completed
