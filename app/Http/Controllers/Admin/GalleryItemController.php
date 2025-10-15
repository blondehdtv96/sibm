<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryItemController extends Controller
{
    /**
     * Show the form for creating new gallery items.
     */
    public function create(Request $request)
    {
        $albumId = $request->query('album');
        $album = null;
        
        if ($albumId) {
            $album = GalleryAlbum::findOrFail($albumId);
        }
        
        $albums = GalleryAlbum::ordered()->get();
        
        return view('admin.gallery-items.create', compact('albums', 'album'));
    }

    /**
     * Store newly created gallery items in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:gallery_albums,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
        ]);

        $album = GalleryAlbum::findOrFail($validated['album_id']);
        $maxSortOrder = $album->items()->max('sort_order') ?? -1;
        $uploadedCount = 0;

        foreach ($request->file('images') as $index => $image) {
            try {
                // Store original image
                $path = $image->store('gallery/items', 'public');
                
                // Generate and store thumbnail
                $this->generateThumbnail($path);
                
                // Create gallery item
                GalleryItem::create([
                    'album_id' => $validated['album_id'],
                    'title' => $validated['titles'][$index] ?? null,
                    'image_path' => $path,
                    'type' => 'image',
                    'sort_order' => ++$maxSortOrder,
                ]);
                
                $uploadedCount++;
            } catch (\Exception $e) {
                \Log::error('Failed to upload gallery item: ' . $e->getMessage());
            }
        }

        return redirect()
            ->route('admin.gallery-albums.show', $album)
            ->with('success', "{$uploadedCount} " . \Str::plural('item', $uploadedCount) . " uploaded successfully.");
    }

    /**
     * Show the form for editing the specified gallery item.
     */
    public function edit(GalleryItem $galleryItem)
    {
        $albums = GalleryAlbum::ordered()->get();
        
        return view('admin.gallery-items.edit', compact('galleryItem', 'albums'));
    }

    /**
     * Update the specified gallery item in storage.
     */
    public function update(Request $request, GalleryItem $galleryItem)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:gallery_albums,id',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle image replacement
        if ($request->hasFile('image')) {
            // Delete old image and thumbnail
            if ($galleryItem->image_path) {
                Storage::disk('public')->delete($galleryItem->image_path);
                $this->deleteThumbnail($galleryItem->image_path);
            }
            
            // Store new image
            $path = $request->file('image')->store('gallery/items', 'public');
            $validated['image_path'] = $path;
            
            // Generate thumbnail
            $this->generateThumbnail($path);
        }

        $galleryItem->update($validated);

        return redirect()
            ->route('admin.gallery-albums.show', $galleryItem->album)
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified gallery item from storage.
     */
    public function destroy(GalleryItem $galleryItem)
    {
        $album = $galleryItem->album;
        
        // Delete image and thumbnail
        if ($galleryItem->image_path) {
            Storage::disk('public')->delete($galleryItem->image_path);
            $this->deleteThumbnail($galleryItem->image_path);
        }

        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery-albums.show', $album)
            ->with('success', 'Item deleted successfully.');
    }

    /**
     * Generate thumbnail for an image.
     */
    protected function generateThumbnail(string $path): void
    {
        try {
            $fullPath = storage_path('app/public/' . $path);
            $pathInfo = pathinfo($fullPath);
            
            // Create thumbnails directory if it doesn't exist
            $thumbnailDir = $pathInfo['dirname'] . '/thumbnails';
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            // Generate thumbnail
            $thumbnailPath = $thumbnailDir . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            
            $img = Image::make($fullPath);
            
            // Resize to thumbnail size (400x400 max, maintain aspect ratio)
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Optimize quality
            $img->save($thumbnailPath, 85);
            
            // Also optimize the original image
            $originalImg = Image::make($fullPath);
            $originalImg->resize(1920, 1920, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $originalImg->save($fullPath, 90);
            
        } catch (\Exception $e) {
            \Log::error('Failed to generate thumbnail: ' . $e->getMessage());
        }
    }

    /**
     * Delete thumbnail for an image.
     */
    protected function deleteThumbnail(string $path): void
    {
        try {
            $pathInfo = pathinfo($path);
            $thumbnailPath = $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
            Storage::disk('public')->delete($thumbnailPath);
        } catch (\Exception $e) {
            \Log::error('Failed to delete thumbnail: ' . $e->getMessage());
        }
    }

    /**
     * Upload items via AJAX for progress tracking.
     */
    public function uploadAjax(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:gallery_albums,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'title' => 'nullable|string|max:255',
        ]);

        try {
            $album = GalleryAlbum::findOrFail($validated['album_id']);
            $maxSortOrder = $album->items()->max('sort_order') ?? -1;
            
            // Store image
            $path = $request->file('image')->store('gallery/items', 'public');
            
            // Generate thumbnail
            $this->generateThumbnail($path);
            
            // Create gallery item
            $item = GalleryItem::create([
                'album_id' => $validated['album_id'],
                'title' => $validated['title'] ?? null,
                'image_path' => $path,
                'type' => 'image',
                'sort_order' => $maxSortOrder + 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'item' => [
                    'id' => $item->id,
                    'url' => $item->image_url,
                    'thumbnail_url' => $item->thumbnail_url,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage(),
            ], 500);
        }
    }
}
