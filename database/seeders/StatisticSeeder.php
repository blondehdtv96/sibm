<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default statistics
        Statistic::create([
            'label' => 'Siswa Aktif',
            'value' => 450,
            'suffix' => '+',
            'order' => 1,
            'status' => 'active',
        ]);

        Statistic::create([
            'label' => 'Guru Berpengalaman',
            'value' => 35,
            'suffix' => '',
            'order' => 2,
            'status' => 'active',
        ]);

        Statistic::create([
            'label' => 'Program Tersedia',
            'value' => 12,
            'suffix' => '',
            'order' => 3,
            'status' => 'active',
        ]);

        Statistic::create([
            'label' => 'Tahun Berdiri',
            'value' => 2010,
            'suffix' => '',
            'order' => 4,
            'status' => 'active',
        ]);
    }
}
