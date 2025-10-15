<?php

namespace Database\Seeders;

use App\Models\Competency;
use Illuminate\Database\Seeder;

class CompetencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competencies = [
            [
                'name' => 'Science and Technology',
                'slug' => 'science-and-technology',
                'description' => '<p>Our Science and Technology program prepares students for careers in STEM fields.</p><p>Students will learn:</p><ul><li>Advanced mathematics and physics</li><li>Computer programming and robotics</li><li>Laboratory research methods</li><li>Scientific problem-solving</li></ul>',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Social Sciences',
                'slug' => 'social-sciences',
                'description' => '<p>The Social Sciences program develops critical thinking about society, culture, and human behavior.</p><p>Key areas include:</p><ul><li>History and geography</li><li>Economics and business</li><li>Sociology and psychology</li><li>Political science</li></ul>',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Languages and Literature',
                'slug' => 'languages-and-literature',
                'description' => '<p>Master multiple languages and develop strong communication skills.</p><p>Program highlights:</p><ul><li>Indonesian and English language mastery</li><li>Foreign language options (Mandarin, Japanese, Arabic)</li><li>Literature analysis and creative writing</li><li>Public speaking and debate</li></ul>',
                'sort_order' => 3,
                'status' => 'active',
            ],
            [
                'name' => 'Arts and Design',
                'slug' => 'arts-and-design',
                'description' => '<p>Explore creativity through various artistic mediums and design principles.</p><p>Students will engage in:</p><ul><li>Visual arts (painting, drawing, sculpture)</li><li>Digital design and multimedia</li><li>Music and performing arts</li><li>Traditional and contemporary art forms</li></ul>',
                'sort_order' => 4,
                'status' => 'active',
            ],
        ];

        foreach ($competencies as $competency) {
            Competency::create($competency);
        }

        // Create additional sample competencies
        Competency::factory()->count(3)->create();
    }
}
