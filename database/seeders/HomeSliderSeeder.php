<?php

namespace Database\Seeders;

use App\Models\HomeSlider;
use Illuminate\Database\Seeder;

class HomeSliderSeeder extends Seeder
{
    public function run()
    {
        // Clear existing sliders
        HomeSlider::truncate();

        // Sample sliders
        $sliders = [
            [
                'image_path' => 'sliders/sample1.jpg', // You need to add actual images
                'title' => 'Selamat Datang di SMK Bina Mandiri Kota Bekasi',
                'subtitle' => 'Membangun generasi unggul dengan pendidikan berkualitas dan fasilitas modern',
                'button_text' => 'Daftar Sekarang',
                'button_link' => '/ppdb/register',
                'order' => 1,
                'status' => 'active',
            ],
            [
                'image_path' => 'sliders/sample2.jpg',
                'title' => 'Program Keahlian Unggulan',
                'subtitle' => 'Pilih program keahlian sesuai minat dan bakat Anda untuk masa depan yang cerah',
                'button_text' => 'Lihat Program',
                'button_link' => '/competencies',
                'order' => 2,
                'status' => 'active',
            ],
            [
                'image_path' => 'sliders/sample3.jpg',
                'title' => 'Fasilitas Lengkap & Modern',
                'subtitle' => 'Didukung dengan laboratorium, workshop, dan teknologi terkini untuk pembelajaran optimal',
                'button_text' => 'Jelajahi Fasilitas',
                'button_link' => '/gallery',
                'order' => 3,
                'status' => 'active',
            ],
        ];

        foreach ($sliders as $slider) {
            HomeSlider::create($slider);
        }

        $this->command->info('Home sliders seeded successfully!');
        $this->command->warn('Note: Please upload actual images to storage/app/public/sliders/');
    }
}
