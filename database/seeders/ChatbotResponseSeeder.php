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
                'keywords' => 'halo,hai,hello,hi,selamat pagi,selamat siang,selamat sore,selamat malam',
                'response' => 'Halo! Selamat datang di website sekolah kami. Ada yang bisa saya bantu?',
                'category' => 'greeting',
                'order' => 1,
                'status' => 'active',
            ],
            
            // About School
            [
                'keywords' => 'profil,tentang,sekolah,informasi sekolah,apa itu',
                'response' => 'Sekolah kami adalah lembaga pendidikan yang berkomitmen memberikan pendidikan berkualitas. Anda bisa melihat profil lengkap kami di menu Tentang Kami.',
                'category' => 'about',
                'order' => 2,
                'status' => 'active',
            ],
            
            // PPDB
            [
                'keywords' => 'ppdb,pendaftaran,daftar,cara daftar,syarat,biaya',
                'response' => 'Untuk informasi PPDB (Penerimaan Peserta Didik Baru), silakan kunjungi halaman PPDB kami atau hubungi kontak yang tersedia. Kami siap membantu proses pendaftaran Anda!',
                'category' => 'ppdb',
                'order' => 3,
                'status' => 'active',
            ],
            
            // Programs
            [
                'keywords' => 'jurusan,program,keahlian,kompetensi,tkj,rpl,multimedia',
                'response' => 'Kami memiliki berbagai program keahlian yang bisa Anda pilih. Silakan kunjungi halaman Program Keahlian untuk informasi lengkap tentang setiap jurusan.',
                'category' => 'programs',
                'order' => 4,
                'status' => 'active',
            ],
            
            // Contact
            [
                'keywords' => 'kontak,hubungi,telepon,email,alamat,lokasi',
                'response' => 'Anda bisa menghubungi kami melalui halaman Kontak. Di sana tersedia informasi lengkap alamat, nomor telepon, email, dan media sosial kami.',
                'category' => 'contact',
                'order' => 5,
                'status' => 'active',
            ],
            
            // Facilities
            [
                'keywords' => 'fasilitas,lab,perpustakaan,ruang,gedung',
                'response' => 'Sekolah kami dilengkapi dengan berbagai fasilitas modern untuk mendukung proses pembelajaran. Anda bisa melihat galeri foto fasilitas kami di menu Galeri.',
                'category' => 'facilities',
                'order' => 6,
                'status' => 'active',
            ],
            
            // News
            [
                'keywords' => 'berita,informasi,pengumuman,acara,kegiatan',
                'response' => 'Untuk informasi terbaru tentang kegiatan dan pengumuman sekolah, silakan kunjungi halaman Berita kami yang selalu diperbarui.',
                'category' => 'news',
                'order' => 7,
                'status' => 'active',
            ],
            
            // Thanks
            [
                'keywords' => 'terima kasih,thanks,makasih,thx',
                'response' => 'Sama-sama! Senang bisa membantu. Jika ada pertanyaan lain, jangan ragu untuk bertanya.',
                'category' => 'thanks',
                'order' => 8,
                'status' => 'active',
            ],
            
            // Default
            [
                'keywords' => 'default',
                'response' => 'Maaf, saya belum memahami pertanyaan Anda. Silakan coba pertanyaan lain atau hubungi kontak kami untuk bantuan lebih lanjut.',
                'category' => 'default',
                'order' => 999,
                'status' => 'active',
            ],
        ];

        foreach ($responses as $response) {
            ChatbotResponse::create($response);
        }
    }
}
