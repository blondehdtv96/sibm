<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of news categories.
     */
    public function index(Request $request)
    {
        $query = NewsCategory::withCount('news');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(15);

        return view('admin.news-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.news-categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:news_categories,slug',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = NewsCategory::generateUniqueSlug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        NewsCategory::create($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'News category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(NewsCategory $newsCategory)
    {
        $newsCategory->load(['news' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.news-categories.show', compact('newsCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.news-categories.edit', compact('newsCategory'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:news_categories,slug,' . $newsCategory->id,
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = NewsCategory::generateUniqueSlug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $newsCategory->update($validated);

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'News category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(NewsCategory $newsCategory)
    {
        // Check if category has news
        if ($newsCategory->news()->count() > 0) {
            return redirect()->route('admin.news-categories.index')
                ->with('error', 'Cannot delete category with existing news articles. Please reassign or delete the news first.');
        }

        $newsCategory->delete();

        return redirect()->route('admin.news-categories.index')
            ->with('success', 'News category deleted successfully.');
    }
}
