<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class ContactSocialSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Contact Information
            ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 123, Jakarta Selatan, DKI Jakarta 12345', 'type' => 'text'],
            ['key' => 'school_phone', 'value' => '(021) 1234-5678', 'type' => 'text'],
            ['key' => 'school_email', 'value' => 'info@sekolah.sch.id', 'type' => 'text'],
            ['key' => 'school_whatsapp', 'value' => '6281234567890', 'type' => 'text'],
            
            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/sekolahkami', 'type' => 'text'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/sekolahkami', 'type' => 'text'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/sekolahkami', 'type' => 'text'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@sekolahkami', 'type' => 'text'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@sekolahkami', 'type' => 'text'],
            
            // WhatsApp Float Button
            ['key' => 'whatsapp_float_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'whatsapp_float_number', 'value' => '6281234567890', 'type' => 'text'],
            ['key' => 'whatsapp_float_message', 'value' => 'Halo, saya ingin bertanya tentang sekolah', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                ]
            );
        }
    }
}
