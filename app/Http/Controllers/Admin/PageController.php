<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index(Request $request): View
    {
        $query = Page::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        $pages = $query->paginate(10)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(StorePageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('pages/banners', 'public');
        }

        $page = Page::create($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page): View
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();

        // Handle banner image removal
        if ($request->boolean('remove_banner_image') && $page->banner_image) {
            Storage::disk('public')->delete($page->banner_image);
            $validated['banner_image'] = null;
        }

        // Handle new banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($page->banner_image) {
                Storage::disk('public')->delete($page->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('pages/banners', 'public');
        }

        // Remove the remove_banner_image field from validated data
        unset($validated['remove_banner_image']);

        $page->update($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        // Delete associated banner image
        if ($page->banner_image) {
            Storage::disk('public')->delete($page->banner_image);
        }

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Toggle page status between draft and published.
     */
    public function toggleStatus(Page $page): RedirectResponse
    {
        $page->update([
            'status' => $page->status === 'published' ? 'draft' : 'published'
        ]);

        $status = $page->status === 'published' ? 'published' : 'unpublished';
        
        return redirect()
            ->back()
            ->with('success', "Page {$status} successfully.");
    }
}