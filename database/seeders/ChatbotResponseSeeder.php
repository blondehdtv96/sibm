<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotResponse;

class ChatbotResponseSeeder extends Seeder
{
    public function run(): void
    {
        $responses = [
            // Greeting
            [
                'trigger_name' => 'greeting',
                'title' => 'Salam & Sapaan',
                'keywords' => ['halo', 'hai', 'hello', 'hi', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'],
                'response' => 'Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi. Ada yang bisa saya bantu?',
                'is_active' => true,
                'priority' => 10,
            ],
            
            // About School
            [
                'trigger_name' => 'about_school',
                'title' => 'Tentang Sekolah',
                'keywords' => ['profil', 'tentang', 'sekolah', 'informasi sekolah', 'apa itu', 'smk bina mandiri'],
                'response' => 'SMK Bina Mandiri Bekasi adalah lembaga pendidikan yang berkomitmen memberikan pendidikan berkualitas. Anda bisa melihat profil lengkap kami di menu Tentang Kami.',
                'is_active' => true,
                'priority' => 9,
            ],
            
            // PPDB
            [
                'trigger_name' => 'ppdb',
                'title' => 'PPDB & Pendaftaran',
                'keywords' => ['ppdb', 'pendaftaran', 'daftar', 'cara daftar', 'syarat', 'biaya', 'daftar ulang'],
                'response' => 'Untuk informasi PPDB (Penerimaan Peserta Didik Baru), silakan kunjungi halaman PPDB kami atau hubungi kontak yang tersedia. Kami siap membantu proses pendaftaran Anda! 📝',
                'is_active' => true,
                'priority' => 8,
            ],
            
            // Programs
            [
                'trigger_name' => 'programs',
                'title' => 'Program Keahlian',
                'keywords' => ['jurusan', 'program', 'keahlian', 'kompetensi', 'tkj', 'tsm', 'tkr', 'otomotif', 'motor', 'mobil'],
                'response' => 'Kami memiliki berbagai program keahlian yang bisa Anda pilih. Silakan kunjungi halaman Program Keahlian untuk informasi lengkap tentang setiap jurusan. 🎓',
                'is_active' => true,
                'priority' => 7,
            ],
            
            // Contact
            [
                'trigger_name' => 'contact',
                'title' => 'Kontak & Lokasi',
                'keywords' => ['kontak', 'hubungi', 'telepon', 'email', 'alamat', 'lokasi', 'dimana'],
                'response' => 'Anda bisa menghubungi kami melalui halaman Kontak. Di sana tersedia informasi lengkap alamat, nomor telepon, email, dan media sosial kami. 📞',
                'is_active' => true,
                'priority' => 6,
            ],
            
            // Facilities
            [
                'trigger_name' => 'facilities',
                'title' => 'Fasilitas',
                'keywords' => ['fasilitas', 'lab', 'perpustakaan', 'ruang', 'gedung', 'laboratorium'],
                'response' => 'Sekolah kami dilengkapi dengan berbagai fasilitas modern untuk mendukung proses pembelajaran. Anda bisa melihat galeri foto fasilitas kami di menu Galeri. 🏫',
                'is_active' => true,
                'priority' => 5,
            ],
            
            // News
            [
                'trigger_name' => 'news',
                'title' => 'Berita & Kegiatan',
                'keywords' => ['berita', 'informasi', 'pengumuman', 'acara', 'kegiatan', 'event'],
                'response' => 'Untuk informasi terbaru tentang kegiatan dan pengumuman sekolah, silakan kunjungi halaman Berita kami yang selalu diperbarui. 📰',
                'is_active' => true,
                'priority' => 4,
            ],
            
            // Thanks
            [
                'trigger_name' => 'thanks',
                'title' => 'Ucapan Terima Kasih',
                'keywords' => ['terima kasih', 'thanks', 'makasih', 'thx', 'thank you'],
                'response' => 'Sama-sama! 😊 Senang bisa membantu. Jika ada pertanyaan lain, jangan ragu untuk bertanya.',
                'is_active' => true,
                'priority' => 3,
            ],
            
            // Goodbye
            [
                'trigger_name' => 'goodbye',
                'title' => 'Perpisahan',
                'keywords' => ['bye', 'dadah', 'sampai jumpa', 'selamat tinggal'],
                'response' => 'Sampai jumpa! Semoga harimu menyenangkan. 👋',
                'is_active' => true,
                'priority' => 2,
            ],
            
            // Default
            [
                'trigger_name' => 'default',
                'title' => 'Balasan Default',
                'keywords' => ['default'],
                'response' => 'Maaf, saya belum memahami pertanyaan Anda. 😅 Silakan coba pertanyaan lain atau hubungi kontak kami untuk bantuan lebih lanjut.',
                'is_active' => true,
                'priority' => 1,
            ],
        ];

        foreach ($responses as $response) {
            ChatbotResponse::create($response);
        }
    }
}
