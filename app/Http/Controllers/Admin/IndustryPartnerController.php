<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndustryPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndustryPartnerController extends Controller
{
    public function index()
    {
        $partners = IndustryPartner::ordered()->paginate(15);
        return view('admin.industry-partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.industry-partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('industry-partners', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        IndustryPartner::create($validated);

        return redirect()->route('admin.industry-partners.index')
            ->with('success', 'Partner industri berhasil ditambahkan.');
    }

    public function edit(IndustryPartner $industryPartner)
    {
        return view('admin.industry-partners.edit', compact('industryPartner'));
    }

    public function update(Request $request, IndustryPartner $industryPartner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($industryPartner->logo) {
                Storage::disk('public')->delete($industryPartner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('industry-partners', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $industryPartner->order;

        $industryPartner->update($validated);

        return redirect()->route('admin.industry-partners.index')
            ->with('success', 'Partner industri berhasil diperbarui.');
    }

    public function destroy(IndustryPartner $industryPartner)
    {
        // Delete logo
        if ($industryPartner->logo) {
            Storage::disk('public')->delete($industryPartner->logo);
        }

        $industryPartner->delete();

        return redirect()->route('admin.industry-partners.index')
            ->with('success', 'Partner industri berhasil dihapus.');
    }
}
