<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create a news category
        $this->category = NewsCategory::create([
            'name' => 'School Events',
            'slug' => 'school-events',
            'description' => 'Latest school events and activities',
        ]);

        Storage::fake('public');
    }

    /** @test */
    public function admin_can_view_news_index()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.news.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.news.index');
    }

    /** @test */
    public function admin_can_view_create_news_form()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.news.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.news.create');
        $response->assertViewHas('categories');
    }

    /** @test */
    public function admin_can_create_news_article()
    {
        $image = UploadedFile::fake()->image('news.jpg');

        $data = [
            'title' => 'New School Event',
            'content' => 'This is a test news article about a school event.',
            'excerpt' => 'Test excerpt',
            'category_id' => $this->category->id,
            'featured_image' => $image,
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $response->assertRedirect(route('admin.news.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('news', [
            'title' => 'New School Event',
            'slug' => 'new-school-event',
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'status' => 'published',
        ]);

        Storage::disk('public')->assertExists('news/' . $image->hashName());
    }

    /** @test */
    public function admin_can_create_news_without_image()
    {
        $data = [
            'title' => 'News Without Image',
            'content' => 'This is a test news article without an image.',
            'category_id' => $this->category->id,
            'status' => 'draft',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'title' => 'News Without Image',
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function slug_is_auto_generated_from_title()
    {
        $data = [
            'title' => 'Test News Article Title',
            'content' => 'Content here',
            'category_id' => $this->category->id,
            'status' => 'draft',
        ];

        $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $this->assertDatabaseHas('news', [
            'title' => 'Test News Article Title',
            'slug' => 'test-news-article-title',
        ]);
    }

    /** @test */
    public function admin_can_view_edit_news_form()
    {
        $news = News::create([
            'title' => 'Test News',
            'slug' => 'test-news',
            'content' => 'Test content',
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.news.edit', $news));

        $response->assertStatus(200);
        $response->assertViewIs('admin.news.edit');
        $response->assertViewHas('news', $news);
    }

    /** @test */
    public function admin_can_update_news_article()
    {
        $news = News::create([
            'title' => 'Original Title',
            'slug' => 'original-title',
            'content' => 'Original content',
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $data = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'category_id' => $this->category->id,
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.news.update', $news), $data);

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Updated Title',
            'status' => 'published',
        ]);
    }

    /** @test */
    public function admin_can_delete_news_article()
    {
        $news = News::create([
            'title' => 'News to Delete',
            'slug' => 'news-to-delete',
            'content' => 'Content',
            'category_id' => $this->category->id,
            'author_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.news.destroy', $news));

        $response->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }

    /** @test */
    public function published_at_is_set_automatically_when_publishing()
    {
        $data = [
            'title' => 'Auto Published News',
            'content' => 'Content',
            'category_id' => $this->category->id,
            'status' => 'published',
        ];

        $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $news = News::where('title', 'Auto Published News')->first();
        $this->assertNotNull($news->published_at);
    }

    /** @test */
    public function news_requires_title_and_content()
    {
        $data = [
            'category_id' => $this->category->id,
            'status' => 'draft',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $response->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function news_requires_valid_category()
    {
        $data = [
            'title' => 'Test News',
            'content' => 'Content',
            'category_id' => 999, // Non-existent category
            'status' => 'draft',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.news.store'), $data);

        $response->assertSessionHasErrors(['category_id']);
    }
}
