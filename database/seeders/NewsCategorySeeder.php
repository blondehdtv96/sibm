<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'School Events', 'description' => 'News about school events and activities'],
            ['name' => 'Achievements', 'description' => 'Student and school achievements'],
            ['name' => 'Announcements', 'description' => 'Important school announcements'],
            ['name' => 'Academic', 'description' => 'Academic-related news and updates'],
            ['name' => 'Sports', 'description' => 'Sports events and competitions'],
        ];

        foreach ($categories as $category) {
            NewsCategory::create($category);
        }
    }
}
