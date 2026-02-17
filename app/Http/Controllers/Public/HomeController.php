<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Competency;
use App\Models\GalleryAlbum;
use App\Models\HomeSlider;
use App\Models\Statistic;
use App\Models\IndustryPartner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with dynamic content.
     */
    public function index()
    {
        // Get active home sliders
        $sliders = HomeSlider::active()->ordered()->get();
        
        // Get latest published news (limit to 6)
        $latestNews = News::where('status', 'published')
            ->where('published_at', '<=', now())
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Get featured/active competencies (limit to 4)
        $featuredCompetencies = Competency::where('status', 'active')
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        // Get latest gallery albums (limit to 3)
        $latestGalleryAlbums = GalleryAlbum::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get announcement (latest news marked as important or just latest)
        $announcement = News::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->first();

        // Get statistics
        $statistics = Statistic::active()->get();

        // Get active industry partners
        $industryPartners = IndustryPartner::active()->ordered()->get();

        return view('public.home-new', compact(
            'sliders',
            'latestNews',
            'featuredCompetencies',
            'latestGalleryAlbums',
            'announcement',
            'statistics',
            'industryPartners'
        ));
    }
}
