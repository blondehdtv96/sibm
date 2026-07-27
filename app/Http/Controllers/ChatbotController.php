<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatbotResponse;
use App\Services\SchoolAssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Controller untuk menangani chatbot.
 *
 * AI (via SchoolAssistantService) adalah otak utama chatbot dan menjawab
 * setiap pertanyaan seputar sekolah menggunakan data resmi sebagai konteks.
 * Balasan admin di database (ChatbotResponse) dan rule-based keyword tetap
 * dipakai sebagai jaring pengaman ketika AI belum dikonfigurasi atau gagal.
 */
class ChatbotController extends Controller
{
    public function __construct(private SchoolAssistantService $assistant)
    {
    }

    /**
     * Proses pesan dari user dan kirim balasan
     */
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string|max:64',
        ]);

        $userMessage = trim($request->input('message'));
        $sessionId = (string) ($request->input('session_id') ?? Str::uuid());

        $botReply = $this->processMessage($userMessage, $sessionId);

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
     * Proses pesan: AI (dibekali data resmi sekolah) sebagai otak utama,
     * dengan fallback ke balasan admin/rule-based jika AI tidak tersedia.
     */
    private function processMessage(string $message, string $sessionId): string
    {
        if ($this->assistant->isConfigured()) {
            try {
                return $this->assistant->reply($message, $this->buildHistory($sessionId));
            } catch (\Throwable $e) {
                Log::warning('Chatbot AI gagal, fallback ke rule-based: ' . $e->getMessage());
            }
        }

        return $this->fallbackReply(strtolower($message));
    }

    /**
     * Ambil beberapa pesan terakhir pada sesi ini sebagai konteks percakapan untuk AI.
     *
     * @return array<int, array{role: string, content: string}>
     */
    private function buildHistory(string $sessionId): array
    {
        $recentChats = Chat::bySession($sessionId)
            ->latest('id')
            ->limit(4)
            ->get()
            ->reverse();

        $history = [];
        foreach ($recentChats as $chat) {
            $history[] = ['role' => 'user', 'content' => $chat->user_message];
            $history[] = ['role' => 'assistant', 'content' => $chat->bot_reply];
        }

        return $history;
    }

    /**
     * Balasan cadangan berbasis rule/database ketika AI tidak dikonfigurasi atau gagal.
     */
    private function fallbackReply(string $message): string
    {
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
        if ($this->containsKeywords($message, ['jurusan', 'program keahlian', 'kompetensi', 'tkj', 'tsm', 'tkr'])) {
            return "📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**\n\n" .
                   "1. **Teknik Komputer & Jaringan (TKJ)** 💻\n" .
                   "   - Belajar networking, programming, dan sistem komputer\n" .
                   "   - Prospek: Network Administrator, IT Support, Web Developer\n\n" .
                   "2. **Teknik Sepeda Motor (TSM)** 🏍️\n" .
                   "   - Belajar perawatan, perbaikan, dan modifikasi sepeda motor\n" .
                   "   - Prospek: Mekanik Motor, Teknisi Bengkel, Wirausaha Otomotif\n\n" .
                   "3. **Teknik Kendaraan Ringan (TKR)** 🚗\n" .
                   "   - Belajar perawatan, perbaikan, dan teknologi kendaraan ringan\n" .
                   "   - Prospek: Mekanik Mobil, Teknisi Otomotif, Service Advisor\n\n" .
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
                   "✅ Bengkel Sepeda Motor (TSM)\n" .
                   "✅ Bengkel Kendaraan Ringan (TKR)\n" .
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
                   "🥈 Juara 2 Lomba Skill Otomotif Nasional\n" .
                   "🥉 Juara 3 Kompetisi Mekanik Motor\n" .
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

        // Default response jika tidak ada rule yang cocok
        return "Maaf, saya belum punya informasi tentang itu. 😅\n\n" .
               "Saya bisa membantu Anda dengan informasi tentang:\n" .
               "📚 Profil sekolah\n" .
               "🎓 Jurusan (TKJ, TSM, TKR)\n" .
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
            // Keywords sudah dalam bentuk array karena cast di model
            $keywords = is_array($response->keywords) ? $response->keywords : [$response->keywords];
            
            if ($this->containsKeywords($message, $keywords)) {
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
        // Pastikan keywords adalah array
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        foreach ($keywords as $keyword) {
            // Cek apakah keyword ada dalam message (case insensitive)
            if (stripos($message, trim($keyword)) !== false) {
                return true;
            }
        }
        return false;
    }
}
