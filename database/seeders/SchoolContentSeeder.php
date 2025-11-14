<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SchoolContentSeeder extends Seeder
{
    public function run(): void
    {
        // School Overview
        Setting::updateOrCreate(
            ['key' => 'school_overview'],
            [
                'value' => "Sekolah kami didirikan dengan visi untuk menjadi lembaga pendidikan yang unggul dan berkarakter. Sejak berdiri, kami telah berkomitmen untuk memberikan pendidikan berkualitas yang tidak hanya fokus pada akademik, tetapi juga pengembangan karakter dan keterampilan siswa.\n\nDengan tenaga pengajar yang profesional dan berpengalaman, serta fasilitas yang modern dan lengkap, kami berusaha menciptakan lingkungan belajar yang kondusif dan menyenangkan. Kami percaya bahwa setiap siswa memiliki potensi yang unik dan kami berkomitmen untuk membantu mereka mengembangkan potensi tersebut secara maksimal.\n\nSekolah kami juga aktif dalam berbagai kegiatan ekstrakurikuler dan kompetisi, baik di tingkat lokal maupun nasional. Prestasi-prestasi yang telah diraih oleh siswa kami menjadi bukti nyata dari kualitas pendidikan yang kami berikan.\n\nKami mengundang Anda untuk bergabung dan menjadi bagian dari keluarga besar kami, bersama-sama mewujudkan masa depan yang lebih cerah melalui pendidikan berkualitas.",
                'type' => 'text',
            ]
        );

        // Principal Info
        Setting::updateOrCreate(
            ['key' => 'principal_name'],
            [
                'value' => 'Drs. Ahmad Suryanto, M.Pd',
                'type' => 'text',
            ]
        );

        Setting::updateOrCreate(
            ['key' => 'principal_message'],
            [
                'value' => "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nPuji syukur kita panjatkan kehadirat Allah SWT atas segala rahmat dan karunia-Nya. Shalawat serta salam semoga senantiasa tercurah kepada Nabi Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.\n\nSebagai Kepala Sekolah, saya merasa bangga dan bersyukur dapat memimpin lembaga pendidikan yang terus berkembang dan berinovasi ini. Kami berkomitmen untuk memberikan pendidikan terbaik bagi putra-putri Anda, tidak hanya dalam hal akademik, tetapi juga dalam pembentukan karakter dan keterampilan yang dibutuhkan di era modern ini.\n\nKami percaya bahwa pendidikan adalah investasi terbaik untuk masa depan. Oleh karena itu, kami terus berupaya meningkatkan kualitas pembelajaran, mengembangkan fasilitas, dan memberdayakan tenaga pendidik kami agar dapat memberikan yang terbaik bagi siswa-siswi kami.\n\nKepada para orang tua dan wali murid, saya mengajak untuk bersama-sama mendukung proses pendidikan putra-putri kita. Komunikasi dan kerjasama yang baik antara sekolah dan keluarga akan sangat membantu dalam mengoptimalkan potensi anak-anak kita.\n\nMari kita bersama-sama mewujudkan generasi yang cerdas, berkarakter, dan siap menghadapi tantangan masa depan.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.",
                'type' => 'text',
            ]
        );
    }
}
