# School Content Management

## Overview
Sistem CRUD untuk mengelola konten Selayang Pandang dan Sambutan Kepala Sekolah di halaman admin.

## Fitur

### 1. Selayang Pandang (School Overview)
- ✅ Edit konten selayang pandang sekolah
- ✅ Preview langsung ke halaman publik
- ✅ Textarea untuk konten panjang
- ✅ Auto-save ke database settings

### 2. Sambutan Kepala Sekolah (Principal Message)
- ✅ Edit nama kepala sekolah
- ✅ Upload foto kepala sekolah
- ✅ Edit sambutan/pesan kepala sekolah
- ✅ Preview foto sebelum upload
- ✅ Delete foto existing
- ✅ Tampilan foto dan nama di halaman publik

## Database Storage

Data disimpan di tabel `settings` dengan keys:
- `school_overview` - Konten selayang pandang
- `principal_name` - Nama kepala sekolah
- `principal_photo` - Path foto kepala sekolah
- `principal_message` - Sambutan kepala sekolah

## Files Modified/Created

### Controllers
- `app/Http/Controllers/Admin/SettingController.php` - Added methods:
  - `schoolContent()` - Show management page
  - `updateOverview()` - Update school overview
  - `updatePrincipalMessage()` - Update principal message
  - `deletePrincipalPhoto()` - Delete principal photo

### Views
- `resources/views/admin/settings/school-content.blade.php` - Management page
- `resources/views/admin/settings/index.blade.php` - Added link button
- `resources/views/public/info/principal-message.blade.php` - Display photo & name

### Routes
```php
Route::get('settings/school-content', [SettingController::class, 'schoolContent']);
Route::post('settings/update-overview', [SettingController::class, 'updateOverview']);
Route::post('settings/update-principal-message', [SettingController::class, 'updatePrincipalMessage']);
Route::delete('settings/delete-principal-photo', [SettingController::class, 'deletePrincipalPhoto']);
```

## Cara Penggunaan

### 1. Akses Halaman Management
- Login sebagai admin
- Buka **Pengaturan** → Klik tombol **Kelola Konten Sekolah**
- URL: `/admin/settings/school-content`

### 2. Edit Selayang Pandang
1. Scroll ke section "Selayang Pandang"
2. Edit konten di textarea
3. Klik **Simpan Selayang Pandang**
4. Klik link "Lihat Halaman →" untuk preview

### 3. Edit Sambutan Kepala Sekolah
1. Scroll ke section "Sambutan Kepala Sekolah"
2. Isi/edit nama kepala sekolah
3. Upload foto (opsional):
   - Klik "Choose File"
   - Pilih foto (JPG/PNG, max 2MB)
   - Preview akan muncul otomatis
4. Edit sambutan di textarea
5. Klik **Simpan Sambutan Kepala Sekolah**

### 4. Hapus Foto Kepala Sekolah
1. Jika sudah ada foto, akan muncul tombol delete (icon trash)
2. Klik tombol delete
3. Konfirmasi penghapusan
4. Foto akan terhapus dari storage dan database

## Validasi

### School Overview
- Required
- String/text

### Principal Message
- `principal_name`: Required, max 255 characters
- `principal_photo`: Optional, image (jpeg,png,jpg), max 2MB
- `principal_message`: Required, text

## Storage

Foto kepala sekolah disimpan di:
```
storage/app/public/principal/principal_[timestamp].[ext]
```

## Frontend Display

### Selayang Pandang
URL: `/overview`
- Menampilkan konten dalam format paragraf
- Hero section dengan gradient background
- Breadcrumb navigation

### Sambutan Kepala Sekolah
URL: `/principal-message`
- Menampilkan foto kepala sekolah (rounded, 128x128px)
- Nama dan jabatan
- Sambutan dalam format paragraf
- Hero section dengan gradient emerald

## Features

### Photo Preview
- Real-time preview saat memilih foto
- Preview muncul sebelum upload
- Membantu memastikan foto yang tepat

### Delete Confirmation
- Konfirmasi sebelum delete foto
- Mencegah penghapusan tidak sengaja

### Success Messages
- Feedback setelah save/update
- Feedback setelah delete foto

### Direct Links
- Link "Lihat Halaman →" untuk preview langsung
- Opens in new tab

## Tips & Best Practices

1. **Konten Selayang Pandang**:
   - Jelaskan sejarah sekolah
   - Visi dan misi
   - Prestasi dan keunggulan
   - Fasilitas
   - Program unggulan

2. **Foto Kepala Sekolah**:
   - Gunakan foto formal/resmi
   - Background polos lebih baik
   - Ukuran rekomendasi: 400x400px
   - Format: JPG atau PNG
   - Pastikan wajah terlihat jelas

3. **Sambutan Kepala Sekolah**:
   - Tulis dengan bahasa formal tapi hangat
   - Sampaikan visi dan harapan
   - Ajak siswa/orang tua untuk bergabung
   - Panjang ideal: 3-5 paragraf

## Security

- ✅ Middleware auth & admin required
- ✅ CSRF protection
- ✅ File validation (type, size)
- ✅ Old file deletion on update
- ✅ Storage in secure directory

## Future Enhancements

- [ ] Rich text editor (WYSIWYG)
- [ ] Image cropper for photo
- [ ] Multiple photos gallery
- [ ] Video message support
- [ ] Multi-language content
- [ ] Version history
- [ ] Schedule publish

## Troubleshooting

### Foto tidak muncul
- Pastikan storage link sudah dibuat: `php artisan storage:link`
- Cek permission folder storage
- Pastikan path foto benar di database

### Error saat upload
- Cek max upload size di php.ini
- Pastikan folder storage writable
- Cek format file (harus jpg/png)

### Konten tidak update
- Clear cache: klik tombol "Clear Cache"
- Refresh browser dengan Ctrl+F5
- Cek database apakah data tersimpan

## Support
Untuk pertanyaan atau issue, silakan hubungi tim development.
