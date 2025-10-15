<?php

namespace Database\Seeders;

use App\Models\PpdbSetting;
use Illuminate\Database\Seeder;

class PpdbSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create active PPDB setting for current year
        PpdbSetting::create([
            'registration_start' => now()->subWeek()->format('Y-m-d'),
            'registration_end' => now()->addMonths(2)->format('Y-m-d'),
            'requirements' => json_encode([
                'Birth Certificate (Akta Kelahiran)',
                'Family Card (Kartu Keluarga)',
                'Student Photo 3x4 (2 sheets)',
                'Report Card from Previous School',
                'Health Certificate',
                'Certificate of Good Conduct',
            ]),
            'status' => 'active',
        ]);
    }
}
