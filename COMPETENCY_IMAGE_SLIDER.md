# Competency Image Slider Management

## Overview
Sistem manajemen gambar slider untuk setiap kompetensi keahlian. Admin dapat mengelola multiple images yang akan ditampilkan sebagai slider/gallery di halaman detail kompetensi.

## Fitur

### 1. Multiple Images per Competency
- ✅ Upload multiple images sekaligus
- ✅ Setiap kompetensi bisa punya banyak gambar
- ✅ Gambar tersimpan terorganisir per kompetensi

### 2. CRUD Gambar
- ✅ Upload gambar baru (single/multiple)
- ✅ Edit informasi gambar
- ✅ Replace gambar existing
- ✅ Delete gambar
- ✅ Reorder gambar (urutan tampilan)

### 3. Informasi Gambar
- **Image**: File gambar (JPG, PNG, max 5MB)
- **Title**: Judul gambar (opsional)
- **Description**: Deskripsi gambar (opsional)
- **Order**: Urutan tampilan di slider
- **Status**: Active/Inactive

### 4. Preview & Management
- ✅ Grid view dengan thumbnail
- ✅ Preview gambar sebelum upload
- ✅ Badge order dan status
- ✅ Hover actions (edit/delete)
- ✅ Pagination untuk banyak gambar

## Database Schema

### Table: competency_images
```sql
- id (bigint, primary key)
- competency_id (bigint, foreign key) - ID kompetensi
- image_path (string) - Path file gambar
- title (string, nullable) - Judul gambar
- description (text, nullable) - Deskripsi gambar
- order (integer) - Urutan tampilan
- status (enum: active, inactive) - Status gambar
- created_at (timestamp)
- updated_at (timestamp)
```

## Files Created

### Models
- `app/Models/CompetencyImage.php`
- Updated: `app/Models/Competency.php` (added relationships)

### Controllers
- `app/Http/Controllers/Admin/CompetencyImageController.php`

### Migrations
- `database/migrations/2025_01_08_110000_create_competency_images_table.php`

### Views
- `resources/views/admin/competency-images/index.blade.php` - Grid view gambar
- `resources/views/admin/competency-images/create.blade.php` - Upload gambar
- `resources/views/admin/competency-images/edit.blade.php` - Edit gambar

### Routes
```php
Route::get('competencies/{competency}/images', [CompetencyImageController::class, 'index']);
Route::get('competencies/{competency}/images/create', [CompetencyImageController::class, 'create']);
Route::post('competencies/{competency}/images', [CompetencyImageController::class, 'store']);
Route::get('competencies/{competency}/images/{image}/edit', [CompetencyImageController::class, 'edit']);
Route::put('competencies/{competency}/images/{image}', [CompetencyImageController::class, 'update']);
Route::delete('competencies/{competency}/images/{image}', [CompetencyImageController::class, 'destroy']);
Route::post('competencies/{competency}/images/reorder', [CompetencyImageController::class, 'reorder']);
```

## Cara Penggunaan

### 1. Akses Galeri Gambar
- Login sebagai admin
- Buka **Program Keahlian**
- Klik icon **Galeri** (icon gambar) pada kompetensi yang diinginkan
- URL: `/admin/competencies/{slug}/images`

### 2. Upload Gambar Baru
1. Klik tombol **Upload Gambar**
2. Pilih satu atau lebih gambar (multiple select)
3. Preview akan muncul otomatis
4. Isi informasi (opsional):
   - Judul: Nama/judul gambar
   - Deskripsi: Keterangan gambar
5. Pilih status (Active/Inactive)
6. Klik **Upload Gambar**

### 3. Edit Gambar
1. Hover pada gambar yang ingin diedit
2. Klik icon **Edit** (pensil)
3. Update informasi:
   - Ganti gambar (opsional)
   - Edit judul
   - Edit deskripsi
   - Ubah urutan
   - Ubah status
4. Klik **Update Gambar**

### 4. Hapus Gambar
1. Hover pada gambar yang ingin dihapus
2. Klik icon **Delete** (trash)
3. Konfirmasi penghapusan
4. Gambar akan terhapus dari storage dan database

### 5. Atur Urutan
- Edit gambar dan ubah nilai **Order**
- Angka lebih kecil = tampil lebih awal
- Contoh: Order 1, 2, 3, 4...

## Storage

Gambar disimpan di:
```
storage/app/public/competencies/{competency-slug}/
```

Contoh:
```
storage/app/public/competencies/teknik-komputer-jaringan/
  - 1736345678_0_lab-komputer.jpg
  - 1736345678_1_ruang-server.jpg
  - 1736345678_2_praktik-jaringan.jpg
```

## Integrasi dengan Frontend

### Mengambil Gambar di Controller
```php
// Get competency with active images
$competency = Competency::with('activeImages')->findOrFail($id);

// Or get all images (including inactive)
$competency = Competency::with('images')->findOrFail($id);
```

### Menampilkan Slider di View
```blade
@if($competency->activeImages->count() > 0)
    <div class="slider">
        @foreach($competency->activeImages as $image)
            <div class="slide">
                <img src="{{ $image->image_url }}" alt="{{ $image->title }}">
                @if($image->title)
                    <h3>{{ $image->title }}</h3>
                @endif
                @if($image->description)
                    <p>{{ $image->description }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif
```

### Contoh dengan Swiper.js
```blade
<div class="swiper">
    <div class="swiper-wrapper">
        @foreach($competency->activeImages as $image)
            <div class="swiper-slide">
                <img src="{{ $image->image_url }}" alt="{{ $image->title }}">
                <div class="caption">
                    @if($image->title)
                        <h3>{{ $image->title }}</h3>
                    @endif
                    @if($image->description)
                        <p>{{ $image->description }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
```

## Model Methods

### Competency Model
```php
// Get all images (ordered)
$competency->images;

// Get only active images (ordered)
$competency->activeImages;

// Count images
$competency->images()->count();
```

### CompetencyImage Model
```php
// Get image URL
$image->image_url;

// Check if active
$image->status === 'active';

// Get competency
$image->competency;
```

## Validasi

### Upload Gambar
- `images.*`: Required, image, mimes:jpeg,png,jpg, max:5120 (5MB)
- `title`: Optional, string, max:255
- `description`: Optional, string
- `status`: Required, in:active,inactive

### Update Gambar
- `image`: Optional, image, mimes:jpeg,png,jpg, max:5120 (5MB)
- `title`: Optional, string, max:255
- `description`: Optional, string
- `order`: Required, integer, min:0
- `status`: Required, in:active,inactive

## Tips & Best Practices

1. **Ukuran Gambar**:
   - Rekomendasi: 1920x1080px (16:9 ratio)
   - Format: JPG untuk foto, PNG untuk grafis
   - Compress gambar sebelum upload
   - Max 5MB per file

2. **Jumlah Gambar**:
   - 5-10 gambar per kompetensi ideal
   - Terlalu banyak gambar = loading lambat
   - Pilih gambar berkualitas tinggi

3. **Konten Gambar**:
   - Foto fasilitas/lab
   - Kegiatan praktik siswa
   - Peralatan/tools
   - Hasil karya siswa
   - Suasana pembelajaran

4. **Urutan Gambar**:
   - Gambar terbaik di urutan awal
   - Kelompokkan gambar sejenis
   - Variasi angle dan konten

5. **Status Management**:
   - Set inactive untuk hide sementara
   - Jangan delete jika masih mungkin dipakai
   - Review berkala gambar inactive

## Security

- ✅ Middleware auth & admin required
- ✅ CSRF protection
- ✅ File validation (type, size)
- ✅ Cascade delete (hapus competency = hapus semua gambar)
- ✅ Old file deletion on update/delete
- ✅ Storage in secure directory

## Future Enhancements

- [ ] Drag & drop reordering
- [ ] Bulk upload with progress bar
- [ ] Image cropper/editor
- [ ] Auto-resize/optimize on upload
- [ ] Watermark support
- [ ] Image tags/categories
- [ ] Lightbox/modal view
- [ ] Download all images (zip)

## Troubleshooting

### Gambar tidak muncul
- Pastikan storage link: `php artisan storage:link`
- Cek permission folder storage
- Pastikan path benar di database

### Error saat upload
- Cek max upload size di php.ini
- Pastikan folder writable
- Cek format file (jpg/png only)

### Slider tidak jalan
- Pastikan ada gambar active
- Cek JavaScript slider library
- Inspect console untuk error

### Gambar terlalu besar
- Compress sebelum upload
- Gunakan tools: TinyPNG, ImageOptim
- Atau implement auto-resize

## Support
Untuk pertanyaan atau issue, silakan hubungi tim development.
