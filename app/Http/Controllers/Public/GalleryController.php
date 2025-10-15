<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery albums.
     */
    public function index()
    {
        $albums = GalleryAlbum::withCount('items')
            ->ordered()
            ->paginate(12);

        return view('public.gallery.index', compact('albums'));
    }

    /**
     * Display the specified album with its items.
     */
    public function show(GalleryAlbum $galleryAlbum)
    {
        $galleryAlbum->load(['items' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return view('public.gallery.show', compact('galleryAlbum'));
    }
}
