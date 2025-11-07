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

    /**
     * Show school content management page
     */
    public function schoolContent()
    {
        $overview = Setting::get('school_overview', '');
        $principalName = Setting::get('principal_name', '');
        $principalPhoto = Setting::get('principal_photo', '');
        $principalMessage = Setting::get('principal_message', '');

        return view('admin.settings.school-content', compact(
            'overview',
            'principalName',
            'principalPhoto',
            'principalMessage'
        ));
    }

    /**
     * Update school overview
     */
    public function updateOverview(Request $request)
    {
        $request->validate([
            'school_overview' => 'required|string',
        ]);

        Setting::set('school_overview', $request->school_overview, 'text');

        return redirect()->back()->with('success', 'Selayang Pandang berhasil diperbarui!');
    }

    /**
     * Update principal message
     */
    public function updatePrincipalMessage(Request $request)
    {
        $request->validate([
            'principal_name' => 'required|string|max:255',
            'principal_message' => 'required|string',
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        Setting::set('principal_name', $request->principal_name);
        Setting::set('principal_message', $request->principal_message, 'text');

        // Handle photo upload
        if ($request->hasFile('principal_photo')) {
            // Delete old photo if exists
            $oldPhoto = Setting::get('principal_photo');
            if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            // Upload new photo
            $file = $request->file('principal_photo');
            $filename = 'principal_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('principal', $filename, 'public');

            Setting::set('principal_photo', $path, 'image');
        }

        return redirect()->back()->with('success', 'Sambutan Kepala Sekolah berhasil diperbarui!');
    }

    /**
     * Delete principal photo
     */
    public function deletePrincipalPhoto()
    {
        $photo = Setting::get('principal_photo');

        if ($photo && Storage::disk('public')->exists($photo)) {
            Storage::disk('public')->delete($photo);
        }

        Setting::set('principal_photo', null, 'image');

        return redirect()->back()->with('success', 'Foto Kepala Sekolah berhasil dihapus!');
    }
}
