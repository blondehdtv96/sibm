<?php

namespace Database\Seeders;

use App\Models\ChatbotResponse;
use Illuminate\Database\Seeder;

class ChatbotResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed data default untuk chatbot responses
     */
    public function run(): void
    {
        $responses = [
            [
                'trigger_name' => 'greeting',
                'title' => 'Salam & Perkenalan',
                'keywords' => ['halo', 'hai', 'hello', 'hi', 'assalamualaikum'],
                'response' => "Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Saya asisten virtual yang siap membantu Anda. Ada yang bisa saya bantu?",
                'is_active' => true,
                'priority' => 100,
            ],
            [
                'trigger_name' => 'profile',
                'title' => 'Profil Sekolah',
                'keywords' => ['profil', 'tentang sekolah', 'tentang smk', 'sekolah'],
                'response' => "🏫 **SMK Bina Mandiri Bekasi** adalah sekolah menengah kejuruan yang berfokus pada pengembangan keterampilan praktis dan profesional.\n\n📍 **Alamat:** Jl. Pendidikan No. 123, Bekasi Timur, Kota Bekasi\n📞 **Telepon:** (021) 1234-5678\n📧 **Email:** info@smkbinamandiri.sch.id\n\nKami berkomitmen mencetak lulusan yang siap kerja dan berdaya saing tinggi! 💪",
                'is_active' => true,
                'priority' => 90,
            ],
            [
                'trigger_name' => 'visi_misi',
                'title' => 'Visi & Misi',
                'keywords' => ['visi', 'misi', 'visi misi'],
                'response' => "🎯 **Visi:**\nMenjadi SMK unggulan yang menghasilkan lulusan berkualitas, profesional, dan berakhlak mulia.\n\n📋 **Misi:**\n1. Menyelenggarakan pendidikan berkualitas berbasis kompetensi\n2. Mengembangkan kerjasama dengan dunia industri\n3. Membentuk karakter siswa yang berakhlak mulia\n4. Menyediakan fasilitas pembelajaran modern",
                'is_active' => true,
                'priority' => 85,
            ],
            [
                'trigger_name' => 'jurusan',
                'title' => 'Program Keahlian/Jurusan',
                'keywords' => ['jurusan', 'program keahlian', 'kompetensi', 'tkj', 'akuntansi', 'dkv'],
                'response' => "📚 **Program Keahlian di SMK Bina Mandiri Bekasi:**\n\n1. **Teknik Komputer & Jaringan (TKJ)** 💻\n   - Belajar networking, programming, dan sistem komputer\n   - Prospek: Network Administrator, IT Support, Web Developer\n\n2. **Akuntansi** 💰\n   - Belajar pembukuan, perpajakan, dan keuangan\n   - Prospek: Akuntan, Staff Keuangan, Auditor\n\n3. **Desain Komunikasi Visual (DKV)** 🎨\n   - Belajar desain grafis, multimedia, dan animasi\n   - Prospek: Graphic Designer, Video Editor, UI/UX Designer\n\nMau tahu lebih detail tentang jurusan tertentu? Tanya saja! 😊",
                'is_active' => true,
                'priority' => 95,
            ],
            [
                'trigger_name' => 'ppdb',
                'title' => 'PPDB (Pendaftaran)',
                'keywords' => ['ppdb', 'pendaftaran', 'daftar', 'cara daftar', 'syarat'],
                'response' => "📝 **Informasi PPDB SMK Bina Mandiri Bekasi:**\n\n📅 **Jadwal Pendaftaran:**\nGelombang 1: Januari - Maret 2026\nGelombang 2: April - Juni 2026\n\n📋 **Syarat Pendaftaran:**\n✅ Ijazah/SKHUN SMP/MTs\n✅ Kartu Keluarga\n✅ Akta Kelahiran\n✅ Pas Foto 3x4 (3 lembar)\n✅ Fotocopy Rapor Semester 1-5\n\n💻 **Cara Daftar:**\nKunjungi website kami dan klik menu 'PPDB' atau datang langsung ke sekolah!\n\n💰 **Biaya:** Gratis biaya pendaftaran! 🎉",
                'is_active' => true,
                'priority' => 95,
            ],
            [
                'trigger_name' => 'fasilitas',
                'title' => 'Fasilitas Sekolah',
                'keywords' => ['fasilitas', 'sarana', 'prasarana', 'lab', 'perpustakaan'],
                'response' => "🏢 **Fasilitas SMK Bina Mandiri Bekasi:**\n\n✅ Ruang kelas ber-AC\n✅ Laboratorium Komputer\n✅ Laboratorium Akuntansi\n✅ Studio Desain & Multimedia\n✅ Perpustakaan Digital\n✅ Masjid\n✅ Kantin\n✅ Lapangan Olahraga\n✅ Free WiFi\n✅ Parkir Luas\n\nSemua fasilitas dirancang untuk mendukung pembelajaran optimal! 🎓",
                'is_active' => true,
                'priority' => 80,
            ],
            [
                'trigger_name' => 'contact',
                'title' => 'Alamat & Kontak',
                'keywords' => ['alamat', 'lokasi', 'dimana', 'kontak', 'telepon', 'email'],
                'response' => "📍 **Alamat & Kontak SMK Bina Mandiri Bekasi:**\n\n🏫 Jl. Pendidikan No. 123, Bekasi Timur\n   Kota Bekasi, Jawa Barat 17113\n\n📞 Telepon: (021) 1234-5678\n📱 WhatsApp: 0812-3456-7890\n📧 Email: info@smkbinamandiri.sch.id\n🌐 Website: www.smkbinamandiri.sch.id\n\n📍 Google Maps: [Klik di sini untuk petunjuk arah]\n\nKami buka Senin-Jumat: 07.00-16.00 WIB 🕐",
                'is_active' => true,
                'priority' => 85,
            ],
            [
                'trigger_name' => 'thanks',
                'title' => 'Terima Kasih',
                'keywords' => ['terima kasih', 'thanks', 'makasih', 'thank you'],
                'response' => "Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain tentang SMK Bina Mandiri Bekasi, jangan ragu untuk bertanya ya! 🏫✨",
                'is_active' => true,
                'priority' => 70,
            ],
            [
                'trigger_name' => 'goodbye',
                'title' => 'Selamat Tinggal',
                'keywords' => ['bye', 'dadah', 'sampai jumpa', 'selamat tinggal'],
                'response' => "Sampai jumpa! 👋 Semoga informasi yang saya berikan bermanfaat. Jangan lupa kunjungi website kami untuk info lebih lengkap. Selamat beraktivitas! 😊🏫",
                'is_active' => true,
                'priority' => 70,
            ],
        ];

        foreach ($responses as $response) {
            ChatbotResponse::create($response);
        }
    }
}
