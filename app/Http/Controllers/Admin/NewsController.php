<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $news = $query->latest('created_at')->paginate(15);
        $categories = NewsCategory::all();

        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating new news.
     */
    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store newly created news in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:news_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_caption.*' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = News::generateUniqueSlug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        // Set author
        $validated['author_id'] = auth()->id();

        // Set published_at if status is published and no date provided
        if ($validated['status'] === 'published') {
            if (empty($validated['published_at'])) {
                // Set to current time to ensure it's immediately visible
                $validated['published_at'] = now();
            } else {
                // Ensure the provided date is not in the future
                $publishedDate = \Carbon\Carbon::parse($validated['published_at']);
                if ($publishedDate->isFuture()) {
                    $validated['published_at'] = now();
                }
            }
        } else {
            // If draft, set published_at to null
            $validated['published_at'] = null;
        }

        $news = News::create($validated);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('news/gallery', 'public');
                $caption = $request->input('images_caption.' . $index) ?? null;
                
                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                    'caption' => $caption,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Display the specified news.
     */
    public function show(News $news)
    {
        $news->load(['category', 'author']);
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        $images = $news->images()->orderBy('order')->get();
        return view('admin.news.edit', compact('news', 'categories', 'images'));
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $news->id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:news_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_caption.*' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = News::generateUniqueSlug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        // Set published_at if status changed to published
        if ($validated['status'] === 'published') {
            if (empty($validated['published_at'])) {
                // If no published_at set, use now
                $validated['published_at'] = now();
            }
        } else {
            // If changed to draft, keep existing published_at (don't set to null)
            // This allows re-publishing without changing the date
        }

        $news->update($validated);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('news/gallery', 'public');
                $caption = $request->input('images_caption.' . $index) ?? null;
                
                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                    'caption' => $caption,
                    'order' => $news->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy(News $news)
    {
        // Delete featured image
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        // Delete gallery images
        foreach ($news->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    /**
     * Delete a specific image from a news article
     */
    public function deleteImage(Request $request, News $news, NewsImage $image)
    {
        if ($image->news_id !== $news->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Upload image from CKEditor
     */
    public function uploadImage(Request $request)
    {
        // CKEditor sends file with name 'upload'
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $file = $request->file('upload');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('news/content-images', $filename, 'public');

            // CKEditor 5 expects 'url' in response
            return response()->json([
                'url' => asset('storage/' . $path),
                'uploaded' => 1,
                'fileName' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Upload file (PDF, DOC, etc) from editor
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240' // Max 10MB
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('news/content-files', $filename, 'public');

            return response()->json([
                'url' => asset('storage/' . $path),
                'uploaded' => 1,
                'fileName' => $filename
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Upload failed: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
}
