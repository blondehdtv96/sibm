<?php

namespace Tests\Feature;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_gallery_albums_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/gallery-albums');

        $response->assertStatus(200);
        $response->assertViewIs('admin.gallery-albums.index');
    }

    public function test_admin_can_create_gallery_album(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/gallery-albums', [
            'name' => 'New Album',
            'description' => 'Album description',
            'sort_order' => 1,
        ]);

        $response->assertRedirect('/admin/gallery-albums');
        $this->assertDatabaseHas('gallery_albums', [
            'name' => 'New Album',
        ]);
    }

    public function test_admin_can_update_gallery_album(): void
    {
        $album = GalleryAlbum::factory()->create();

        $response = $this->actingAs($this->admin)->put("/admin/gallery-albums/{$album->id}", [
            'name' => 'Updated Album',
            'description' => 'Updated description',
            'sort_order' => 1,
        ]);

        $response->assertRedirect('/admin/gallery-albums');
        $this->assertDatabaseHas('gallery_albums', [
            'id' => $album->id,
            'name' => 'Updated Album',
        ]);
    }

    public function test_admin_can_delete_gallery_album(): void
    {
        $album = GalleryAlbum::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/gallery-albums/{$album->id}");

        $response->assertRedirect('/admin/gallery-albums');
        $this->assertDatabaseMissing('gallery_albums', ['id' => $album->id]);
    }

    public function test_admin_can_add_items_to_album(): void
    {
        $album = GalleryAlbum::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/gallery-items', [
            'album_id' => $album->id,
            'title' => 'New Item',
            'type' => 'image',
            'sort_order' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gallery_items', [
            'album_id' => $album->id,
            'title' => 'New Item',
        ]);
    }

    public function test_public_can_view_gallery_albums(): void
    {
        GalleryAlbum::factory()->count(3)->create();

        $response = $this->get('/gallery');

        $response->assertStatus(200);
        $response->assertViewIs('public.gallery.index');
    }

    public function test_public_can_view_album_with_items(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryItem::factory()->count(5)->create(['album_id' => $album->id]);

        $response = $this->get("/gallery/{$album->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('public.gallery.show');
        $response->assertViewHas('album', $album);
    }
}
