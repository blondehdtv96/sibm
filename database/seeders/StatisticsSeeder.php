<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class StatisticsSeeder extends Seeder
{
    public function run(): void
    {
        $statistics = [
            ['key' => 'stat1_value', 'value' => '1000+'],
            ['key' => 'stat1_label', 'value' => 'Alumni Sukses'],
            ['key' => 'stat2_value', 'value' => '15+'],
            ['key' => 'stat2_label', 'value' => 'Program Keahlian'],
            ['key' => 'stat3_value', 'value' => '50+'],
            ['key' => 'stat3_label', 'value' => 'Guru Berpengalaman'],
            ['key' => 'stat4_value', 'value' => '95%'],
            ['key' => 'stat4_label', 'value' => 'Tingkat Kelulusan'],
        ];

        foreach ($statistics as $stat) {
            Setting::updateOrCreate(
                ['key' => $stat['key']],
                ['value' => $stat['value']]
            );
        }

        $this->command->info('Statistics seeded successfully!');
    }
}
