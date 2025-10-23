<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
        ]);

        Setting::set('site_name', $request->site_name);
        Setting::set('site_tagline', $request->site_tagline);

        return redirect()->back()->with('success', 'Pengaturan umum berhasil diperbarui!');
    }

    /**
     * Update logo
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:site_logo,site_logo_dark,site_favicon',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg,ico|max:2048',
        ]);

        $logoType = $request->logo_type;
        
        // Delete old logo if exists
        $oldLogo = Setting::get($logoType);
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        // Upload new logo
        $file = $request->file('logo');
        $filename = $logoType . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('logos', $filename, 'public');

        // Save to settings
        Setting::set($logoType, $path, 'image');

        $logoNames = [
            'site_logo' => 'Logo Utama',
            'site_logo_dark' => 'Logo Dark Mode',
            'site_favicon' => 'Favicon',
        ];

        return redirect()->back()->with('success', $logoNames[$logoType] . ' berhasil diperbarui!');
    }

    /**
     * Delete logo
     */
    public function deleteLogo(Request $request)
    {
        $request->validate([
            'logo_type' => 'required|in:site_logo,site_logo_dark,site_favicon',
        ]);

        $logoType = $request->logo_type;
        $logo = Setting::get($logoType);

        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }

        Setting::set($logoType, null, 'image');

        $logoNames = [
            'site_logo' => 'Logo Utama',
            'site_logo_dark' => 'Logo Dark Mode',
            'site_favicon' => 'Favicon',
        ];

        return redirect()->back()->with('success', $logoNames[$logoType] . ' berhasil dihapus!');
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        Setting::clearCache();
        return redirect()->back()->with('success', 'Cache pengaturan berhasil dibersihkan!');
    }
}
