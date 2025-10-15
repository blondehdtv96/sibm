<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_pages_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/pages');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.index');
    }

    public function test_non_admin_cannot_view_pages_index(): void
    {
        $student = User::factory()->student()->create();

        $response = $this->actingAs($student)->get('/admin/pages');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_create_page_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/pages/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.create');
    }

    public function test_admin_can_create_page(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post('/admin/pages', [
            'title' => 'New Test Page',
            'slug' => 'new-test-page',
            'content' => 'This is test content',
            'meta_description' => 'Test description',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', [
            'title' => 'New Test Page',
            'slug' => 'new-test-page',
        ]);
    }

    public function test_admin_can_view_edit_page_form(): void
    {
        $page = Page::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/pages/{$page->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.pages.edit');
        $response->assertViewHas('page', $page);
    }

    public function test_admin_can_update_page(): void
    {
        $page = Page::factory()->create();

        $response = $this->actingAs($this->admin)->put("/admin/pages/{$page->id}", [
            'title' => 'Updated Page Title',
            'slug' => $page->slug,
            'content' => 'Updated content',
            'meta_description' => 'Updated description',
            'status' => 'published',
        ]);

        $response->assertRedirect('/admin/pages');
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Updated Page Title',
        ]);
    }

    public function test_admin_can_delete_page(): void
    {
        $page = Page::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/pages/{$page->id}");

        $response->assertRedirect('/admin/pages');
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_page_requires_title(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pages', [
            'slug' => 'test-slug',
            'content' => 'Content',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_page_requires_unique_slug(): void
    {
        Page::factory()->create(['slug' => 'existing-slug']);

        $response = $this->actingAs($this->admin)->post('/admin/pages', [
            'title' => 'Test Page',
            'slug' => 'existing-slug',
            'content' => 'Content',
        ]);

        $response->assertSessionHasErrors('slug');
    }
}
