<?php

namespace Tests\Unit;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_created(): void
    {
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
        ]);

        $this->assertDatabaseHas('pages', [
            'title' => 'Test Page',
            'slug' => 'test-page',
        ]);
    }

    public function test_page_slug_is_unique(): void
    {
        Page::factory()->create(['slug' => 'unique-slug']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Page::factory()->create(['slug' => 'unique-slug']);
    }

    public function test_page_has_default_draft_status(): void
    {
        $page = Page::create([
            'title' => 'Draft Page',
            'slug' => 'draft-page',
            'content' => 'Content',
        ]);

        $this->assertEquals('draft', $page->status);
    }

    public function test_page_can_be_published(): void
    {
        $page = Page::factory()->published()->create();

        $this->assertEquals('published', $page->status);
    }

    public function test_page_scope_published_only_returns_published_pages(): void
    {
        Page::factory()->published()->count(3)->create();
        Page::factory()->draft()->count(2)->create();

        $publishedPages = Page::published()->get();

        $this->assertCount(3, $publishedPages);
        $publishedPages->each(function ($page) {
            $this->assertEquals('published', $page->status);
        });
    }
}
