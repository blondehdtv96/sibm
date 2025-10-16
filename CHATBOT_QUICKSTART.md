# 🚀 Quick Start - Chatbot SMK Bina Mandiri Bekasi

## Instalasi Cepat

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Test Chatbot
1. Buka website: `http://127.0.0.1:8000`
2. Lihat widget chat di pojok kanan bawah
3. Klik untuk membuka chat
4. Coba tanya:
   - "Halo"
   - "Jurusan apa saja?"
   - "Cara daftar PPDB?"
   - "Alamat sekolah dimana?"

### 3. Akses Admin Panel
1. Login sebagai admin
2. Buka: `http://127.0.0.1:8000/admin/chat-history`
3. Lihat riwayat percakapan

## ✅ Fitur yang Sudah Berfungsi

### Widget Chat
- ✅ Tampilan modern dengan Tailwind CSS
- ✅ Responsive di semua device
- ✅ Animasi typing indicator
- ✅ Menyimpan riwayat di localStorage
- ✅ Badge notifikasi untuk pesan baru

### Chatbot Intelligence
- ✅ Menjawab 14+ topik berbeda
- ✅ Bahasa Indonesia yang ramah
- ✅ Menggunakan emoji
- ✅ Format jawaban yang rapi
- ✅ Fallback response jika tidak tahu

### Admin Panel
- ✅ Dashboard statistik
- ✅ Riwayat percakapan lengkap
- ✅ Filter & search
- ✅ Export ke CSV
- ✅ Hapus riwayat

## 📝 Topik yang Bisa Dijawab Chatbot

1. **Salam & Perkenalan**
   - "Halo", "Hi", "Assalamualaikum"

2. **Profil Sekolah**
   - "Tentang sekolah", "Profil SMK"

3. **Visi Misi**
   - "Visi misi sekolah"

4. **Jurusan**
   - "Jurusan apa saja?", "Program keahlian", "TKJ", "Akuntansi", "DKV"

5. **PPDB**
   - "Cara daftar", "Pendaftaran", "PPDB", "Syarat daftar"

6. **Fasilitas**
   - "Fasilitas sekolah", "Lab", "Perpustakaan"

7. **Alamat & Kontak**
   - "Alamat sekolah", "Kontak", "Telepon", "Email"

8. **Jadwal**
   - "Jadwal pelajaran", "Jam sekolah"

9. **Guru & Staff**
   - "Guru", "Pengajar", "Staff"

10. **Ekstrakurikuler**
    - "Ekskul", "OSIS", "Kegiatan"

11. **Biaya**
    - "Biaya sekolah", "SPP", "Uang sekolah"

12. **Prestasi**
    - "Prestasi sekolah", "Penghargaan", "Juara"

13. **Terima Kasih**
    - "Terima kasih", "Thanks"

14. **Selamat Tinggal**
    - "Bye", "Sampai jumpa"

## 🎨 Kustomisasi Cepat

### Ubah Warna
Edit `resources/views/components/chatbot.blade.php`:
```html
<!-- Line 8: Tombol chat -->
<button class="bg-gradient-to-r from-blue-600 to-purple-600">
<!-- Ganti menjadi warna lain, contoh: -->
<button class="bg-gradient-to-r from-green-600 to-teal-600">
```

### Ubah Welcome Message
Edit `resources/views/components/chatbot.blade.php` line 42:
```html
<p class="text-sm text-gray-800">
    Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. 
    Ada yang bisa saya bantu?
</p>
```

### Tambah Rule Baru
Edit `app/Http/Controllers/ChatbotController.php`:
```php
// Tambahkan setelah rule terakhir (sebelum default response)
if ($this->containsKeywords($message, ['keyword1', 'keyword2'])) {
    return "Jawaban Anda di sini 😊";
}
```

## 🔧 Integrasi OpenAI (Opsional)

Jika ingin menggunakan AI yang lebih pintar:

1. Daftar di [OpenAI](https://platform.openai.com/)
2. Buat API key
3. Tambahkan ke `.env`:
```env
OPENAI_API_KEY=sk-your-api-key-here
```
4. Restart server: `php artisan serve`

Chatbot akan otomatis menggunakan OpenAI jika rule-based tidak menemukan jawaban.

## 📊 Monitoring

### Lihat Statistik
1. Login admin
2. Buka `/admin/chat-history`
3. Lihat:
   - Total chat
   - Chat hari ini
   - Chat minggu ini
   - Chat bulan ini

### Export Data
1. Buka `/admin/chat-history`
2. Klik tombol "Export CSV"
3. File akan terdownload otomatis

## 🐛 Troubleshooting

### Chatbot tidak muncul?
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Restart server
php artisan serve
```

### Pesan tidak terkirim?
1. Check console browser (F12)
2. Pastikan route `/chatbot` ada:
```bash
php artisan route:list | grep chatbot
```

### Database error?
```bash
# Jalankan ulang migration
php artisan migrate:fresh
```

## 📚 Dokumentasi Lengkap

Lihat [CHATBOT_DOCUMENTATION.md](CHATBOT_DOCUMENTATION.md) untuk:
- Penjelasan detail cara kerja
- Cara menambah rule baru
- Integrasi OpenAI
- Kustomisasi advanced
- API documentation
- Dan lainnya

## 🎯 Testing Checklist

- [ ] Widget chat muncul di pojok kanan bawah
- [ ] Klik tombol chat membuka window
- [ ] Ketik "Halo" dan dapat balasan
- [ ] Ketik "Jurusan" dan dapat info jurusan
- [ ] Ketik "PPDB" dan dapat info pendaftaran
- [ ] Chat tersimpan di localStorage (refresh page, chat masih ada)
- [ ] Admin bisa lihat riwayat di `/admin/chat-history`
- [ ] Export CSV berfungsi
- [ ] Responsive di mobile

## 💡 Tips

1. **Gunakan emoji** - Membuat chatbot lebih friendly
2. **Jawaban singkat** - User lebih suka jawaban to-the-point
3. **Update rule** - Tambahkan rule baru berdasarkan pertanyaan yang sering
4. **Monitor analytics** - Lihat pertanyaan apa yang paling sering ditanya
5. **Test di mobile** - Pastikan responsive di semua device

## 🆘 Butuh Bantuan?

- 📖 Baca dokumentasi lengkap: [CHATBOT_DOCUMENTATION.md](CHATBOT_DOCUMENTATION.md)
- 💬 Tanya di chatbot website (meta! 😄)
- 📧 Email: support@smkbinamandiri.sch.id

---

**Happy Chatting! 🤖💬**
