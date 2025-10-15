<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompetencyController extends Controller
{
    /**
     * Display a listing of competencies.
     */
    public function index(Request $request)
    {
        $query = Competency::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $competencies = $query->ordered()->paginate(15);

        return view('admin.competencies.index', compact('competencies'));
    }

    /**
     * Show the form for creating a new competency.
     */
    public function create()
    {
        return view('admin.competencies.create');
    }

    /**
     * Store a newly created competency in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:competencies,slug',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Competency::generateUniqueSlug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('competencies', 'public');
        }

        // Set sort_order to max + 1 if not provided
        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = Competency::max('sort_order') + 1;
        }

        Competency::create($validated);

        return redirect()->route('admin.competencies.index')
            ->with('success', 'Competency program created successfully.');
    }

    /**
     * Display the specified competency.
     */
    public function show(Competency $competency)
    {
        return view('admin.competencies.show', compact('competency'));
    }

    /**
     * Show the form for editing the specified competency.
     */
    public function edit(Competency $competency)
    {
        return view('admin.competencies.edit', compact('competency'));
    }

    /**
     * Update the specified competency in storage.
     */
    public function update(Request $request, Competency $competency)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:competencies,slug,' . $competency->id,
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Competency::generateUniqueSlug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($competency->image) {
                Storage::disk('public')->delete($competency->image);
            }
            $validated['image'] = $request->file('image')->store('competencies', 'public');
        }

        $competency->update($validated);

        return redirect()->route('admin.competencies.index')
            ->with('success', 'Competency program updated successfully.');
    }

    /**
     * Remove the specified competency from storage.
     */
    public function destroy(Competency $competency)
    {
        // Delete image
        if ($competency->image) {
            Storage::disk('public')->delete($competency->image);
        }

        $competency->delete();

        return redirect()->route('admin.competencies.index')
            ->with('success', 'Competency program deleted successfully.');
    }

    /**
     * Update the sort order of competencies.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:competencies,id',
        ]);

        foreach ($validated['order'] as $index => $id) {
            Competency::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.',
        ]);
    }
}
