# Implementasi Galeri Foto untuk Berita dan Acara

## Ringkasan
Telah menambahkan fitur pengunggahan dan tampilan galeri foto (multiple images) pada halaman berita di panel admin. Admin dapat mengunggah banyak foto saat membuat atau mengedit berita, dan foto-foto tersebut akan ditampilkan dalam galeri di halaman detail berita publik.

## Komponen yang Dibuat/Diperbarui

### 1. Model & Database

#### **NewsImage Model** (`app/Models/NewsImage.php`)
- Model untuk menyimpan data gambar individual
- Fields: id, news_id, image_path, caption, order, timestamps
- Relationship: `belongsTo(News)`
- Accessor: `getImageUrlAttribute()` untuk URL gambar

#### **News Model Update** (`app/Models/News.php`)
- Menambahkan relationship `images()` - hasMany(NewsImage)
- Memudahkan akses gambar galeri dari artikel: `$news->images()`

#### **Migration** (`database/migrations/2025_12_23_000003_create_news_images_table.php`)
- Membuat tabel `news_images` dengan fields:
  - `id` (primary key)
  - `news_id` (foreign key → news table)
  - `image_path` (path file)
  - `caption` (deskripsi gambar)
  - `order` (urutan gambar)
  - Timestamps

### 2. Controller Update

#### **NewsController** (`app/Http/Controllers/Admin/NewsController.php`)
- **store()**: Menambahkan handle untuk upload multiple images
  - Validasi: `images` array dengan max 2MB per file
  - Menyimpan setiap file ke `storage/news/gallery/`
  - Membuat record NewsImage dengan caption
- **update()**: Menangani upload gambar tambahan untuk artikel existing
- **edit()**: Pass `$images` ke view untuk ditampilkan
- **destroy()**: Delete semua gambar galeri saat artikel dihapus
- **deleteImage()**: Endpoint baru untuk delete gambar individual via AJAX

### 3. Admin Forms

#### **Create Form** (`resources/views/admin/news/create.blade.php`)
- Section baru: "Gallery Images"
- Input file dengan `multiple` attribute
- Live preview dengan JavaScript
- Textbox untuk caption setiap gambar
- Styling Tailwind dengan preview grid 2-3 kolom

#### **Edit Form** (`resources/views/admin/news/edit.blade.php`)
- Menampilkan galeri existing dengan kemampuan delete
- Textbox caption bersifat read-only (hanya info)
- Button delete pada hover dengan confirmation
- Section terpisah untuk "Current Gallery" vs "Add Images"
- Delete function via AJAX

### 4. Frontend Display

#### **News Show Page** (`resources/views/public/news/show.blade.php`)
- Galeri section baru setelah article content
- Grid responsive: 1 kolom mobile, 2 md, 3 lg
- Image height: h-64 md:h-72 untuk better visual
- Hover effects:
  - Image scale-up
  - Gradient overlay fade in
  - Caption slide up
  - Magnifying glass icon
- Links to original image dengan data-lightbox support (untuk future lightbox integration)

### 5. Routes

#### **New Route** (`routes/web.php`)
```php
Route::delete('news/{news}/images/{image}', [NewsController::class, 'deleteImage'])->name('news.deleteImage');
```

## Fitur-Fitur

### Di Admin Panel
1. ✅ Upload multiple images saat membuat berita
2. ✅ Preview real-time untuk setiap gambar
3. ✅ Tambah caption untuk setiap gambar
4. ✅ Edit gambar (lihat existing) dan tambah yang baru
5. ✅ Delete gambar individual dengan AJAX
6. ✅ Automatic cleanup saat artikel dihapus

### Di Frontend
1. ✅ Galeri foto ditampilkan di halaman detail berita
2. ✅ Responsive grid layout
3. ✅ Hover effects dan interaktif
4. ✅ Caption tampil pada hover
5. ✅ Links untuk full size image (siap untuk lightbox)

## Validasi & Keamanan
- File validation: hanya image (jpeg, png, jpg, gif)
- Max size: 2MB per file
- CSRF protection untuk delete endpoint
- Authorization check: hanya pemilik berita yang bisa delete image
- Cascading delete otomatis saat artikel dihapus

## Folder Struktur File
```
storage/app/public/
├── news/                  # Featured images
└── news/gallery/         # Gallery images
```

## Usage

### Di Admin Panel
1. Buka Create/Edit News
2. Scroll ke section "Gallery Images"
3. Click file input, select multiple images
4. (Optional) Tambah caption untuk setiap foto
5. Save article
6. Images otomatis tersimpan dan ditampilkan di frontend

### Di Frontend (User)
1. Buka detail berita
2. Scroll ke section "Galeri Foto"
3. Lihat grid dengan semua gambar yang diupload
4. Hover untuk melihat caption dan effect
5. Click gambar untuk melihat full size

## Next Steps (Optional)
- Implement lightbox library (Lightbox2, GLightbox, dll) untuk full-screen viewing
- Drag & drop interface untuk reorder gambar di admin
- Compress/optimize images saat upload
- Implement untuk Events table (jika ada)
