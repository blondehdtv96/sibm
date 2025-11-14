# SMK Bina Mandiri Bekasi - School Management System

## 📚 Dokumentasi Lengkap

Sistem Manajemen Sekolah berbasis web untuk SMK Bina Mandiri Bekasi yang dibangun dengan Laravel 10 dan Tailwind CSS.

---

## 🎯 Daftar Isi

### 1. [Pengenalan](#pengenalan)
### 2. [Fitur Utama](#fitur-utama)
### 3. [Teknologi](#teknologi)
### 4. [Instalasi](#instalasi)
### 5. [Struktur Proyek](#struktur-proyek)
### 6. [Modul & Fitur](#modul--fitur)
### 7. [Panduan Pengguna](#panduan-pengguna)
### 8. [Panduan Developer](#panduan-developer)
### 9. [API & Integrasi](#api--integrasi)
### 10. [Troubleshooting](#troubleshooting)
### 11. [Changelog](#changelog)
### 12. [Kontributor](#kontributor)

---

## Pengenalan

### Tentang Sistem

Sistem Manajemen Sekolah SMK Bina Mandiri Bekasi adalah aplikasi web komprehensif yang dirancang untuk:
- Mengelola informasi sekolah
- Mengelola program keahlian/kompetensi
- Sistem PPDB (Penerimaan Peserta Didik Baru) online
- Manajemen berita dan galeri
- Chatbot untuk informasi otomatis
- Dan banyak lagi

### Tujuan

1. **Digitalisasi**: Mengubah proses manual menjadi digital
2. **Efisiensi**: Meningkatkan efisiensi operasional sekolah
3. **Transparansi**: Memberikan informasi yang transparan kepada publik
4. **Aksesibilitas**: Mudah diakses dari mana saja
5. **Modern**: Tampilan modern dan user-friendly

### Target Pengguna

- **Admin Sekolah**: Mengelola seluruh konten dan data
- **Calon Siswa**: Mendaftar PPDB online
- **Orang Tua**: Melihat informasi sekolah
- **Pengunjung**: Mendapatkan informasi umum

---

## Fitur Utama

### 🏠 Frontend (Public)

#### 1. Homepage
- **Dynamic Slider**: Slider homepage dengan multiple images
- **Statistics**: Tampilan statistik sekolah
- **Quick Links**: Akses cepat ke halaman penting
- **Latest News**: Berita terbaru
- **Program Showcase**: Tampilan program keahlian
- **Gallery Preview**: Preview galeri kegiatan

#### 2. Tentang Sekolah
- **Selayang Pandang**: Overview sekolah
- **Sambutan Kepala Sekolah**: Pesan dari kepala sekolah
- **Visi & Misi**: Visi misi sekolah
- **Struktur Organisasi**: Struktur organisasi sekolah

#### 3. Program Keahlian
- **List Program**: Daftar semua program keahlian
- **Detail Program**: Informasi lengkap setiap program
- **Image Slider**: Galeri foto per program
- **Kepala Program**: Foto dan sambutan kepala program
- **Deskripsi Rich Text**: Deskripsi dengan formatting

#### 4. Berita & Artikel
- **List Berita**: Daftar berita dengan pagination
- **Detail Berita**: Konten berita lengkap
- **Kategori**: Filter berdasarkan kategori
- **Search**: Pencarian berita
- **Featured Image**: Gambar unggulan

#### 5. Galeri
- **Album Galeri**: Organisasi foto dalam album
- **Lightbox**: Preview foto full screen
- **Filter**: Filter berdasarkan album
- **Responsive Grid**: Tampilan grid responsif

#### 6. PPDB Online
- **Form Pendaftaran**: Form lengkap untuk pendaftaran
- **Upload Dokumen**: Upload berkas persyaratan
- **Cek Status**: Cek status pendaftaran
- **Notifikasi**: Email notifikasi otomatis
- **Print Bukti**: Cetak bukti pendaftaran

#### 7. Kontak
- **Informasi Kontak**: Alamat, telepon, email
- **Social Media**: Link ke media sosial
- **Google Maps**: Lokasi sekolah
- **Contact Form**: Form kontak (opsional)

#### 8. Chatbot
- **Auto Response**: Jawaban otomatis untuk pertanyaan umum
- **Chat History**: Riwayat percakapan
- **Floating Widget**: Widget chat mengambang
- **Customizable**: Response dapat dikustomisasi

### 🔐 Backend (Admin)

#### 1. Dashboard
- **Statistics**: Statistik overview
- **Recent Activities**: Aktivitas terbaru
- **Quick Actions**: Akses cepat ke fitur
- **Charts**: Grafik data

#### 2. Manajemen Konten

##### Pages Management
- CRUD halaman statis
- Rich text editor (Quill)
- SEO meta tags
- Publish/Draft status

##### News Management
- CRUD berita
- Kategori berita
- Featured image
- Rich text content
- Publish scheduling

##### Gallery Management
- Album management
- Multiple image upload
- Image captions
- Album cover

#### 3. Program Keahlian

##### Competency Management
- CRUD program keahlian
- Rich text description
- Program image
- Sort order
- Active/Inactive status

##### Competency Images
- Multiple images per program
- Image slider
- Captions & descriptions
- Order management

##### Head of Program
- Nama kepala program
- Foto kepala program
- Sambutan/pesan
- Display di detail program

#### 4. PPDB Management

##### Settings
- Periode pendaftaran
- Kuota per program
- Biaya pendaftaran
- Persyaratan dokumen

##### Registrations
- List pendaftaran
- Detail pendaftaran
- Approve/Reject
- Export data
- Print bukti

##### Notifications
- Email templates
- Auto notifications
- Manual notifications

#### 5. Settings

##### School Content
- Selayang pandang
- Sambutan kepala sekolah
- Visi & misi
- Rich text editor

##### Contact & Social
- Alamat sekolah
- Nomor telepon
- Email
- Social media links
- Google Maps embed

##### Menu Management
- Dynamic menu
- Parent-child structure
- Icon support
- Order management
- Active/Inactive

##### Home Slider
- Multiple image upload
- Title & subtitle
- CTA button
- Order management
- Active/Inactive

#### 6. Chatbot Management
- CRUD responses
- Keywords/triggers
- Response text
- Active/Inactive
- Chat history view

#### 7. User Management
- CRUD users
- Roles & permissions
- Profile management
- Password reset

---

## Teknologi

### Backend
- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze
- **Storage**: Laravel Storage (local/public)

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Icons**: Heroicons
- **Fonts**: Inter (Google Fonts)

### Libraries & Tools
- **Rich Text Editor**: Quill.js
- **Image Slider**: Swiper.js
- **File Upload**: Native HTML5
- **Notifications**: Laravel Notifications
- **Email**: Laravel Mail

### Development Tools
- **Version Control**: Git
- **Package Manager**: Composer, NPM
- **Server**: Apache/Nginx
- **Local Dev**: XAMPP/Laragon/Valet

---

## Instalasi

### Requirements
```
- PHP >= 8.1
- MySQL >= 8.0
- Composer
- Node.js & NPM
- Apache/Nginx
```

### Step 1: Clone Repository
```bash
git clone https://github.com/your-repo/sibm.git
cd sibm
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### Step 3: Environment Setup
```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibm
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Migrations
```bash
# Run migrations
php artisan migrate

# Run seeders (optional)
php artisan db:seed
```

### Step 6: Storage Link
```bash
# Create storage symbolic link
php artisan storage:link
```

### Step 7: Build Assets
```bash
# Build for development
npm run dev

# Build for production
npm run build
```

### Step 8: Run Server
```bash
# Development server
php artisan serve

# Access at: http://localhost:8000
```

---

## Struktur Proyek

### Directory Structure
```
sibm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication
│   │   │   └── Public/         # Public controllers
│   │   └── Middleware/
│   ├── Models/                 # Eloquent models
│   ├── Notifications/          # Email notifications
│   └── View/
│       └── Composers/          # View composers
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── docs/                       # Documentation
│   ├── features/               # Feature docs
│   ├── fixes/                  # Bug fix docs
│   └── guides/                 # User guides
├── public/
│   ├── css/                    # Compiled CSS
│   ├── js/                     # Compiled JS
│   └── storage/                # Public storage link
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   ├── public/             # Public views
│   │   ├── layouts/            # Layout templates
│   │   ├── components/         # Blade components
│   │   └── errors/             # Error pages
│   └── css/                    # Source CSS
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
├── storage/
│   ├── app/
│   │   └── public/             # Public files
│   └── logs/                   # Application logs
└── tests/                      # Tests
```

### Key Files
```
.env                    # Environment configuration
composer.json           # PHP dependencies
package.json            # JavaScript dependencies
artisan                 # Laravel CLI
webpack.mix.js          # Asset compilation
```

---

## Modul & Fitur

### 1. Homepage Slider
**Lokasi**: `docs/features/`
- Multiple image upload
- Dynamic slider dengan Swiper.js
- Title, subtitle, CTA button
- Responsive height (500-650px)
- Image fit (object-contain)
- Auto-play dengan navigation

**Dokumentasi**:
- `HOMEPAGE_SLIDER_FINAL_SUMMARY.md`
- `MULTIPLE_IMAGE_UPLOAD_FEATURE.md`
- `SLIDER_HEIGHT_ADJUSTMENT.md`
- `SLIDER_IMAGE_FIT_ADJUSTMENT.md`

### 2. Program Keahlian
**Lokasi**: `docs/features/`
- CRUD program keahlian
- Rich text description
- Image slider per program
- Kepala program (foto & sambutan)
- Logo size adjustment

**Dokumentasi**:
- `COMPETENCY_HEAD_OF_PROGRAM_FEATURE.md`
- `COMPETENCY_IMAGE_SLIDER.md`
- `COMPETENCY_SLIDER_INTEGRATION.md`
- `COMPETENCY_LOGO_SIZE_ADJUSTMENT.md`

### 3. Menu Management
**Lokasi**: `docs/features/`
- Dynamic menu system
- Parent-child structure
- Icon support
- Order management

**Dokumentasi**:
- `MENU_MANAGEMENT.md`

### 4. School Content
**Lokasi**: `docs/features/`
- Selayang pandang
- Sambutan kepala sekolah
- Rich text editor

**Dokumentasi**:
- `SCHOOL_CONTENT_MANAGEMENT.md`

### 5. Rich Text Editor
**Lokasi**: `docs/features/`
- Quill.js integration
- Bold, italic, lists, etc.
- Auto-initialization

**Dokumentasi**:
- `TINYMCE_RICH_TEXT_EDITOR.md`

### 6. Bug Fixes
**Lokasi**: `docs/fixes/`
- Custom error pages
- Logo preview feature
- Back button loading fix
- 404 error fix
- Image fit adjustments

**Dokumentasi**:
- `CUSTOM_ERROR_PAGES.md`
- `LOGO_PREVIEW_FEATURE.md`
- `BACK_BUTTON_LOADING_FIX.md`
- `LOGO_404_ERROR_FIX.md`

---

## Panduan Pengguna

### Untuk Admin

#### Login ke Admin Panel
1. Akses: `http://yoursite.com/admin`
2. Masukkan email dan password
3. Klik "Login"

#### Mengelola Slider Homepage
1. Login → Sidebar → "Home Slider"
2. Klik "Tambah Slider"
3. Pilih multiple images (Ctrl+Click)
4. Isi title, subtitle, button
5. Set order dan status
6. Klik "Simpan Slider"

#### Mengelola Program Keahlian
1. Login → "Competencies"
2. Klik "Create Competency Program"
3. Isi nama program
4. Tulis deskripsi (gunakan toolbar untuk formatting)
5. Upload gambar program
6. Isi data kepala program (opsional)
7. Set status dan order
8. Klik "Create Program"

#### Menambah Gambar ke Program
1. Login → "Competencies" → Pilih program
2. Klik "Manage Images"
3. Klik "Add Image"
4. Upload gambar
5. Isi title dan description
6. Set order
7. Klik "Save"

#### Mengelola Berita
1. Login → "News"
2. Klik "Create News"
3. Isi judul dan excerpt
4. Tulis konten (gunakan rich text editor)
5. Upload featured image
6. Pilih kategori
7. Set status dan tanggal publish
8. Klik "Create News"

#### Mengelola PPDB
1. Login → "PPDB Settings"
2. Set periode pendaftaran
3. Set kuota per program
4. Set biaya pendaftaran
5. Klik "Save Settings"

**Melihat Pendaftaran**:
1. Login → "PPDB Registrations"
2. Lihat list pendaftaran
3. Klik "View" untuk detail
4. Approve/Reject pendaftaran
5. Print bukti jika approved

### Untuk Calon Siswa

#### Mendaftar PPDB
1. Kunjungi website sekolah
2. Klik "Pendaftaran PPDB"
3. Isi form pendaftaran lengkap
4. Upload dokumen persyaratan
5. Klik "Daftar"
6. Simpan nomor pendaftaran

#### Cek Status Pendaftaran
1. Klik "Cek Status PPDB"
2. Masukkan nomor pendaftaran
3. Masukkan tanggal lahir
4. Klik "Cek Status"
5. Lihat status pendaftaran

---

## Panduan Developer

### Coding Standards

#### PHP (Laravel)
```php
// Use PSR-12 coding standard
// Use type hints
public function store(Request $request): RedirectResponse
{
    // Validate input
    $validated = $request->validate([...]);
    
    // Process data
    Model::create($validated);
    
    // Return with message
    return redirect()->route('...')->with('success', 'Message');
}
```

#### Blade Templates
```blade
{{-- Use Blade directives --}}
@extends('layouts.app')

@section('content')
    {{-- Content here --}}
@endsection

{{-- Escape output by default --}}
{{ $variable }}

{{-- Raw HTML only when needed --}}
{!! $htmlContent !!}
```

#### JavaScript
```javascript
// Use modern ES6+ syntax
const initEditor = () => {
    // Code here
};

// Use Alpine.js for interactivity
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
</div>
```

### Database Conventions

#### Migrations
```php
// Use descriptive names
2025_01_08_120000_create_home_sliders_table.php

// Use proper column types
$table->string('name');
$table->text('description');
$table->integer('order')->default(0);
$table->enum('status', ['active', 'inactive']);
$table->timestamps();
```

#### Models
```php
// Use fillable or guarded
protected $fillable = ['name', 'description', ...];

// Use casts
protected $casts = [
    'published_at' => 'datetime',
    'is_active' => 'boolean',
];

// Use relationships
public function images()
{
    return $this->hasMany(Image::class);
}
```

### Adding New Features

#### Step 1: Create Migration
```bash
php artisan make:migration create_features_table
```

#### Step 2: Create Model
```bash
php artisan make:model Feature
```

#### Step 3: Create Controller
```bash
php artisan make:controller Admin/FeatureController --resource
```

#### Step 4: Add Routes
```php
// routes/web.php
Route::resource('admin/features', FeatureController::class);
```

#### Step 5: Create Views
```
resources/views/admin/features/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
└── show.blade.php
```

#### Step 6: Add to Sidebar
```blade
{{-- layouts/admin-modern.blade.php --}}
<a href="{{ route('admin.features.index') }}">
    Features
</a>
```

### Testing

#### Run Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter FeatureTest
```

#### Create Test
```bash
php artisan make:test FeatureTest
```

---

## API & Integrasi

### Internal APIs

#### Chatbot API
```php
POST /chatbot/message
{
    "message": "Berapa biaya pendaftaran?"
}

Response:
{
    "response": "Biaya pendaftaran adalah Rp 500.000"
}
```

#### PPDB Status Check
```php
GET /ppdb/check-status
{
    "registration_number": "PPDB2025001",
    "birth_date": "2008-01-15"
}

Response:
{
    "status": "approved",
    "message": "Pendaftaran Anda telah disetujui"
}
```

### External Integrations

#### Email (SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

#### Google Maps
```html
<iframe src="https://maps.google.com/maps?q=..."></iframe>
```

#### Social Media
- Facebook Page Plugin
- Instagram Feed (manual)
- YouTube Embed

---

## Troubleshooting

### Common Issues

#### 1. Storage Link Not Working
**Problem**: Images not displaying
**Solution**:
```bash
php artisan storage:link
```

#### 2. Permission Denied
**Problem**: Cannot write to storage
**Solution**:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### 3. 500 Internal Server Error
**Problem**: White screen or 500 error
**Solution**:
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 4. Database Connection Error
**Problem**: Cannot connect to database
**Solution**:
- Check `.env` database credentials
- Ensure MySQL is running
- Test connection: `php artisan migrate:status`

#### 5. Rich Text Editor Not Loading
**Problem**: Quill editor not initializing
**Solution**:
- Check browser console for errors
- Verify CDN is accessible
- Ensure textarea has class `tinymce` or `rich-editor`

#### 6. File Upload Fails
**Problem**: Cannot upload files
**Solution**:
```ini
; Check php.ini
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20
```

### Debug Mode

#### Enable Debug
```env
APP_DEBUG=true
APP_ENV=local
```

#### Disable Debug (Production)
```env
APP_DEBUG=false
APP_ENV=production
```

---

## Changelog

### Version 2.2.0 (January 14, 2025)

#### Added
- ✅ Rich text editor (Quill.js) for all description fields
- ✅ Head of program feature (photo & message)
- ✅ Multiple image upload for home slider
- ✅ Competency image slider
- ✅ Logo size adjustments

#### Changed
- ✅ Slider height from full-screen to proportional (500-650px)
- ✅ Image fit from object-cover to object-contain
- ✅ Admin competency edit page styling
- ✅ Replaced TinyMCE with Quill editor

#### Fixed
- ✅ Custom error pages (404, 403, 500)
- ✅ Logo preview feature
- ✅ Back button loading state
- ✅ 404 error logo display

### Version 2.1.0 (January 8, 2025)

#### Added
- ✅ Homepage dynamic slider system
- ✅ Competency management
- ✅ Menu management
- ✅ School content management

#### Changed
- ✅ Homepage redesign
- ✅ Modern admin layout

### Version 2.0.0 (October 15, 2024)

#### Added
- ✅ PPDB online system
- ✅ Chatbot feature
- ✅ Settings management
- ✅ Notification system

### Version 1.0.0 (Initial Release)

#### Added
- ✅ Basic CMS functionality
- ✅ News management
- ✅ Gallery management
- ✅ Pages management
- ✅ User authentication

---

## Kontributor

### Development Team
- **Lead Developer**: Kiro AI Assistant
- **Project Manager**: SMK Bina Mandiri Bekasi
- **UI/UX Design**: Tailwind CSS Team
- **Testing**: QA Team

### Technologies Used
- Laravel Framework
- Tailwind CSS
- Alpine.js
- Quill.js
- Swiper.js

### Special Thanks
- Laravel Community
- Tailwind CSS Community
- Stack Overflow
- GitHub

---

## License

This project is proprietary software developed for SMK Bina Mandiri Bekasi.

**Copyright © 2025 SMK Bina Mandiri Bekasi. All rights reserved.**

---

## Support & Contact

### Technical Support
- **Email**: support@smkbinamandiri.sch.id
- **Phone**: (021) xxx-xxxx
- **Website**: https://smkbinamandiri.sch.id

### Documentation
- **Location**: `/docs` directory
- **Online**: https://docs.smkbinamandiri.sch.id

### Report Issues
- Create issue in project repository
- Email to technical support
- Contact system administrator

---

## Quick Links

### Documentation Files
- [Complete System Documentation](COMPLETE_SYSTEM_DOCUMENTATION.md)
- [Technical Documentation](TECHNICAL_DOCUMENTATION.md)
- [Admin Quick Guide](ADMIN_QUICK_GUIDE.md)
- [Implementation Guide](IMPLEMENTATION_COMPLETE_GUIDE.md)

### Feature Documentation
- [Homepage Slider](features/HOMEPAGE_SLIDER_FINAL_SUMMARY.md)
- [Competency Management](features/COMPETENCY_HEAD_OF_PROGRAM_FEATURE.md)
- [Menu Management](features/MENU_MANAGEMENT.md)
- [Rich Text Editor](features/TINYMCE_RICH_TEXT_EDITOR.md)

### Fix Documentation
- [Custom Error Pages](fixes/CUSTOM_ERROR_PAGES.md)
- [Logo Fixes](fixes/LOGO_404_ERROR_FIX.md)
- [UI Adjustments](fixes/SLIDER_HEIGHT_ADJUSTMENT.md)

---

**Last Updated**: January 14, 2025  
**Version**: 2.2.0  
**Status**: Production Ready ✅

---

Made with ❤️ by SMK Bina Mandiri Bekasi Development Team
