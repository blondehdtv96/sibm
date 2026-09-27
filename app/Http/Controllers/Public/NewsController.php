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

        $news = $query->latest('published_at')->paginate(16);
        $categories = NewsCategory::withCount('publishedNews')->get();
        $selectedCategory = $request->filled('category')
            ? NewsCategory::where('slug', $request->category)->first()
            : null;

        // Slider sorotan hanya di halaman pertama arsip lengkap, supaya hasil
        // pencarian/filter langsung menampilkan daftar artikelnya.
        $headlines = collect();
        if (! $request->filled('search') && ! $request->filled('category') && $news->currentPage() === 1) {
            $headlines = News::with('category')
                ->published()
                ->whereNotNull('featured_image')
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        // Tanggal publikasi terbaru untuk ringkasan di header halaman.
        $latestPublishedAt = News::published()->max('published_at');
        $latestPublishedAt = $latestPublishedAt ? \Illuminate\Support\Carbon::parse($latestPublishedAt) : null;

        return view('public.news.index', compact(
            'news',
            'categories',
            'selectedCategory',
            'headlines',
            'latestPublishedAt'
        ));
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

        $news->load(['category', 'author', 'images']);

        // Get related news from the same category
        $relatedNews = News::with('category')
            ->published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Bila kategori belum punya artikel lain, tampilkan berita terbaru lainnya
        // supaya sidebar tidak kosong.
        if ($relatedNews->isEmpty()) {
            $relatedNews = News::with('category')
                ->published()
                ->where('id', '!=', $news->id)
                ->latest('published_at')
                ->take(4)
                ->get();
        }

        return view('public.news.show', compact('news', 'relatedNews'));
    }
}
