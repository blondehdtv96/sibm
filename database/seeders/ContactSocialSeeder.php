<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class ContactSocialSeeder extends Seeder
{
    public function run()
    {
        // Contact Information
        Setting::set('contact_address', 'Jl. Raya Bekasi No. 123, Bekasi Timur, Kota Bekasi, Jawa Barat 17113');
        Setting::set('contact_phone', '+62 21 88888888');
        Setting::set('contact_email', 'info@smkbinamandiri-bekasi.sch.id');
        Setting::set('contact_whatsapp', '628123456789');

        // Social Media Links
        Setting::set('social_facebook', 'https://facebook.com/smkbinamandiribekasi');
        Setting::set('social_instagram', 'https://instagram.com/smkbinamandiribekasi');
        Setting::set('social_twitter', 'https://twitter.com/smkbinamandiri');
        Setting::set('social_youtube', 'https://youtube.com/@smkbinamandiribekasi');
        Setting::set('social_tiktok', '');
        Setting::set('social_linkedin', '');

        $this->command->info('Contact and social media settings seeded successfully!');
    }
}
