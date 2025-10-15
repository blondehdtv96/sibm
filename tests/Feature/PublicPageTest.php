<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that published pages can be viewed by public users.
     */
    public function test_published_page_can_be_viewed(): void
    {
        // Create a published page
        $page = Page::create([
            'slug' => 'about-us',
            'title' => 'About Us',
            'content' => '<p>This is our about page content.</p>',
            'meta_description' => 'Learn more about our school',
            'status' => 'published',
        ]);

        // Visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertSee('About Us');
        $response->assertSee('This is our about page content.');
    }

    /**
     * Test that draft pages cannot be viewed by public users.
     */
    public function test_draft_page_cannot_be_viewed(): void
    {
        // Create a draft page
        $page = Page::create([
            'slug' => 'draft-page',
            'title' => 'Draft Page',
            'content' => '<p>This is a draft page.</p>',
            'status' => 'draft',
        ]);

        // Try to visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert 404 response
        $response->assertStatus(404);
    }

    /**
     * Test that non-existent pages return 404.
     */
    public function test_non_existent_page_returns_404(): void
    {
        // Try to visit a non-existent page
        $response = $this->get(route('public.pages.show', 'non-existent-page'));

        // Assert 404 response
        $response->assertStatus(404);
    }

    /**
     * Test that page displays SEO meta tags correctly.
     */
    public function test_page_displays_seo_meta_tags(): void
    {
        // Create a published page with meta description
        $page = Page::create([
            'slug' => 'contact',
            'title' => 'Contact Us',
            'content' => '<p>Get in touch with us.</p>',
            'meta_description' => 'Contact our school for inquiries',
            'status' => 'published',
        ]);

        // Visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert SEO meta tags are present
        $response->assertStatus(200);
        $response->assertSee('Contact Us', false);
        $response->assertSee('Contact our school for inquiries', false);
    }

    /**
     * Test that page with banner image displays correctly.
     */
    public function test_page_with_banner_image_displays_correctly(): void
    {
        // Create a published page with banner image
        $page = Page::create([
            'slug' => 'facilities',
            'title' => 'Our Facilities',
            'content' => '<p>Explore our modern facilities.</p>',
            'banner_image' => 'pages/banner.jpg',
            'meta_description' => 'View our school facilities',
            'status' => 'published',
        ]);

        // Visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert the page loads and banner is referenced
        $response->assertStatus(200);
        $response->assertSee('Our Facilities');
        $response->assertSee('pages/banner.jpg', false);
    }

    /**
     * Test that page URLs are SEO-friendly (using slugs).
     */
    public function test_page_urls_are_seo_friendly(): void
    {
        // Create a page with a descriptive slug
        $page = Page::create([
            'slug' => 'academic-programs-and-curriculum',
            'title' => 'Academic Programs and Curriculum',
            'content' => '<p>Our comprehensive academic programs.</p>',
            'status' => 'published',
        ]);

        // Generate the URL
        $url = route('public.pages.show', $page->slug);

        // Assert the URL contains the slug
        $this->assertStringContainsString('academic-programs-and-curriculum', $url);
        $this->assertStringNotContainsString('id=', $url);
    }

    /**
     * Test that page content is properly rendered with HTML.
     */
    public function test_page_content_renders_html(): void
    {
        // Create a page with HTML content
        $page = Page::create([
            'slug' => 'test-page',
            'title' => 'Test Page',
            'content' => '<h2>Section Title</h2><p>Paragraph content.</p><ul><li>List item</li></ul>',
            'status' => 'published',
        ]);

        // Visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert HTML is rendered
        $response->assertStatus(200);
        $response->assertSee('<h2>Section Title</h2>', false);
        $response->assertSee('<p>Paragraph content.</p>', false);
        $response->assertSee('<ul><li>List item</li></ul>', false);
    }

    /**
     * Test that page displays last updated date.
     */
    public function test_page_displays_last_updated_date(): void
    {
        // Create a published page
        $page = Page::create([
            'slug' => 'news-page',
            'title' => 'Latest News',
            'content' => '<p>Check out our latest news.</p>',
            'status' => 'published',
        ]);

        // Visit the page
        $response = $this->get(route('public.pages.show', $page->slug));

        // Assert the page shows updated date
        $response->assertStatus(200);
        $response->assertSee('Last updated:');
    }
}
