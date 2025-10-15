<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of published news.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])->published();

        // Filter by category
        if ($request->filled('category')) {
            $category = NewsCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $news = $query->latest('published_at')->paginate(12);
        $categories = NewsCategory::withCount('publishedNews')->get();
        $selectedCategory = $request->filled('category') 
            ? NewsCategory::where('slug', $request->category)->first() 
            : null;

        return view('public.news.index', compact('news', 'categories', 'selectedCategory'));
    }

    /**
     * Display the specified news article.
     */
    public function show(News $news)
    {
        // Only show published news
        if (!$news->isPublished()) {
            abort(404);
        }

        $news->load(['category', 'author']);

        // Get related news from the same category
        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}
