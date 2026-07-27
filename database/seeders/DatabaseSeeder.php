<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PageSeeder::class,
            NewsCategorySeeder::class,
            NewsSeeder::class,
            CompetencySeeder::class,
            GallerySeeder::class,
            PpdbSettingSeeder::class,
            PpdbRegistrationSeeder::class,
            ChatbotResponseSeeder::class,
            SchoolContentSeeder::class,
            ContactSocialSeeder::class,
            MenuSeeder::class,
            HomeSliderSeeder::class,
            StatisticSeeder::class,
        ]);
    }
}
