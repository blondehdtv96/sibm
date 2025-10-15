<?php

namespace Tests\Unit;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_album_can_be_created(): void
    {
        $album = GalleryAlbum::factory()->create([
            'name' => 'Test Album',
        ]);

        $this->assertDatabaseHas('gallery_albums', [
            'name' => 'Test Album',
        ]);
    }

    public function test_gallery_album_has_many_items(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryItem::factory()->count(3)->create(['album_id' => $album->id]);

        $this->assertCount(3, $album->items);
        $this->assertInstanceOf(GalleryItem::class, $album->items->first());
    }

    public function test_gallery_item_belongs_to_album(): void
    {
        $album = GalleryAlbum::factory()->create();
        $item = GalleryItem::factory()->create(['album_id' => $album->id]);

        $this->assertInstanceOf(GalleryAlbum::class, $item->album);
        $this->assertEquals($album->id, $item->album->id);
    }

    public function test_gallery_item_can_be_image(): void
    {
        $item = GalleryItem::factory()->create(['type' => 'image']);

        $this->assertEquals('image', $item->type);
    }

    public function test_gallery_item_can_be_video(): void
    {
        $item = GalleryItem::factory()->video()->create();

        $this->assertEquals('video', $item->type);
    }

    public function test_deleting_album_deletes_items(): void
    {
        $album = GalleryAlbum::factory()->create();
        $items = GalleryItem::factory()->count(3)->create(['album_id' => $album->id]);

        $album->delete();

        foreach ($items as $item) {
            $this->assertDatabaseMissing('gallery_items', ['id' => $item->id]);
        }
    }
}
