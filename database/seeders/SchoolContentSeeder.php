<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SchoolContentSeeder extends Seeder
{
    public function run()
    {
        // School Overview
        Setting::set('school_overview', 
            "SMK Bina Mandiri Bekasi didirikan pada tahun 2005 dengan visi menjadi lembaga pendidikan kejuruan terkemuka yang menghasilkan lulusan berkualitas, kompeten, dan siap kerja.\n\n" .
            "Sekolah kami memiliki berbagai program keahlian yang disesuaikan dengan kebutuhan industri modern, didukung oleh tenaga pengajar profesional dan fasilitas pembelajaran yang lengkap.\n\n" .
            "Dengan motto \"Cerdas, Terampil, dan Berakhlak Mulia\", kami berkomitmen untuk membentuk generasi muda yang tidak hanya unggul dalam kompetensi teknis, tetapi juga memiliki karakter yang kuat dan nilai-nilai moral yang tinggi.\n\n" .
            "Fasilitas kami meliputi laboratorium komputer, workshop praktik, perpustakaan digital, dan ruang kelas ber-AC yang nyaman. Kami juga menjalin kerjasama dengan berbagai industri untuk program magang dan penempatan kerja lulusan.",
            'text'
        );

        // Principal Information
        Setting::set('principal_name', 'Dr. Ahmad Suryadi, M.Pd');
        
        Setting::set('principal_message',
            "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\n" .
            "Puji syukur kita panjatkan kehadirat Allah SWT yang telah memberikan rahmat dan karunia-Nya kepada kita semua. Shalawat serta salam semoga senantiasa tercurah kepada Nabi Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.\n\n" .
            "Selamat datang di SMK Bina Mandiri Bekasi. Sebagai Kepala Sekolah, saya merasa bangga dan bersyukur dapat memimpin lembaga pendidikan yang terus berkembang dan berinovasi dalam mencetak generasi muda yang berkualitas.\n\n" .
            "Pendidikan kejuruan memiliki peran strategis dalam mempersiapkan tenaga kerja terampil yang siap menghadapi tantangan dunia industri. Oleh karena itu, kami berkomitmen untuk memberikan pendidikan terbaik yang tidak hanya fokus pada pengembangan kompetensi teknis, tetapi juga pembentukan karakter dan akhlak mulia.\n\n" .
            "Kepada para siswa, saya mengajak kalian untuk memanfaatkan setiap kesempatan belajar dengan sebaik-baiknya. Jadilah pribadi yang disiplin, bertanggung jawab, dan selalu bersemangat dalam menuntut ilmu. Kepada para orang tua, terima kasih atas kepercayaan yang telah diberikan. Mari kita bersinergi dalam mendidik putra-putri kita menjadi generasi yang unggul.\n\n" .
            "Semoga SMK Bina Mandiri Bekasi terus menjadi pilihan terbaik dalam pendidikan kejuruan dan menghasilkan lulusan yang bermanfaat bagi bangsa dan negara.\n\n" .
            "Wassalamu'alaikum Warahmatullahi Wabarakatuh.",
            'text'
        );

        $this->command->info('School content seeded successfully!');
    }
}
