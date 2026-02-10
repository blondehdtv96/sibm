<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\News;
use App\Models\Competency;
use App\Models\GalleryAlbum;
use App\Models\Page;
use App\Models\Menu;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml
     */
    public function index()
    {
        try {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
            $sitemap .= ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
            
            // Homepage
            $sitemap .= $this->addUrl(route('home'), now(), 'daily', '1.0');
            
            // Static pages
            $sitemap .= $this->addUrl(route('info.about'), now()->subDays(7), 'weekly', '0.9');
            $sitemap .= $this->addUrl(route('info.contact'), now()->subDays(7), 'monthly', '0.8');
            $sitemap .= $this->addUrl(route('ppdb.register'), now()->subDays(1), 'daily', '0.9');
            $sitemap .= $this->addUrl(route('ppdb.check-status'), now()->subDays(1), 'daily', '0.7');
            
            // News index
            $sitemap .= $this->addUrl(route('public.news.index'), now()->subHours(12), 'daily', '0.9');
            
            // News articles
            $newsArticles = News::where('status', 'published')
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->get();
            
            foreach ($newsArticles as $news) {
                $images = [];
                
                // Featured image
                if ($news->featured_image) {
                    $images[] = [
                        'loc' => asset('storage/' . $news->featured_image),
                        'title' => $news->title,
                    ];
                }
                
                $sitemap .= $this->addUrl(
                    route('public.news.show', $news->slug),
                    $news->updated_at ?? $news->published_at,
                    'weekly',
                    '0.8',
                    $images
                );
            }
            
            // Competencies index
            $sitemap .= $this->addUrl(route('public.competencies.index'), now()->subDays(7), 'weekly', '0.9');
            
            // Competencies
            $competencies = Competency::where('status', 'active')
                ->orderBy('sort_order')
                ->get();
            
            foreach ($competencies as $competency) {
                $images = [];
                
                // Featured image
                if ($competency->image) {
                    $images[] = [
                        'loc' => asset('storage/' . $competency->image),
                        'title' => $competency->name,
                    ];
                }
                
                $sitemap .= $this->addUrl(
                    route('public.competencies.show', $competency->slug),
                    $competency->updated_at,
                    'monthly',
                    '0.8',
                    $images
                );
            }
            
            // Gallery index
            $sitemap .= $this->addUrl(route('public.gallery.index'), now()->subDays(3), 'weekly', '0.8');
            
            // Gallery albums
            $albums = GalleryAlbum::orderBy('sort_order')->get();
            
            foreach ($albums as $album) {
                $images = [];
                
                // Cover image
                if ($album->cover_image) {
                    $images[] = [
                        'loc' => asset('storage/' . $album->cover_image),
                        'title' => $album->name,
                    ];
                }
                
                $sitemap .= $this->addUrl(
                    route('public.gallery.show', $album->slug),
                    $album->updated_at,
                    'weekly',
                    '0.7',
                    $images
                );
            }
            
            // Dynamic pages from database
            $pages = Page::where('status', 'published')
                ->orderBy('updated_at', 'desc')
                ->get();
            
            foreach ($pages as $page) {
                $sitemap .= $this->addUrl(
                    route('public.pages.show', $page->slug),
                    $page->updated_at,
                    'monthly',
                    '0.6'
                );
            }
            
            $sitemap .= '</urlset>';
            
            return response($sitemap, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Cache-Control', 'public, max-age=3600'); // Cache for 1 hour
                
        } catch (\Exception $e) {
            \Log::error('Sitemap generation error: ' . $e->getMessage());
            
            // Return minimal sitemap on error
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $sitemap .= $this->addUrl(route('home'), now(), 'daily', '1.0');
            $sitemap .= '</urlset>';
            
            return response($sitemap, 200)
                ->header('Content-Type', 'application/xml');
        }
    }
    
    /**
     * Generate robots.txt
     */
    public function robots()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /dashboard/\n";
        $robots .= "Disallow: /login\n";
        $robots .= "Disallow: /register\n";
        $robots .= "Disallow: /storage/private/\n";
        $robots .= "\n";
        $robots .= "# Sitemap\n";
        $robots .= "Sitemap: " . route('sitemap') . "\n";
        
        return response($robots, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Cache-Control', 'public, max-age=86400'); // Cache for 24 hours
    }
    
    /**
     * Helper function to add URL to sitemap
     */
    private function addUrl($loc, $lastmod = null, $changefreq = 'weekly', $priority = '0.5', $images = [])
    {
        $url = '<url>';
        $url .= '<loc>' . htmlspecialchars($loc) . '</loc>';
        
        if ($lastmod) {
            $url .= '<lastmod>' . $lastmod->format('Y-m-d\TH:i:sP') . '</lastmod>';
        }
        
        $url .= '<changefreq>' . $changefreq . '</changefreq>';
        $url .= '<priority>' . $priority . '</priority>';
        
        // Add images if provided
        foreach ($images as $image) {
            $url .= '<image:image>';
            $url .= '<image:loc>' . htmlspecialchars($image['loc']) . '</image:loc>';
            if (isset($image['title'])) {
                $url .= '<image:title>' . htmlspecialchars($image['title']) . '</image:title>';
            }
            $url .= '</image:image>';
        }
        
        $url .= '</url>';
        
        return $url;
    }
}
