# 📹 Panduan Video YouTube di Homepage

Panduan untuk menambahkan dan mengganti video YouTube di halaman home website.

## 📍 Lokasi Video

Video YouTube ditampilkan di halaman home, setelah Quick Links dan sebelum section Berita Terbaru.

**File:** `resources/views/public/home.blade.php`

## 🎬 Cara Mengganti Video YouTube

### 1. Dapatkan ID Video YouTube

**Dari URL YouTube:**
```
https://www.youtube.com/watch?v=dQw4w9WgXcQ
                                 ^^^^^^^^^^^
                                 Ini ID Video
```

**Atau dari URL Share:**
```
https://youtu.be/dQw4w9WgXcQ
                 ^^^^^^^^^^^
                 Ini ID Video
```

### 2. Edit File Home

Buka file: `resources/views/public/home.blade.php`

Cari bagian ini (sekitar line 60-70):

```html
<iframe 
    src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
    title="Video Profil SMK Bina Mandiri Bekasi" 
    frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
    allowfullscreen
    loading="lazy"
></iframe>
```

### 3. Ganti ID Video

Ganti `dQw4w9WgXcQ` dengan ID video YouTube Anda:

```html
<iframe 
    src="https://www.youtube.com/embed/YOUR_VIDEO_ID_HERE" 
    title="Video Profil SMK Bina Mandiri Bekasi" 
    frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
    allowfullscreen
    loading="lazy"
></iframe>
```

### 4. Update Deskripsi (Opsional)

Anda juga bisa mengubah judul dan deskripsi video:

```html
<div class="video-description">
    <h3 class="video-title">Judul Video Anda</h3>
    <p class="video-text">
        Deskripsi video Anda di sini...
    </p>
</div>
```

## 🎨 Fitur Video Section

### Responsive Design
- ✅ Aspect ratio 16:9 (standar YouTube)
- ✅ Responsive di semua device
- ✅ Mobile-friendly
- ✅ Tablet-optimized

### Performance
- ✅ Lazy loading (video load saat terlihat)
- ✅ Tidak autoplay (hemat bandwidth)
- ✅ Optimized embed

### Styling
- ✅ Card design dengan shadow
- ✅ Rounded corners
- ✅ Clean dan modern
- ✅ Consistent dengan design website

## 📱 Preview di Berbagai Device

### Desktop (> 1024px)
```
┌─────────────────────────────────────┐
│                                     │
│         Video YouTube 16:9          │
│                                     │
├─────────────────────────────────────┤
│         Judul Video                 │
│    Deskripsi video di sini...       │
└─────────────────────────────────────┘
```

### Tablet (768px - 1024px)
```
┌───────────────────────────┐
│                           │
│    Video YouTube 16:9     │
│                           │
├───────────────────────────┤
│      Judul Video          │
│  Deskripsi video...       │
└───────────────────────────┘
```

### Mobile (< 768px)
```
┌─────────────────┐
│                 │
│ Video YouTube   │
│     16:9        │
│                 │
├─────────────────┤
│  Judul Video    │
│  Deskripsi...   │
└─────────────────┘
```

## 🎯 Contoh Penggunaan

### Video Profil Sekolah
```html
<iframe 
    src="https://www.youtube.com/embed/ABC123XYZ" 
    title="Profil SMK Bina Mandiri Bekasi 2025" 
    ...
></iframe>

<div class="video-description">
    <h3 class="video-title">Profil SMK Bina Mandiri Bekasi</h3>
    <p class="video-text">
        Kenali lebih dekat SMK Bina Mandiri Bekasi melalui video profil ini. 
        Lihat fasilitas lengkap, program keahlian unggulan, dan prestasi siswa kami.
    </p>
</div>
```

### Video Tour Virtual
```html
<iframe 
    src="https://www.youtube.com/embed/DEF456UVW" 
    title="Virtual Tour SMK Bina Mandiri Bekasi" 
    ...
></iframe>

<div class="video-description">
    <h3 class="video-title">Virtual Tour Sekolah</h3>
    <p class="video-text">
        Jelajahi sekolah kami secara virtual! Lihat ruang kelas, laboratorium, 
        perpustakaan, dan fasilitas lainnya.
    </p>
</div>
```

### Video Testimoni Alumni
```html
<iframe 
    src="https://www.youtube.com/embed/GHI789RST" 
    title="Testimoni Alumni SMK Bina Mandiri Bekasi" 
    ...
></iframe>

<div class="video-description">
    <h3 class="video-title">Testimoni Alumni</h3>
    <p class="video-text">
        Dengarkan cerita sukses alumni kami yang kini berkarir di berbagai perusahaan 
        ternama dan melanjutkan pendidikan ke perguruan tinggi terbaik.
    </p>
</div>
```

## 🔧 Kustomisasi Lanjutan

### Mengubah Aspect Ratio

Jika ingin aspect ratio berbeda, edit CSS:

```css
.video-wrapper {
    padding-bottom: 56.25%; /* 16:9 (default) */
    /* padding-bottom: 75%; */ /* 4:3 */
    /* padding-bottom: 100%; */ /* 1:1 (square) */
}
```

### Menambah Multiple Videos

Untuk menampilkan beberapa video:

```html
<div class="video-grid">
    <div class="video-item">
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/VIDEO_ID_1" ...></iframe>
        </div>
        <h4>Video 1</h4>
    </div>
    
    <div class="video-item">
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/VIDEO_ID_2" ...></iframe>
        </div>
        <h4>Video 2</h4>
    </div>
</div>
```

Tambahkan CSS:

```css
.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}
```

### Autoplay Video (Tidak Disarankan)

Jika ingin video autoplay (mute):

```html
<iframe 
    src="https://www.youtube.com/embed/VIDEO_ID?autoplay=1&mute=1" 
    ...
></iframe>
```

⚠️ **Warning:** Autoplay dapat mengganggu user experience dan menggunakan bandwidth.

### Playlist YouTube

Untuk embed playlist:

```html
<iframe 
    src="https://www.youtube.com/embed/videoseries?list=PLAYLIST_ID" 
    ...
></iframe>
```

## 🎓 Tips & Best Practices

### DO ✅
- Gunakan video berkualitas HD (720p atau 1080p)
- Durasi video ideal: 2-5 menit
- Tambahkan subtitle untuk accessibility
- Gunakan thumbnail yang menarik
- Update video secara berkala
- Test di berbagai device

### DON'T ❌
- Jangan gunakan video terlalu panjang (> 10 menit)
- Jangan autoplay dengan suara
- Jangan embed terlalu banyak video di satu halaman
- Jangan lupa update deskripsi
- Jangan gunakan video dengan copyright issue

## 🐛 Troubleshooting

### Video Tidak Muncul

**Solusi:**
1. Check ID video sudah benar
2. Pastikan video bukan private
3. Check internet connection
4. Clear browser cache

### Video Tidak Responsive

**Solusi:**
1. Pastikan CSS sudah di-include
2. Check `.video-wrapper` class
3. Refresh browser

### Video Lambat Loading

**Solusi:**
1. Pastikan `loading="lazy"` ada
2. Compress video di YouTube
3. Check internet speed

## 📊 Analytics

Untuk tracking video views, gunakan YouTube Analytics:
1. Buka YouTube Studio
2. Pilih video
3. Lihat Analytics
4. Check "Traffic source" untuk lihat dari mana views berasal

## 🔗 Resources

- [YouTube Embed API](https://developers.google.com/youtube/iframe_api_reference)
- [YouTube Player Parameters](https://developers.google.com/youtube/player_parameters)
- [Responsive iframes](https://css-tricks.com/fluid-width-video/)

## 📝 Checklist

Sebelum publish:
- [ ] Video ID sudah diganti
- [ ] Judul video sudah diupdate
- [ ] Deskripsi video sudah diupdate
- [ ] Test di desktop
- [ ] Test di tablet
- [ ] Test di mobile
- [ ] Video bisa diplay
- [ ] Loading smooth
- [ ] Responsive di semua device

---

**Video YouTube Integration - Complete! 📹✨**

*Last Updated: 15 Oktober 2025*
