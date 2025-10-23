# 🎛️ Manajemen Balasan Chatbot

Sistem manajemen balasan chatbot yang memungkinkan admin untuk mengelola balasan chatbot tanpa perlu edit kode.

## ✨ Fitur Baru

### 1. **Database-Driven Responses**
- ✅ Balasan chatbot disimpan di database
- ✅ Admin bisa tambah/edit/hapus balasan
- ✅ Tidak perlu edit kode untuk update balasan
- ✅ Prioritas untuk mengatur urutan pengecekan

### 2. **Admin Panel**
- ✅ Halaman kelola balasan di `/admin/chatbot-responses`
- ✅ CRUD lengkap (Create, Read, Update, Delete)
- ✅ Toggle aktif/nonaktif balasan
- ✅ Filter dan search (coming soon)

### 3. **Flexible Keywords**
- ✅ Multiple keywords per balasan
- ✅ Case-insensitive matching
- ✅ Easy to manage via form

## 📦 File yang Dibuat

### Backend
1. ✅ `database/migrations/2025_10_15_110000_create_chatbot_responses_table.php`
2. ✅ `app/Models/ChatbotResponse.php`
3. ✅ `database/seeders/ChatbotResponseSeeder.php`
4. ✅ `app/Http/Controllers/Admin/ChatbotResponseController.php`

### Frontend
5. ✅ `resources/views/admin/chatbot-responses/index.blade.php`
6. ✅ `resources/views/admin/chatbot-responses/create.blade.php`
7. ✅ `resources/views/admin/chatbot-responses/edit.blade.php`

### Updated Files
8. ✅ `app/Http/Controllers/ChatbotController.php` - Menggunakan database
9. ✅ `routes/web.php` - Route baru
10. ✅ `resources/views/layouts/admin-modern.blade.php` - Menu baru

## 🚀 Cara Menggunakan

### Akses Admin Panel
1. Login sebagai admin
2. Buka menu **"Balasan Chatbot"** di sidebar
3. URL: `/admin/chatbot-responses`

### Tambah Balasan Baru
1. Klik tombol **"Tambah Balasan"**
2. Isi form:
   - **Trigger Name**: Nama unik (contoh: `greeting`, `jurusan`)
   - **Judul**: Judul untuk admin (contoh: "Salam & Perkenalan")
   - **Keywords**: Kata kunci dipisah koma (contoh: `halo, hai, hello`)
   - **Balasan**: Teks balasan chatbot
   - **Prioritas**: 0-100 (semakin tinggi semakin prioritas)
   - **Status**: Centang untuk aktifkan
3. Klik **"Simpan Balasan"**

### Edit Balasan
1. Klik icon **pensil** di daftar balasan
2. Edit data yang diperlukan
3. Klik **"Update Balasan"**

### Nonaktifkan Balasan
1. Klik badge **"Aktif"** di kolom Status
2. Balasan akan dinonaktifkan (tidak akan digunakan chatbot)
3. Klik lagi untuk mengaktifkan kembali

### Hapus Balasan
1. Klik icon **tempat sampah** di daftar balasan
2. Konfirmasi penghapusan
3. Balasan akan dihapus permanen

## 📊 Database Schema

```sql
CREATE TABLE `chatbot_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `trigger_name` varchar(255) NOT NULL UNIQUE,
  `title` varchar(255) NOT NULL,
  `keywords` text NOT NULL, -- JSON array
  `response` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chatbot_responses_is_active_index` (`is_active`),
  KEY `chatbot_responses_priority_index` (`priority`)
);
```

## 🔄 Cara Kerja

### Flow Diagram
```
User mengirim pesan
    ↓
ChatbotController menerima
    ↓
Cek database responses (by priority)
    ↓
Match keywords dengan pesan user
    ↓
Jika match → Return response dari database
    ↓
Jika tidak match → Fallback ke hardcoded rules
    ↓
Jika masih tidak match → Coba OpenAI (jika ada)
    ↓
Return response
```

### Prioritas Pengecekan
1. **Database Responses** (by priority DESC)
2. **Hardcoded Rules** (fallback)
3. **OpenAI GPT** (jika tersedia)
4. **Default Response** (jika semua gagal)

## 💡 Tips & Best Practices

### Keywords
- ✅ Gunakan kata kunci yang spesifik
- ✅ Tambahkan variasi kata (contoh: `halo, hai, hello, hi`)
- ✅ Gunakan huruf kecil semua
- ✅ Pisahkan dengan koma

### Balasan
- ✅ Gunakan bahasa yang ramah dan sopan
- ✅ Tambahkan emoji untuk lebih friendly
- ✅ Berikan informasi lengkap tapi ringkas
- ✅ Gunakan format yang rapi dengan line breaks
- ✅ Test balasan setelah menyimpan

### Prioritas
- **90-100**: Topik sangat penting (PPDB, Jurusan)
- **80-89**: Topik penting (Profil, Kontak)
- **70-79**: Topik umum (Terima kasih, Selamat tinggal)
- **0-69**: Topik lainnya

### Status
- **Aktif**: Balasan akan digunakan chatbot
- **Nonaktif**: Balasan tidak akan digunakan (untuk testing atau temporary disable)

## 🎯 Contoh Balasan

### Greeting
```
Trigger Name: greeting
Title: Salam & Perkenalan
Keywords: halo, hai, hello, hi, assalamualaikum
Priority: 100
Response:
Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. 
Saya asisten virtual yang siap membantu Anda. 
Ada yang bisa saya bantu?
```

### Jurusan
```
Trigger Name: jurusan
Title: Program Keahlian
Keywords: jurusan, program keahlian, kompetensi, tkj, akuntansi, dkv
Priority: 95
Response:
📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**

1. **Teknik Komputer & Jaringan (TKJ)** 💻
   - Belajar networking, programming, dan sistem komputer
   - Prospek: Network Administrator, IT Support, Web Developer

2. **Akuntansi** 💰
   - Belajar pembukuan, perpajakan, dan keuangan
   - Prospek: Akuntan, Staff Keuangan, Auditor

3. **Desain Komunikasi Visual (DKV)** 🎨
   - Belajar desain grafis, multimedia, dan animasi
   - Prospek: Graphic Designer, Video Editor, UI/UX Designer

Mau tahu lebih detail tentang jurusan tertentu? Tanya saja! 😊
```

## 🔧 Troubleshooting

### Balasan tidak muncul di chatbot
**Solusi:**
1. Pastikan status balasan **Aktif**
2. Check keywords sudah benar
3. Test dengan keyword yang exact
4. Clear cache: `php artisan cache:clear`

### Keywords tidak match
**Solusi:**
1. Pastikan keywords lowercase
2. Cek tidak ada typo
3. Tambahkan variasi kata
4. Test di chatbot

### Prioritas tidak bekerja
**Solusi:**
1. Pastikan prioritas sudah diset
2. Balasan dengan prioritas lebih tinggi dicek duluan
3. Jika ada 2 balasan match, yang prioritas tinggi yang dipakai

## 📈 Monitoring

### Lihat Penggunaan Balasan
Untuk melihat balasan mana yang paling sering digunakan:

```sql
SELECT 
    cr.title,
    cr.trigger_name,
    COUNT(c.id) as usage_count
FROM chatbot_responses cr
LEFT JOIN chats c ON LOWER(c.bot_reply) LIKE CONCAT('%', LOWER(cr.response), '%')
WHERE cr.is_active = 1
GROUP BY cr.id
ORDER BY usage_count DESC;
```

## 🚀 Future Enhancements

### Planned Features
- [ ] Analytics per balasan
- [ ] A/B testing untuk balasan
- [ ] Import/Export balasan
- [ ] Duplicate balasan
- [ ] Bulk edit
- [ ] Search & filter di list
- [ ] Preview balasan
- [ ] Version history
- [ ] Multi-language support

## 📝 Migration & Seeding

### Run Migration
```bash
php artisan migrate
```

### Seed Default Data
```bash
php artisan db:seed --class=ChatbotResponseSeeder
```

### Reset & Reseed
```bash
php artisan migrate:fresh --seed
```

## 🎓 Training Admin

### Checklist untuk Admin Baru
- [ ] Login ke admin panel
- [ ] Buka menu "Balasan Chatbot"
- [ ] Lihat daftar balasan yang ada
- [ ] Coba edit satu balasan
- [ ] Test di chatbot
- [ ] Coba tambah balasan baru
- [ ] Test lagi di chatbot
- [ ] Coba nonaktifkan balasan
- [ ] Coba aktifkan kembali

## 📞 Support

Jika ada pertanyaan atau issue:
- 📖 Baca dokumentasi lengkap
- 💬 Test di chatbot
- 📧 Email: support@smkbinamandiri.sch.id

---

**Sistem Manajemen Balasan Chatbot - Ready to Use! 🎛️✨**

*Last Updated: 15 Oktober 2025*
