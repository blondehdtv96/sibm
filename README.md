# 🏫 Sistem Manajemen Sekolah Laravel

Sistem Manajemen Sekolah berbasis web yang dibangun dengan Laravel 10, dirancang khusus untuk SMK Bina Mandiri Bekasi. Sistem ini menyediakan fitur lengkap untuk mengelola konten website sekolah, pendaftaran siswa baru (PPDB), dan administrasi sekolah.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat-square&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)

## ✨ Fitur Utama

### 🌐 Website Publik
- **Homepage Modern** - Desain responsif dengan Tailwind CSS
- **Manajemen Halaman** - Halaman statis (Tentang, Kontak, dll)
- **Berita & Artikel** - Sistem berita dengan kategori dan featured image
- **Program Kompetensi** - Showcase program keahlian sekolah
- **Galeri Foto** - Album foto kegiatan sekolah
- **PPDB Online** - Sistem pendaftaran peserta didik baru

### 👨‍💼 Panel Admin
- **Dashboard Modern** - Statistik dan overview sistem
- **Manajemen Konten** - CRUD untuk halaman, berita, kompetensi, galeri
- **Manajemen PPDB** - Verifikasi dan pengelolaan pendaftaran siswa
- **Sistem Notifikasi** - Notifikasi real-time untuk admin
- **Manajemen User** - Kelola pengguna dengan role-based access
- **Audit Log** - Tracking aktivitas pengguna
- **Visitor Analytics** - Statistik pengunjung website

### 🎓 Sistem PPDB
- **Pendaftaran Online** - Form pendaftaran lengkap dengan upload dokumen
- **Cek Status** - Siswa dapat mengecek status pendaftaran
- **Verifikasi Admin** - Admin dapat menerima/menolak pendaftaran
- **Notifikasi Otomatis** - Email dan notifikasi sistem
- **Pengaturan Periode** - Atur periode pendaftaran PPDB

## 🚀 Teknologi yang Digunakan

### Backend
- **Laravel 10.x** - PHP Framework
- **MySQL 8.0+** - Database
- **Laravel Sanctum** - API Authentication
- **Laravel Notifications** - Sistem notifikasi

### Frontend
- **Tailwind CSS 3.x** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework
- **Blade Templates** - Laravel templating engine
- **Heroicons** - Beautiful SVG icons

### Tools & Libraries
- **Intervention Image** - Image processing
- **Laravel Debugbar** - Development debugging
- **Carbon** - Date/time manipulation

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL >= 8.0 atau MariaDB >= 10.3
- Node.js & NPM (untuk asset compilation)
- Web Server (Apache/Nginx)
- PHP Extensions:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
  - GD atau Imagick

## 🔧 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/yourusername/school-management-system.git
cd school-management-system
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies (optional)
npm install
```

### 3. Konfigurasi Environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database
```bash
# Jalankan migrasi
php artisan migrate

# Jalankan seeder (optional)
php artisan db:seed
```

### 6. Storage Link
```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### 7. Jalankan Aplikasi
```bash
# Development server
php artisan serve

# Akses aplikasi di http://localhost:8000
```

## 👤 Default User

Setelah menjalankan seeder, gunakan kredensial berikut untuk login:

**Admin:**
- Email: `admin@school.com`
- Password: `password`

**Teacher:**
- Email: `teacher@school.com`
- Password: `password`

**Student:**
- Email: `student@school.com`
- Password: `password`

> ⚠️ **Penting:** Segera ubah password default setelah login pertama kali!

## 📁 Struktur Direktori

```
school-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   └── Public/         # Public controllers
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                 # Eloquent models
│   ├── Notifications/          # Notification classes
│   └── Traits/                 # Reusable traits
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/
│   ├── css/                    # Compiled CSS
│   ├── js/                     # Compiled JavaScript
│   └── storage/                # Public storage (symlink)
├── resources/
│   └── views/
│       ├── admin/              # Admin views
│       ├── auth/               # Authentication views
│       ├── layouts/            # Layout templates
│       └── public/             # Public views
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
└── storage/
    ├── app/                    # Application storage
    └── logs/                   # Application logs
```

## 🎨 Desain & UI

### Public Website
- **Modern & Responsive** - Desain modern dengan Tailwind CSS
- **Mobile-First** - Optimized untuk semua ukuran layar
- **Fast Loading** - Optimized untuk performa
- **SEO Friendly** - Meta tags dan struktur yang baik

### Admin Panel
- **Clean Interface** - Antarmuka yang bersih dan intuitif
- **Sidebar Navigation** - Navigasi yang mudah digunakan
- **Real-time Notifications** - Notifikasi langsung di header
- **Responsive Dashboard** - Dashboard yang informatif

## 🔐 Keamanan

- **Authentication** - Laravel Sanctum untuk autentikasi
- **Authorization** - Role-based access control (RBAC)
- **CSRF Protection** - Token CSRF untuk semua form
- **Password Hashing** - Bcrypt untuk hashing password
- **SQL Injection Prevention** - Eloquent ORM & prepared statements
- **XSS Protection** - Blade templating auto-escaping
- **Session Security** - Secure session management
- **Audit Logging** - Tracking semua aktivitas penting

## 📊 Fitur Admin

### Dashboard
- Total statistik (users, pages, news, registrations)
- Grafik pendaftaran PPDB
- Recent activities
- Quick actions

### Manajemen Konten
- **Pages** - Kelola halaman statis
- **News** - Kelola berita dengan kategori
- **Competencies** - Kelola program kompetensi
- **Gallery** - Kelola album dan foto

### Manajemen PPDB
- **Registrations** - Lihat dan kelola pendaftaran
- **Verification** - Verifikasi atau tolak pendaftaran
- **Settings** - Atur periode dan persyaratan PPDB
- **Documents** - Download dokumen pendaftar

### Sistem
- **Users** - Kelola pengguna dan role
- **Notifications** - Lihat dan kelola notifikasi
- **Audit Logs** - Tracking aktivitas sistem
- **Visitor Analytics** - Statistik pengunjung

## 🔔 Sistem Notifikasi

Sistem notifikasi otomatis untuk admin:
- ✅ Pendaftaran PPDB baru
- ✅ Badge counter di header dan sidebar
- ✅ Dropdown notifikasi dengan 5 notifikasi terbaru
- ✅ Halaman notifikasi lengkap dengan pagination
- ✅ Mark as read/unread functionality
- ✅ Delete notifications

Lihat [NOTIFICATION_SYSTEM.md](NOTIFICATION_SYSTEM.md) untuk detail lengkap.

## 📱 Responsive Design

Website dan admin panel fully responsive untuk:
- 📱 Mobile (320px - 767px)
- 📱 Tablet (768px - 1023px)
- 💻 Desktop (1024px+)
- 🖥️ Large Desktop (1440px+)

## 🌐 Browser Support

- ✅ Chrome (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Opera (latest)

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` di `.env`
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Generate production key: `php artisan key:generate`
- [ ] Optimize configuration: `php artisan config:cache`
- [ ] Optimize routes: `php artisan route:cache`
- [ ] Optimize views: `php artisan view:cache`
- [ ] Set proper file permissions
- [ ] Configure web server (Apache/Nginx)
- [ ] Setup SSL certificate
- [ ] Configure backup system
- [ ] Setup monitoring & logging

### Web Server Configuration

#### Apache
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/school-management-system/public

    <Directory /path/to/school-management-system/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/school-management-system/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter TestName

# Run with coverage
php artisan test --coverage
```

## 📝 API Documentation

API endpoints tersedia di `/api/*`. Dokumentasi lengkap akan segera ditambahkan.

## 🤝 Contributing

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini dilisensikan di bawah [MIT License](LICENSE).

## 👨‍💻 Developer

Dikembangkan dengan ❤️ untuk SMK Bina Mandiri Bekasi

## 📞 Support

Jika Anda memiliki pertanyaan atau memerlukan bantuan:
- 📧 Email: support@school.com
- 🌐 Website: https://school.com
- 📱 WhatsApp: +62 xxx xxxx xxxx

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript framework
- [Heroicons](https://heroicons.com) - Beautiful hand-crafted SVG icons

## 📚 Dokumentasi Tambahan

- [NOTIFICATION_SYSTEM.md](NOTIFICATION_SYSTEM.md) - Dokumentasi sistem notifikasi
- [SETUP_COMPLETE.md](SETUP_COMPLETE.md) - Setup completion guide
- [ADMIN_MODERNIZATION_SUMMARY.md](ADMIN_MODERNIZATION_SUMMARY.md) - Admin panel modernization

## 🔄 Changelog

### Version 1.0.0 (2025-10-15)
- ✅ Initial release
- ✅ Public website dengan Tailwind CSS
- ✅ Admin panel modern
- ✅ Sistem PPDB online
- ✅ Sistem notifikasi
- ✅ Manajemen konten lengkap
- ✅ User management dengan RBAC
- ✅ Audit logging
- ✅ Visitor analytics

---

**Made with ❤️ using Laravel & Tailwind CSS**
