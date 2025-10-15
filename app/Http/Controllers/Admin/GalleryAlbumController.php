<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryAlbumController extends Controller
{
    /**
     * Display a listing of gallery albums.
     */
    public function index()
    {
        $albums = GalleryAlbum::withCount('items')
            ->ordered()
            ->paginate(12);

        return view('admin.gallery-albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new album.
     */
    public function create()
    {
        return view('admin.gallery-albums.create');
    }

    /**
     * Store a newly created album in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('gallery/albums', 'public');
        }

        // Set default sort order if not provided
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = GalleryAlbum::max('sort_order') + 1;
        }

        $album = GalleryAlbum::create($validated);

        return redirect()
            ->route('admin.gallery-albums.index')
            ->with('success', 'Album created successfully.');
    }

    /**
     * Display the specified album.
     */
    public function show(GalleryAlbum $galleryAlbum)
    {
        $galleryAlbum->load(['items' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return view('admin.gallery-albums.show', compact('galleryAlbum'));
    }

    /**
     * Show the form for editing the specified album.
     */
    public function edit(GalleryAlbum $galleryAlbum)
    {
        return view('admin.gallery-albums.edit', compact('galleryAlbum'));
    }

    /**
     * Update the specified album in storage.
     */
    public function update(Request $request, GalleryAlbum $galleryAlbum)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($galleryAlbum->cover_image) {
                Storage::disk('public')->delete($galleryAlbum->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('gallery/albums', 'public');
        }

        $galleryAlbum->update($validated);

        return redirect()
            ->route('admin.gallery-albums.index')
            ->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified album from storage.
     */
    public function destroy(GalleryAlbum $galleryAlbum)
    {
        // Delete cover image if exists
        if ($galleryAlbum->cover_image) {
            Storage::disk('public')->delete($galleryAlbum->cover_image);
        }

        // Delete all items in the album (cascade will handle this, but we need to delete files)
        foreach ($galleryAlbum->items as $item) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
        }

        $galleryAlbum->delete();

        return redirect()
            ->route('admin.gallery-albums.index')
            ->with('success', 'Album deleted successfully.');
    }

    /**
     * Update the sort order of albums.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'albums' => 'required|array',
            'albums.*.id' => 'required|exists:gallery_albums,id',
            'albums.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['albums'] as $albumData) {
            GalleryAlbum::where('id', $albumData['id'])
                ->update(['sort_order' => $albumData['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Album order updated successfully.',
        ]);
    }
}
