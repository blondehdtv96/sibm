<?php

namespace Tests\Unit;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_can_be_created(): void
    {
        $user = User::factory()->admin()->create();
        $category = NewsCategory::factory()->create();

        $news = News::factory()->create([
            'title' => 'Test News',
            'author_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('news', [
            'title' => 'Test News',
        ]);
    }

    public function test_news_belongs_to_category(): void
    {
        $category = NewsCategory::factory()->create();
        $news = News::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(NewsCategory::class, $news->category);
        $this->assertEquals($category->id, $news->category->id);
    }

    public function test_news_belongs_to_author(): void
    {
        $author = User::factory()->admin()->create();
        $news = News::factory()->create(['author_id' => $author->id]);

        $this->assertInstanceOf(User::class, $news->author);
        $this->assertEquals($author->id, $news->author->id);
    }

    public function test_news_slug_is_unique(): void
    {
        News::factory()->create(['slug' => 'unique-news-slug']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        News::factory()->create(['slug' => 'unique-news-slug']);
    }

    public function test_news_can_be_published(): void
    {
        $news = News::factory()->published()->create();

        $this->assertEquals('published', $news->status);
        $this->assertNotNull($news->published_at);
    }

    public function test_news_can_be_draft(): void
    {
        $news = News::factory()->draft()->create();

        $this->assertEquals('draft', $news->status);
        $this->assertNull($news->published_at);
    }

    public function test_news_scope_published_only_returns_published_news(): void
    {
        News::factory()->published()->count(5)->create();
        News::factory()->draft()->count(3)->create();

        $publishedNews = News::published()->get();

        $this->assertCount(5, $publishedNews);
        $publishedNews->each(function ($news) {
            $this->assertEquals('published', $news->status);
        });
    }
}
