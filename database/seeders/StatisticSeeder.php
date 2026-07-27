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
        Statistic::whereIn('label', ['Program Tersedia', 'Tahun Berdiri'])
            ->update(['status' => 'inactive']);

        $statistics = [
            ['label' => 'Siswa Aktif', 'value' => 1400, 'suffix' => '+', 'order' => 1],
            ['label' => 'Guru Berpengalaman', 'value' => 65, 'suffix' => '', 'order' => 2],
            ['label' => 'Program Keahlian', 'value' => 3, 'suffix' => '', 'order' => 3],
            ['label' => 'Berdiri Sejak', 'value' => 2000, 'suffix' => '', 'order' => 4],
        ];

        foreach ($statistics as $statistic) {
            Statistic::updateOrCreate(
                ['label' => $statistic['label']],
                $statistic + ['status' => 'active']
            );
        }
    }
}
