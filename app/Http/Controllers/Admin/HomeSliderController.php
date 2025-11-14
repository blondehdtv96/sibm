<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    public function index()
    {
        $sliders = HomeSlider::ordered()->paginate(10);
        return view('admin.home-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.home-sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $uploadedCount = 0;
        $order = $request->order;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('sliders', 'public');

                HomeSlider::create([
                    'image_path' => $path,
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'button_text' => $request->button_text,
                    'button_link' => $request->button_link,
                    'order' => $order,
                    'status' => $request->status,
                ]);

                $uploadedCount++;
                $order++; // Auto increment order for each image
            }
        }

        $message = $uploadedCount > 1 
            ? "Berhasil menambahkan {$uploadedCount} slider!" 
            : 'Slider berhasil ditambahkan!';

        return redirect()->route('admin.home-sliders.index')
            ->with('success', $message);
    }

    public function edit(HomeSlider $homeSlider)
    {
        return view('admin.home-sliders.edit', compact('homeSlider'));
    }

    public function update(Request $request, HomeSlider $homeSlider)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if (Storage::disk('public')->exists($homeSlider->image_path)) {
                Storage::disk('public')->delete($homeSlider->image_path);
            }
            $homeSlider->image_path = $request->file('image')->store('sliders', 'public');
        }

        $homeSlider->title = $request->title;
        $homeSlider->subtitle = $request->subtitle;
        $homeSlider->button_text = $request->button_text;
        $homeSlider->button_link = $request->button_link;
        $homeSlider->order = $request->order;
        $homeSlider->status = $request->status;
        $homeSlider->save();

        return redirect()->route('admin.home-sliders.index')
            ->with('success', 'Slider berhasil diperbarui!');
    }

    public function destroy(HomeSlider $homeSlider)
    {
        if (Storage::disk('public')->exists($homeSlider->image_path)) {
            Storage::disk('public')->delete($homeSlider->image_path);
        }

        $homeSlider->delete();

        return redirect()->route('admin.home-sliders.index')
            ->with('success', 'Slider berhasil dihapus!');
    }
}
