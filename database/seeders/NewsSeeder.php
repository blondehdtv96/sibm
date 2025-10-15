<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = NewsCategory::all();

        // Create specific news items
        News::create([
            'title' => 'Welcome to New Academic Year 2024/2025',
            'slug' => 'welcome-to-new-academic-year-2024-2025',
            'content' => '<p>We are excited to welcome all students to the new academic year 2024/2025. This year promises to be filled with exciting learning opportunities and activities.</p><p>Classes will begin on July 15, 2024. Please ensure all registration requirements are completed before the start date.</p>',
            'excerpt' => 'Welcome to the new academic year 2024/2025. Classes begin July 15, 2024.',
            'category_id' => $categories->where('name', 'Announcements')->first()->id,
            'author_id' => $admin->id,
            'published_at' => now()->subDays(5),
            'status' => 'published',
        ]);

        News::create([
            'title' => 'Students Win National Science Competition',
            'slug' => 'students-win-national-science-competition',
            'content' => '<p>Congratulations to our students who won first place in the National Science Competition held in Jakarta last week.</p><p>The team presented an innovative project on renewable energy and impressed the judges with their research and presentation skills.</p>',
            'excerpt' => 'Our students won first place in the National Science Competition.',
            'category_id' => $categories->where('name', 'Achievements')->first()->id,
            'author_id' => $admin->id,
            'published_at' => now()->subDays(3),
            'status' => 'published',
        ]);

        News::create([
            'title' => 'Annual Sports Day 2024',
            'slug' => 'annual-sports-day-2024',
            'content' => '<p>Mark your calendars! Our Annual Sports Day will be held on August 20, 2024.</p><p>All students are encouraged to participate in various sports activities including track and field, basketball, and soccer.</p><p>Parents are welcome to attend and support their children.</p>',
            'excerpt' => 'Annual Sports Day scheduled for August 20, 2024.',
            'category_id' => $categories->where('name', 'School Events')->first()->id,
            'author_id' => $admin->id,
            'published_at' => now()->subDays(1),
            'status' => 'published',
        ]);

        // Create additional random news items
        News::factory()
            ->count(15)
            ->create([
                'author_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ]);

        // Create some draft news
        News::factory()
            ->draft()
            ->count(5)
            ->create([
                'author_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ]);
    }
}
