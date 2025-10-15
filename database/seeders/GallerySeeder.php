<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific albums
        $schoolFacilities = GalleryAlbum::create([
            'name' => 'School Facilities',
            'slug' => 'school-facilities',
            'description' => 'Photos of our modern school facilities and learning environment',
            'sort_order' => 1,
        ]);

        $sportsDay = GalleryAlbum::create([
            'name' => 'Sports Day 2023',
            'slug' => 'sports-day-2023',
            'description' => 'Highlights from our annual sports day event',
            'sort_order' => 2,
        ]);

        $graduation = GalleryAlbum::create([
            'name' => 'Graduation Ceremony 2023',
            'slug' => 'graduation-ceremony-2023',
            'description' => 'Celebrating our graduating class of 2023',
            'sort_order' => 3,
        ]);

        $scienceFair = GalleryAlbum::create([
            'name' => 'Science Fair 2024',
            'slug' => 'science-fair-2024',
            'description' => 'Student projects and innovations at the science fair',
            'sort_order' => 4,
        ]);

        // Create gallery items for each album
        GalleryItem::factory()->count(8)->create(['album_id' => $schoolFacilities->id]);
        GalleryItem::factory()->count(12)->create(['album_id' => $sportsDay->id]);
        GalleryItem::factory()->count(10)->create(['album_id' => $graduation->id]);
        GalleryItem::factory()->count(6)->create(['album_id' => $scienceFair->id]);

        // Create additional random albums with items
        GalleryAlbum::factory()
            ->count(3)
            ->create()
            ->each(function ($album) {
                GalleryItem::factory()->count(rand(5, 10))->create([
                    'album_id' => $album->id,
                ]);
            });
    }
}
