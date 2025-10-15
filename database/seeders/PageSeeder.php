<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create About page
        Page::create([
            'slug' => 'about',
            'title' => 'About Our School',
            'content' => '<p>Welcome to our school! We are committed to providing quality education and nurturing young minds.</p><p>Our school has been serving the community for over 20 years, with a focus on academic excellence and character development.</p><p>We offer a comprehensive curriculum that prepares students for success in their future endeavors.</p>',
            'meta_description' => 'Learn about our school, our mission, and our commitment to education.',
            'status' => 'published',
        ]);

        // Create Vision & Mission page
        Page::create([
            'slug' => 'vision-mission',
            'title' => 'Vision & Mission',
            'content' => '<h2>Our Vision</h2><p>To be a leading educational institution that empowers students to become lifelong learners and responsible global citizens.</p><h2>Our Mission</h2><ul><li>Provide quality education that meets international standards</li><li>Foster critical thinking and creativity</li><li>Develop character and moral values</li><li>Prepare students for the challenges of the 21st century</li></ul>',
            'meta_description' => 'Our vision and mission for educational excellence.',
            'status' => 'published',
        ]);

        // Create Facilities page
        Page::create([
            'slug' => 'facilities',
            'title' => 'School Facilities',
            'content' => '<p>Our school is equipped with modern facilities to support student learning and development.</p><ul><li>Modern classrooms with multimedia equipment</li><li>Science and computer laboratories</li><li>Library with extensive collection</li><li>Sports facilities including basketball court and soccer field</li><li>Auditorium for events and performances</li><li>Cafeteria serving healthy meals</li></ul>',
            'meta_description' => 'Explore our modern school facilities and learning environment.',
            'status' => 'published',
        ]);

        // Create additional sample pages
        Page::factory()->published()->count(3)->create();
        Page::factory()->draft()->count(2)->create();
    }
}
