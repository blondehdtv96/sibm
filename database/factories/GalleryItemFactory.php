<?php

namespace Database\Factories;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    protected $model = GalleryItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_id' => GalleryAlbum::factory(),
            'title' => fake()->sentence(3),
            'image_path' => 'gallery/sample-' . fake()->numberBetween(1, 10) . '.jpg',
            'type' => 'image',
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the item is a video.
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'video',
            'image_path' => 'gallery/sample-video-' . fake()->numberBetween(1, 5) . '.mp4',
        ]);
    }
}
