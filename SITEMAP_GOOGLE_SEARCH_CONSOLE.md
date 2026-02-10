# Sitemap & Google Search Console Setup ✅

## 🎯 Sitemap yang Dibuat

### 1. **Sitemap.xml** - Dinamis & Otomatis
URL: `https://yourdomain.com/sitemap.xml`

### 2. **Robots.txt** - SEO Friendly
URL: `https://yourdomain.com/robots.txt`

---

## 📋 Konten yang Termasuk dalam Sitemap

### ✅ Halaman Statis
- **Homepage** (`/`) - Priority: 1.0, Update: Daily
- **Tentang Kami** (`/about`) - Priority: 0.9, Update: Weekly
- **Kontak** (`/contact`) - Priority: 0.8, Update: Monthly
- **PPDB Register** (`/ppdb/register`) - Priority: 0.9, Update: Daily
- **PPDB Check Status** (`/ppdb/check-status`) - Priority: 0.7, Update: Daily

### ✅ Berita (News)
- **Index Berita** (`/news`) - Priority: 0.9, Update: Daily
- **Artikel Berita** (`/news/{slug}`) - Priority: 0.8, Update: Weekly
  - Termasuk featured image
  - Termasuk gallery images
  - Hanya artikel yang published

### ✅ Program Keahlian (Competencies)
- **Index Program** (`/competencies`) - Priority: 0.9, Update: Weekly
- **Detail Program** (`/competencies/{slug}`) - Priority: 0.8, Update: Monthly
  - Termasuk featured image
  - Termasuk gallery images
  - Hanya program yang aktif

### ✅ Galeri (Gallery)
- **Index Galeri** (`/gallery`) - Priority: 0.8, Update: Weekly
- **Album Galeri** (`/gallery/{slug}`) - Priority: 0.7, Update: Weekly
  - Termasuk cover image
  - Termasuk 10 foto pertama dari album
  - Hanya album yang aktif

### ✅ Halaman Dinamis
- **Custom Pages** (`/pages/{slug}`) - Priority: 0.6, Update: Monthly
  - Semua halaman dari database
  - Hanya yang status published

### ✅ Menu Kustom
- **Custom Menu URLs** - Priority: 0.5, Update: Monthly
  - Menu dengan URL custom
  - Hanya internal URLs

---

## 🚀 Cara Mendaftarkan ke Google Search Console

### Step 1: Akses Sitemap
1. Buka browser dan akses: `http://127.0.0.1:8000/sitemap.xml`
2. Pastikan XML muncul dengan benar
3. Cek juga: `http://127.0.0.1:8000/robots.txt`

### Step 2: Verifikasi Domain di Google Search Console

#### Metode 1: HTML File Upload (Paling Mudah)
1. Login ke [Google Search Console](https://search.google.com/search-console)
2. Klik "Add Property" → Pilih "URL prefix"
3. Masukkan URL website: `https://yourdomain.com`
4. Pilih metode verifikasi: **HTML file**
5. Download file verifikasi (contoh: `google1234567890abcdef.html`)
6. Upload file ke folder `public/` di Laravel
7. Akses file untuk test: `https://yourdomain.com/google1234567890abcdef.html`
8. Klik "Verify" di Google Search Console

#### Metode 2: HTML Tag (Meta Tag)
1. Pilih metode verifikasi: **HTML tag**
2. Copy meta tag yang diberikan
3. Paste di file `resources/views/layouts/public-tailwind.blade.php`
4. Letakkan di dalam `<head>` section (sudah ada di baris ~5-10)
5. Contoh:
```html
<meta name="google-site-verification" content="your-verification-code" />
```
6. Clear cache Laravel: `php artisan view:clear`
7. Klik "Verify" di Google Search Console

#### Metode 3: DNS Record (Paling Permanen)
1. Pilih metode verifikasi: **DNS record**
2. Copy TXT record yang diberikan
3. Login ke DNS provider (Cloudflare, Namecheap, dll)
4. Tambahkan TXT record:
   - Type: `TXT`
   - Name: `@` atau domain root
   - Value: `google-site-verification=xxxxx`
5. Tunggu propagasi DNS (5-30 menit)
6. Klik "Verify" di Google Search Console

### Step 3: Submit Sitemap
1. Setelah domain terverifikasi
2. Di Google Search Console, pilih property Anda
3. Klik menu **"Sitemaps"** di sidebar kiri
4. Masukkan URL sitemap: `sitemap.xml`
5. Klik **"Submit"**
6. Status akan berubah menjadi "Success" dalam beberapa menit

### Step 4: Monitor Indexing
1. Tunggu 24-48 jam untuk indexing pertama
2. Cek menu **"Coverage"** untuk melihat halaman yang terindex
3. Cek menu **"Performance"** untuk melihat traffic dari Google

---

## 🔧 Fitur Sitemap

### ✨ Fitur Utama
- ✅ **Dinamis** - Otomatis update sesuai konten database
- ✅ **Image Sitemap** - Include gambar untuk Google Images
- ✅ **Priority & Frequency** - SEO optimized
- ✅ **Cache** - Cache 1 jam untuk performa
- ✅ **XML Valid** - Sesuai standar Google

### 📊 Priority Levels
- `1.0` - Homepage (paling penting)
- `0.9` - Halaman utama (About, News Index, PPDB)
- `0.8` - Konten utama (News articles, Competencies)
- `0.7` - Konten sekunder (Gallery albums)
- `0.6` - Halaman dinamis
- `0.5` - Menu custom

### ⏰ Update Frequency
- `daily` - Homepage, News, PPDB (update setiap hari)
- `weekly` - About, News articles, Gallery (update mingguan)
- `monthly` - Competencies, Pages, Menus (update bulanan)

---

## 🛡️ Robots.txt Configuration

File `robots.txt` sudah dikonfigurasi untuk:

### ✅ Allow (Diizinkan untuk crawl)
- Semua halaman public (`/`)

### ❌ Disallow (Tidak diizinkan untuk crawl)
- `/admin/` - Admin panel
- `/dashboard/` - User dashboard
- `/login` - Login page
- `/register` - Register page
- `/storage/private/` - Private files

### 📍 Sitemap Location
- Otomatis mengarahkan ke sitemap.xml

---

## 🧪 Testing Sitemap

### Test Lokal
```bash
# Akses sitemap
curl http://127.0.0.1:8000/sitemap.xml

# Akses robots.txt
curl http://127.0.0.1:8000/robots.txt
```

### Test Online
1. Upload ke server production
2. Akses: `https://yourdomain.com/sitemap.xml`
3. Validate di: [XML Sitemap Validator](https://www.xml-sitemaps.com/validate-xml-sitemap.html)

### Google Testing Tools
1. [Rich Results Test](https://search.google.com/test/rich-results)
2. [Mobile-Friendly Test](https://search.google.com/test/mobile-friendly)
3. [PageSpeed Insights](https://pagespeed.web.dev/)

---

## 📝 Maintenance

### Update Sitemap
Sitemap akan otomatis update setiap kali:
- ✅ Ada berita baru dipublish
- ✅ Ada program keahlian baru ditambahkan
- ✅ Ada album galeri baru dibuat
- ✅ Ada halaman baru dipublish

### Manual Refresh
Jika perlu force refresh:
```bash
# Clear cache
php artisan cache:clear

# Clear route cache
php artisan route:clear
```

### Monitor di Google Search Console
- Cek **Coverage** untuk error indexing
- Cek **Sitemaps** untuk status submit
- Cek **Performance** untuk traffic
- Cek **Mobile Usability** untuk mobile issues

---

## 🎯 Expected Results

### Setelah 24-48 Jam
- ✅ Sitemap terdeteksi oleh Google
- ✅ Halaman mulai terindex
- ✅ Muncul di Google Search

### Setelah 1-2 Minggu
- ✅ Semua halaman terindex
- ✅ Gambar muncul di Google Images
- ✅ Rich snippets mulai muncul
- ✅ Traffic organik mulai meningkat

### Setelah 1 Bulan
- ✅ Ranking mulai stabil
- ✅ Featured snippets (jika konten bagus)
- ✅ Knowledge panel (untuk brand)

---

## 🔗 Useful Links

- [Google Search Console](https://search.google.com/search-console)
- [Sitemap Protocol](https://www.sitemaps.org/protocol.html)
- [Google SEO Starter Guide](https://developers.google.com/search/docs/beginner/seo-starter-guide)
- [Image Sitemap Guidelines](https://developers.google.com/search/docs/advanced/sitemaps/image-sitemaps)

---

## ✅ Checklist Verifikasi

- [ ] Sitemap.xml dapat diakses
- [ ] Robots.txt dapat diakses
- [ ] Domain terverifikasi di Google Search Console
- [ ] Sitemap berhasil disubmit
- [ ] Tidak ada error di Coverage report
- [ ] Meta tags SEO sudah lengkap (sudah ada di layout)
- [ ] Schema.org markup sudah ada (sudah ada di layout)
- [ ] Open Graph tags sudah ada (sudah ada di layout)
- [ ] Twitter Cards sudah ada (sudah ada di layout)

---

## 🎉 Status
✅ **SELESAI** - Sitemap dinamis sudah siap untuk Google Search Console!

**Next Steps:**
1. Upload website ke production server
2. Verifikasi domain di Google Search Console
3. Submit sitemap.xml
4. Monitor indexing progress
