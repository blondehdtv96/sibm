<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use App\Models\CompetencyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompetencyImageController extends Controller
{
    public function index(Competency $competency)
    {
        $images = $competency->images()->paginate(12);
        return view('admin.competency-images.index', compact('competency', 'images'));
    }

    public function create(Competency $competency)
    {
        return view('admin.competency-images.create', compact('competency'));
    }

    public function store(Request $request, Competency $competency)
    {
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $lastOrder = $competency->images()->max('order') ?? 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('competencies/' . $competency->slug, $filename, 'public');

                CompetencyImage::create([
                    'competency_id' => $competency->id,
                    'image_path' => $path,
                    'title' => $request->title,
                    'description' => $request->description,
                    'order' => $lastOrder + $index + 1,
                    'status' => $request->status,
                ]);
            }
        }

        return redirect()->route('admin.competencies.images.index', $competency)
            ->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function edit(Competency $competency, CompetencyImage $image)
    {
        return view('admin.competency-images.edit', compact('competency', 'image'));
    }

    public function update(Request $request, Competency $competency, CompetencyImage $image)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Upload new image
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('competencies/' . $competency->slug, $filename, 'public');
            
            $image->image_path = $path;
        }

        $image->title = $request->title;
        $image->description = $request->description;
        $image->order = $request->order;
        $image->status = $request->status;
        $image->save();

        return redirect()->route('admin.competencies.images.index', $competency)
            ->with('success', 'Gambar berhasil diperbarui!');
    }

    public function destroy(Competency $competency, CompetencyImage $image)
    {
        // Delete image file
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->route('admin.competencies.images.index', $competency)
            ->with('success', 'Gambar berhasil dihapus!');
    }

    public function reorder(Request $request, Competency $competency)
    {
        $items = $request->input('items', []);

        foreach ($items as $index => $id) {
            CompetencyImage::where('id', $id)
                ->where('competency_id', $competency->id)
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
