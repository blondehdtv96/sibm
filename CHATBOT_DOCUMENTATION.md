# 🤖 Dokumentasi Chatbot SMK Bina Mandiri Bekasi

Sistem chatbot asisten virtual untuk website SMK Bina Mandiri Bekasi yang dapat menjawab pertanyaan umum pengunjung secara otomatis.

## 📋 Daftar Isi
- [Fitur Utama](#fitur-utama)
- [Teknologi](#teknologi)
- [Instalasi](#instalasi)
- [Cara Kerja](#cara-kerja)
- [Rule-Based System](#rule-based-system)
- [Integrasi OpenAI](#integrasi-openai)
- [Admin Panel](#admin-panel)
- [Kustomisasi](#kustomisasi)
- [Troubleshooting](#troubleshooting)

## ✨ Fitur Utama

### 1. **Widget Chat Modern**
- 💬 Tampilan bubble chat seperti iOS 16
- 🎨 Desain modern dengan Tailwind CSS
- 📱 Fully responsive (mobile, tablet, desktop)
- ⚡ Real-time response tanpa reload halaman
- 💾 Menyimpan riwayat chat di localStorage
- 🔔 Notifikasi badge untuk pesan baru

### 2. **Rule-Based System**
Chatbot dapat menjawab pertanyaan tentang:
- 🏫 Profil sekolah
- 🎯 Visi & Misi
- 📚 Program keahlian (TKJ, Akuntansi, DKV)
- 📝 PPDB (Pendaftaran Peserta Didik Baru)
- 🏢 Fasilitas sekolah
- 📍 Alamat & kontak
- ⏰ Jadwal pelajaran
- 👨‍🏫 Guru & staff
- 🎯 Ekstrakurikuler & OSIS
- 💰 Biaya pendidikan
- 🏆 Prestasi sekolah

### 3. **Admin Panel**
- 📊 Dashboard statistik chat
- 📜 Riwayat percakapan lengkap
- 🔍 Filter & search
- 📥 Export ke CSV
- 🗑️ Hapus riwayat chat
- 📈 Analitik penggunaan

### 4. **Integrasi OpenAI (Opsional)**
- 🤖 Fallback ke GPT-3.5 jika rule tidak cocok
- 🧠 Jawaban lebih natural dan kontekstual
- 🔄 Auto-fallback ke rule-based jika API gagal

## 🛠️ Teknologi

### Backend
- **Laravel 10** - PHP Framework
- **MySQL** - Database untuk menyimpan riwayat chat
- **OpenAI API** - Integrasi GPT (opsional)

### Frontend
- **Tailwind CSS** - Styling modern
- **Alpine.js** - JavaScript framework ringan
- **Fetch API** - AJAX requests
- **LocalStorage** - Menyimpan session & messages

## 📦 Instalasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

Migration akan membuat tabel `chats` dengan struktur:
- `id` - Primary key
- `session_id` - ID sesi untuk tracking
- `user_message` - Pesan dari user
- `bot_reply` - Balasan dari bot
- `ip_address` - IP address user
- `user_agent` - Browser user
- `created_at` & `updated_at` - Timestamps

### 2. Konfigurasi OpenAI (Opsional)
Jika ingin menggunakan OpenAI GPT, tambahkan API key di `.env`:
```env
OPENAI_API_KEY=sk-your-api-key-here
```

Jika tidak ada API key, chatbot akan tetap berfungsi dengan rule-based system.

### 3. Clear Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Test Chatbot
1. Buka website di browser
2. Klik tombol chat di pojok kanan bawah
3. Coba tanya: "Halo", "Jurusan apa saja?", "Cara daftar PPDB?"

## 🔧 Cara Kerja

### Flow Diagram
```
User mengirim pesan
    ↓
Frontend (Alpine.js) mengirim ke server via AJAX
    ↓
ChatbotController menerima pesan
    ↓
Proses dengan rule-based system
    ↓
Jika tidak cocok → Coba OpenAI (jika tersedia)
    ↓
Simpan ke database (tabel chats)
    ↓
Return response JSON
    ↓
Frontend menampilkan balasan bot
```

### Request & Response

**Request:**
```json
POST /chatbot
{
    "message": "Jurusan apa saja?",
    "session_id": "session_1234567890_abc123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "📚 Program Keahlian di SMK Bina Mandiri Bekasi:\n\n1. Teknik Komputer & Jaringan (TKJ) 💻\n...",
    "session_id": "session_1234567890_abc123"
}
```

## 📝 Rule-Based System

### Cara Kerja Rules
Chatbot menggunakan keyword matching untuk mendeteksi intent user:

```php
// Contoh rule untuk jurusan
if ($this->containsKeywords($message, ['jurusan', 'program keahlian', 'tkj', 'akuntansi', 'dkv'])) {
    return "📚 Program Keahlian di SMK Bina Mandiri Bekasi:...";
}
```

### Menambah Rule Baru

Edit file `app/Http/Controllers/ChatbotController.php`:

```php
// Rule baru untuk jam operasional
if ($this->containsKeywords($message, ['jam buka', 'buka', 'tutup', 'operasional'])) {
    return "⏰ **Jam Operasional:**\n" .
           "Senin - Jumat: 07.00 - 16.00 WIB\n" .
           "Sabtu: 07.00 - 12.00 WIB\n" .
           "Minggu & Libur: Tutup";
}
```

### Tips Membuat Rule Efektif
1. ✅ Gunakan multiple keywords untuk satu intent
2. ✅ Gunakan emoji untuk membuat jawaban lebih friendly
3. ✅ Format jawaban dengan line breaks (`\n`)
4. ✅ Berikan informasi lengkap tapi ringkas
5. ✅ Tambahkan call-to-action jika perlu

## 🤖 Integrasi OpenAI

### Setup
1. Daftar di [OpenAI Platform](https://platform.openai.com/)
2. Buat API key
3. Tambahkan ke `.env`:
```env
OPENAI_API_KEY=sk-your-api-key-here
```

### Cara Kerja
- Jika rule-based tidak menemukan jawaban, sistem akan fallback ke OpenAI
- Menggunakan model `gpt-3.5-turbo`
- System prompt sudah dikonfigurasi untuk konteks sekolah
- Jika OpenAI gagal, akan kembali ke default response

### Konfigurasi OpenAI
Edit di `app/Http/Controllers/ChatbotController.php`:

```php
private function getOpenAIResponse($message)
{
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo', // Bisa diganti ke gpt-4
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Kamu adalah asisten virtual SMK Bina Mandiri Bekasi...'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ],
        'max_tokens' => 500, // Sesuaikan kebutuhan
        'temperature' => 0.7, // 0-1, semakin tinggi semakin kreatif
    ]);
}
```

## 👨‍💼 Admin Panel

### Akses Admin
URL: `/admin/chat-history`

### Fitur Admin
1. **Dashboard Statistik**
   - Total chat
   - Chat hari ini
   - Chat minggu ini
   - Chat bulan ini

2. **Filter & Search**
   - Search berdasarkan pesan
   - Filter berdasarkan tanggal
   - Filter berdasarkan session

3. **Export Data**
   - Export ke CSV
   - Include semua data chat

4. **Hapus Riwayat**
   - Hapus chat individual
   - Hapus semua riwayat
   - Hapus berdasarkan tanggal

### Screenshot Admin
```
┌─────────────────────────────────────────┐
│  Riwayat Chat Chatbot                   │
│  ┌─────┬─────┬─────┬─────┐             │
│  │Total│Today│Week │Month│             │
│  │ 150 │ 25  │ 80  │ 150 │             │
│  └─────┴─────┴─────┴─────┘             │
│                                         │
│  [Search] [Date] [Filter] [Export]     │
│                                         │
│  ┌───────────────────────────────────┐ │
│  │ 👤 User: Jurusan apa saja?        │ │
│  │ 🤖 Bot: Program Keahlian...       │ │
│  │ 📅 15 Oct 2025, 10:30             │ │
│  └───────────────────────────────────┘ │
└─────────────────────────────────────────┘
```

## 🎨 Kustomisasi

### 1. Mengubah Warna
Edit `resources/views/components/chatbot.blade.php`:

```html
<!-- Ganti gradient warna -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600">
<!-- Menjadi -->
<div class="bg-gradient-to-r from-green-600 to-teal-600">
```

### 2. Mengubah Posisi Widget
```html
<!-- Default: bottom-6 right-6 -->
<div class="fixed bottom-6 right-6 z-50">

<!-- Pindah ke kiri -->
<div class="fixed bottom-6 left-6 z-50">

<!-- Pindah ke atas -->
<div class="fixed top-6 right-6 z-50">
```

### 3. Mengubah Ukuran Chat Window
```html
<!-- Default: w-96 h-[600px] -->
<div class="w-96 h-[600px]">

<!-- Lebih besar -->
<div class="w-[500px] h-[700px]">

<!-- Lebih kecil -->
<div class="w-80 h-[500px]">
```

### 4. Mengubah Welcome Message
Edit `resources/views/components/chatbot.blade.php`:

```html
<p class="text-sm text-gray-800">
    Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. 
    Ada yang bisa saya bantu?
</p>
```

### 5. Menambah Quick Replies
Tambahkan tombol quick reply di bawah input:

```html
<div class="flex gap-2 mt-2">
    <button @click="userInput = 'Jurusan apa saja?'" 
            class="px-3 py-1 bg-gray-100 rounded-lg text-sm">
        Jurusan
    </button>
    <button @click="userInput = 'Cara daftar PPDB?'" 
            class="px-3 py-1 bg-gray-100 rounded-lg text-sm">
        PPDB
    </button>
</div>
```

## 🐛 Troubleshooting

### Chatbot tidak muncul
**Solusi:**
1. Pastikan Alpine.js sudah loaded
2. Check console browser untuk error
3. Pastikan route `/chatbot` sudah terdaftar
4. Clear cache: `php artisan cache:clear`

### Pesan tidak terkirim
**Solusi:**
1. Check CSRF token
2. Check network tab di browser
3. Pastikan route POST `/chatbot` accessible
4. Check error log: `storage/logs/laravel.log`

### OpenAI tidak berfungsi
**Solusi:**
1. Pastikan API key valid
2. Check quota OpenAI account
3. Check internet connection
4. Lihat error di log

### Chat history tidak tersimpan
**Solusi:**
1. Pastikan migration sudah dijalankan
2. Check database connection
3. Check permission tabel `chats`

### Widget tidak responsive di mobile
**Solusi:**
1. Check viewport meta tag
2. Test dengan Chrome DevTools
3. Adjust ukuran di `max-width: calc(100vw - 3rem)`

## 📊 Monitoring & Analytics

### Metrics yang Bisa Ditrack
1. **Total Conversations** - Jumlah percakapan
2. **Daily Active Users** - User aktif per hari
3. **Popular Questions** - Pertanyaan paling sering
4. **Response Time** - Waktu respons bot
5. **User Satisfaction** - Rating dari user (future)

### Query Analytics
```sql
-- Top 10 pertanyaan paling sering
SELECT user_message, COUNT(*) as count 
FROM chats 
GROUP BY user_message 
ORDER BY count DESC 
LIMIT 10;

-- Chat per hari (7 hari terakhir)
SELECT DATE(created_at) as date, COUNT(*) as count 
FROM chats 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY DATE(created_at);

-- Peak hours
SELECT HOUR(created_at) as hour, COUNT(*) as count 
FROM chats 
GROUP BY HOUR(created_at) 
ORDER BY count DESC;
```

## 🚀 Future Enhancements

### Planned Features
- [ ] Multi-language support (EN, ID)
- [ ] Voice input/output
- [ ] File upload support
- [ ] Rating system untuk jawaban
- [ ] Sentiment analysis
- [ ] Auto-suggest questions
- [ ] Integration dengan WhatsApp
- [ ] Chatbot analytics dashboard
- [ ] A/B testing untuk responses
- [ ] Machine learning untuk improve responses

## 📞 Support

Jika ada pertanyaan atau issue:
- 📧 Email: support@smkbinamandiri.sch.id
- 💬 Chat: Gunakan chatbot di website
- 📱 WhatsApp: 0812-3456-7890

## 📄 License

Chatbot ini adalah bagian dari sistem manajemen sekolah SMK Bina Mandiri Bekasi.

---

**Dibuat dengan ❤️ untuk SMK Bina Mandiri Bekasi**

*Last Updated: 15 Oktober 2025*
