<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Competency;
use App\Models\Page;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results across all content types.
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return view('public.search.index', [
                'query' => '',
                'news' => collect(),
                'competencies' => collect(),
                'pages' => collect(),
                'totalResults' => 0,
            ]);
        }

        // Search news
        $news = News::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->with(['category', 'author'])
            ->latest('published_at')
            ->take(10)
            ->get();

        // Search competencies
        $competencies = Competency::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->ordered()
            ->take(10)
            ->get();

        // Search pages
        $pages = Page::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->take(10)
            ->get();

        $totalResults = $news->count() + $competencies->count() + $pages->count();

        return view('public.search.index', compact('query', 'news', 'competencies', 'pages', 'totalResults'));
    }
}
