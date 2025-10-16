<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatbotResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Controller untuk menangani chatbot
 * Menggunakan rule-based system dengan fallback ke OpenAI GPT (opsional)
 */
class ChatbotController extends Controller
{
    /**
     * Proses pesan dari user dan kirim balasan
     */
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
        ]);

        $userMessage = $request->input('message');
        $sessionId = $request->input('session_id') ?? Str::uuid();

        // Proses pesan dan dapatkan balasan
        $botReply = $this->processMessage($userMessage);

        // Simpan ke database
        Chat::create([
            'session_id' => $sessionId,
            'user_message' => $userMessage,
            'bot_reply' => $botReply,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Return response JSON
        return response()->json([
            'success' => true,
            'message' => $botReply,
            'session_id' => $sessionId,
        ]);
    }

    /**
     * Proses pesan menggunakan rule-based system
     * Pertama cek database, lalu fallback ke hardcoded rules
     */
    private function processMessage($message)
    {
        $message = strtolower($message);

        // Cek database responses terlebih dahulu
        $dbResponse = $this->checkDatabaseResponses($message);
        if ($dbResponse) {
            return $dbResponse;
        }

        // Rule 1: Salam dan perkenalan
        if ($this->containsKeywords($message, ['halo', 'hai', 'hello', 'hi', 'assalamualaikum'])) {
            return "Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Saya asisten virtual yang siap membantu Anda. Ada yang bisa saya bantu?";
        }

        // Rule 2: Profil sekolah
        if ($this->containsKeywords($message, ['profil', 'tentang sekolah', 'tentang smk', 'sekolah'])) {
            return "🏫 **SMK Bina Mandiri Bekasi** adalah sekolah menengah kejuruan yang berfokus pada pengembangan keterampilan praktis dan profesional.\n\n" .
                   "📍 **Alamat:** Jl. Bintara IX No.7 4, RT.001/RW.005, Bintara, Kec. Bekasi Bar., Kota Bks, Jawa Barat 17134\n" .
                   "📞 **Telepon:** (021) 1234-5678\n" .
                   "📧 **Email:** info@smkbinamandiri.sch.id\n\n" .
                   "Kami berkomitmen mencetak lulusan yang siap kerja dan berdaya saing tinggi! 💪";
        }

        // Rule 3: Visi Misi
        if ($this->containsKeywords($message, ['visi', 'misi', 'visi misi'])) {
            return "🎯 **Visi:**\n" .
                   "Mewujudkan kemampuan literasi dan numerasi peserta didik melalui peningkatan kualitas pembelajaran, kompetensi GTK dan praktik pembelajaran interaktif sehingga mampu menghasilkan lulusan yang berkarakter, terserap di dunia kerja, berwirausaha dan melanjutkan pendidikan ke jenjang selanjutnya.\n\n" .
                   "📋 **Misi:**\n" .
                   "1. Meningkatkan kompetensi literasi dan numerasi peserta didik\n" .
                   "2. Meningkatkan kesadaran GTK dalam menjalankan tugas pokok dan fungsinya\n" .
                   "3. Meningkatkan pengelolaan kurikulum sekolah\n" .
                   "4. Membentuk karakter siswa yang berakhlak mulia";
        }

        // Rule 4: Jurusan/Program Keahlian
        if ($this->containsKeywords($message, ['jurusan', 'program keahlian', 'kompetensi', 'tkj', 'akuntansi', 'dkv'])) {
            return "📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**\n\n" .
                   "1. **Teknik Komputer & Jaringan (TKJ)** 💻\n" .
                   "   - Belajar networking, programming, dan sistem komputer\n" .
                   "   - Prospek: Network Administrator, IT Support, Web Developer\n\n" .
                   "2. **Akuntansi** 💰\n" .
                   "   - Belajar pembukuan, perpajakan, dan keuangan\n" .
                   "   - Prospek: Akuntan, Staff Keuangan, Auditor\n\n" .
                   "3. **Desain Komunikasi Visual (DKV)** 🎨\n" .
                   "   - Belajar desain grafis, multimedia, dan animasi\n" .
                   "   - Prospek: Graphic Designer, Video Editor, UI/UX Designer\n\n" .
                   "Mau tahu lebih detail tentang jurusan tertentu? Tanya saja! 😊";
        }

        // Rule 5: PPDB (Pendaftaran Peserta Didik Baru)
        if ($this->containsKeywords($message, ['ppdb', 'pendaftaran', 'daftar', 'cara daftar', 'syarat'])) {
            return "📝 **Informasi PPDB SMK Bina Mandiri Bekasi:**\n\n" .
                   "📅 **Jadwal Pendaftaran:**\n" .
                   "Gelombang 1: Januari - Maret 2026\n" .
                   "Gelombang 2: April - Juni 2026\n\n" .
                   "📋 **Syarat Pendaftaran:**\n" .
                   "✅ Ijazah/SKHUN SMP/MTs\n" .
                   "✅ Kartu Keluarga\n" .
                   "✅ Akta Kelahiran\n" .
                   "✅ Pas Foto 3x4 (3 lembar)\n" .
                   "✅ Fotocopy Rapor Semester 1-5\n\n" .
                   "💻 **Cara Daftar:**\n" .
                   "Kunjungi website kami dan klik menu 'PPDB' atau datang langsung ke sekolah!\n\n" .
                   "💰 **Biaya:** Gratis biaya pendaftaran! 🎉";
        }

        // Rule 6: Fasilitas
        if ($this->containsKeywords($message, ['fasilitas', 'sarana', 'prasarana', 'lab', 'perpustakaan'])) {
            return "🏢 **Fasilitas SMK Bina Mandiri Bekasi:**\n\n" .
                   "✅ Ruang kelas ber-AC\n" .
                   "✅ Laboratorium Komputer\n" .
                   "✅ Laboratorium Akuntansi\n" .
                   "✅ Studio Desain & Multimedia\n" .
                   "✅ Perpustakaan Digital\n" .
                   "✅ Masjid\n" .
                   "✅ Kantin\n" .
                   "✅ Lapangan Olahraga\n" .
                   "✅ Free WiFi\n" .
                   "✅ Parkir Luas\n\n" .
                   "Semua fasilitas dirancang untuk mendukung pembelajaran optimal! 🎓";
        }

        // Rule 7: Alamat & Kontak
        if ($this->containsKeywords($message, ['alamat', 'lokasi', 'dimana', 'kontak', 'telepon', 'email'])) {
            return "📍 **Alamat & Kontak SMK Bina Mandiri Bekasi:**\n\n" .
                   "🏫 Jl. Pendidikan No. 123, Bekasi Timur\n" .
                   "   Kota Bekasi, Jawa Barat 17113\n\n" .
                   "📞 Telepon: (021) 1234-5678\n" .
                   "📱 WhatsApp: 0812-3456-7890\n" .
                   "📧 Email: info@smkbinamandiri.sch.id\n" .
                   "🌐 Website: www.smkbinamandiri.sch.id\n\n" .
                   "📍 Google Maps: [Klik di sini untuk petunjuk arah]\n\n" .
                   "Kami buka Senin-Jumat: 07.00-16.00 WIB 🕐";
        }

        // Rule 8: Jadwal Pelajaran
        if ($this->containsKeywords($message, ['jadwal', 'jam pelajaran', 'jam sekolah', 'masuk'])) {
            return "⏰ **Jadwal Kegiatan Belajar:**\n\n" .
                   "📅 Senin - Jumat:\n" .
                   "   07.00 - 07.15: Upacara/Apel\n" .
                   "   07.15 - 15.30: Kegiatan Belajar Mengajar\n\n" .
                   "📅 Sabtu:\n" .
                   "   07.00 - 12.00: Kegiatan Ekstrakurikuler\n\n" .
                   "🕌 Istirahat:\n" .
                   "   10.00 - 10.15 (Istirahat 1)\n" .
                   "   12.00 - 12.30 (Istirahat 2 & Sholat Dzuhur)\n\n" .
                   "Setiap jam pelajaran berdurasi 45 menit 📚";
        }

        // Rule 9: Guru & Staff
        if ($this->containsKeywords($message, ['guru', 'pengajar', 'staff', 'tenaga pendidik'])) {
            return "👨‍🏫 **Tenaga Pendidik & Kependidikan:**\n\n" .
                   "SMK Bina Mandiri Bekasi memiliki:\n" .
                   "✅ 45 Guru Profesional\n" .
                   "✅ 15 Staff Administrasi\n" .
                   "✅ Guru bersertifikat dan berpengalaman\n" .
                   "✅ Instruktur dari industri\n\n" .
                   "Semua guru kami berkomitmen memberikan pendidikan terbaik untuk siswa! 🎓\n\n" .
                   "Ingin tahu lebih detail? Kunjungi halaman 'Tentang Kami' di website kami!";
        }

        // Rule 10: Ekstrakurikuler & OSIS
        if ($this->containsKeywords($message, ['ekskul', 'ekstrakurikuler', 'osis', 'kegiatan', 'organisasi'])) {
            return "🎯 **Ekstrakurikuler & Organisasi:**\n\n" .
                   "**Ekstrakurikuler:**\n" .
                   "⚽ Futsal\n" .
                   "🏀 Basket\n" .
                   "🎭 Teater\n" .
                   "🎵 Musik/Band\n" .
                   "📸 Fotografi\n" .
                   "💻 Coding Club\n" .
                   "🎨 Seni Rupa\n" .
                   "📰 Jurnalistik\n\n" .
                   "**Organisasi:**\n" .
                   "🏛️ OSIS (Organisasi Siswa Intra Sekolah)\n" .
                   "🕌 Rohis (Rohani Islam)\n" .
                   "🏕️ Pramuka\n" .
                   "❤️ PMR (Palang Merah Remaja)\n\n" .
                   "Semua kegiatan dilaksanakan setiap Sabtu! 🎉";
        }

        // Rule 11: Biaya Sekolah
        if ($this->containsKeywords($message, ['biaya', 'spp', 'uang sekolah', 'bayar', 'pembayaran'])) {
            return "💰 **Informasi Biaya Pendidikan:**\n\n" .
                   "Untuk informasi detail mengenai biaya pendidikan, silakan:\n" .
                   "1. Hubungi bagian administrasi: (021) 1234-5678\n" .
                   "2. Datang langsung ke sekolah\n" .
                   "3. WhatsApp: 0812-3456-7890\n\n" .
                   "📋 Kami menyediakan berbagai program bantuan:\n" .
                   "✅ Beasiswa Prestasi\n" .
                   "✅ Beasiswa Tidak Mampu\n" .
                   "✅ Cicilan Pembayaran\n\n" .
                   "Jangan khawatir, kami siap membantu! 😊";
        }

        // Rule 12: Prestasi
        if ($this->containsKeywords($message, ['prestasi', 'penghargaan', 'juara', 'lomba'])) {
            return "🏆 **Prestasi SMK Bina Mandiri Bekasi:**\n\n" .
                   "Kami bangga dengan prestasi siswa-siswi kami:\n" .
                   "🥇 Juara 1 LKS Tingkat Provinsi (TKJ)\n" .
                   "🥈 Juara 2 Lomba Desain Grafis Nasional\n" .
                   "🥉 Juara 3 Olimpiade Akuntansi\n" .
                   "🏅 Best Practice Award dari Kemendikbud\n" .
                   "⭐ Sekolah Adiwiyata Tingkat Kota\n\n" .
                   "Prestasi adalah bukti kualitas pendidikan kami! 💪\n\n" .
                   "Lihat prestasi lengkap di website kami!";
        }

        // Rule 13: Terima kasih
        if ($this->containsKeywords($message, ['terima kasih', 'thanks', 'makasih', 'thank you'])) {
            return "Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain tentang SMK Bina Mandiri Bekasi, jangan ragu untuk bertanya ya! 🏫✨";
        }

        // Rule 14: Selamat tinggal
        if ($this->containsKeywords($message, ['bye', 'dadah', 'sampai jumpa', 'selamat tinggal'])) {
            return "Sampai jumpa! 👋 Semoga informasi yang saya berikan bermanfaat. Jangan lupa kunjungi website kami untuk info lebih lengkap. Selamat beraktivitas! 😊🏫";
        }

        // Jika tidak ada rule yang cocok, coba OpenAI (jika tersedia)
        if (config('services.openai.api_key')) {
            try {
                return $this->getOpenAIResponse($message);
            } catch (\Exception $e) {
                // Fallback ke pesan default jika OpenAI gagal
            }
        }

        // Default response jika tidak ada rule yang cocok
        return "Maaf, saya belum punya informasi tentang itu. 😅\n\n" .
               "Saya bisa membantu Anda dengan informasi tentang:\n" .
               "📚 Profil sekolah\n" .
               "🎓 Jurusan (TKJ, Akuntansi, DKV)\n" .
               "📝 PPDB (Pendaftaran)\n" .
               "🏢 Fasilitas\n" .
               "📍 Alamat & Kontak\n" .
               "⏰ Jadwal Pelajaran\n" .
               "🎯 Ekstrakurikuler\n\n" .
               "Silakan tanya hal-hal di atas ya! 😊";
    }

    /**
     * Cek balasan dari database
     */
    private function checkDatabaseResponses($message)
    {
        // Ambil semua response yang aktif, diurutkan berdasarkan prioritas
        $responses = ChatbotResponse::active()
            ->byPriority()
            ->get();

        foreach ($responses as $response) {
            if ($this->containsKeywords($message, $response->keywords)) {
                return $response->response;
            }
        }

        return null;
    }

    /**
     * Helper function untuk cek keywords
     */
    private function containsKeywords($message, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (strpos($message, strtolower($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Integrasi dengan OpenAI GPT (opsional)
     * Memerlukan API key di .env: OPENAI_API_KEY=your-key
     */
    private function getOpenAIResponse($message)
    {
        $apiKey = config('services.openai.api_key');
        
        if (!$apiKey) {
            throw new \Exception('OpenAI API key not configured');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Kamu adalah asisten virtual SMK Bina Mandiri Bekasi. Jawab pertanyaan dengan ramah, informatif, dan gunakan emoji. Fokus pada informasi sekolah, jurusan (TKJ, Akuntansi, DKV), PPDB, dan fasilitas.'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'max_tokens' => 500,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        throw new \Exception('OpenAI API request failed');
    }
}
