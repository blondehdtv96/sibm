<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use App\Models\Competency;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $sitemap .= $this->addUrl(url('/'), now(), 'daily', '1.0');

        // Static pages
        $staticPages = [
            'info/about' => 'weekly',
            'info/overview' => 'weekly', 
            'info/principal-message' => 'weekly',
            'info/contact' => 'monthly',
            'public/competencies' => 'weekly',
            'public/news' => 'daily',
            'public/gallery' => 'weekly',
            'ppdb/register' => 'daily',
            'ppdb/check-status' => 'daily',
        ];

        foreach ($staticPages as $page => $frequency) {
            $sitemap .= $this->addUrl(url($page), now(), $frequency, '0.8');
        }

        // News articles
        $news = News::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($news as $article) {
            $sitemap .= $this->addUrl(
                route('public.news.show', $article->slug),
                $article->updated_at,
                'weekly',
                '0.7'
            );
        }

        // Competencies
        $competencies = Competency::where('is_active', true)->get();
        foreach ($competencies as $competency) {
            $sitemap .= $this->addUrl(
                route('public.competencies.show', $competency->slug),
                $competency->updated_at,
                'monthly',
                '0.8'
            );
        }

        // Pages
        $pages = Page::where('is_published', true)->get();
        foreach ($pages as $page) {
            $sitemap .= $this->addUrl(
                route('public.pages.show', $page->slug),
                $page->updated_at,
                'monthly',
                '0.6'
            );
        }

        // Gallery Albums
        $albums = GalleryAlbum::where('is_active', true)->get();
        foreach ($albums as $album) {
            $sitemap .= $this->addUrl(
                route('public.gallery.show', $album->slug),
                $album->updated_at,
                'monthly',
                '0.5'
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    private function addUrl($url, $lastmod, $changefreq, $priority)
    {
        $xml = "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $xml .= "    <lastmod>" . $lastmod->format('Y-m-d\TH:i:s+00:00') . "</lastmod>\n";
        $xml .= "    <changefreq>" . $changefreq . "</changefreq>\n";
        $xml .= "    <priority>" . $priority . "</priority>\n";
        $xml .= "  </url>\n";
        
        return $xml;
    }

    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /login\n";
        $robots .= "Disallow: /register\n";
        $robots .= "Disallow: /password/\n";
        $robots .= "\n";
        $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($robots, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}