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

    /**
     * Show contact & social media management page
     */
    public function contactSocial()
    {
        $contactAddress = Setting::get('contact_address', '');
        $contactPhone = Setting::get('contact_phone', '');
        $contactEmail = Setting::get('contact_email', '');
        $contactWhatsapp = Setting::get('contact_whatsapp', '');
        
        $socialFacebook = Setting::get('social_facebook', '');
        $socialInstagram = Setting::get('social_instagram', '');
        $socialTwitter = Setting::get('social_twitter', '');
        $socialYoutube = Setting::get('social_youtube', '');
        $socialTiktok = Setting::get('social_tiktok', '');
        $socialLinkedin = Setting::get('social_linkedin', '');

        return view('admin.settings.contact-social', compact(
            'contactAddress',
            'contactPhone',
            'contactEmail',
            'contactWhatsapp',
            'socialFacebook',
            'socialInstagram',
            'socialTwitter',
            'socialYoutube',
            'socialTiktok',
            'socialLinkedin'
        ));
    }

    /**
     * Update contact information
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:20',
        ]);

        Setting::set('contact_address', $request->contact_address, 'text');
        Setting::set('contact_phone', $request->contact_phone);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_whatsapp', $request->contact_whatsapp);

        return redirect()->back()->with('success', 'Informasi kontak berhasil diperbarui!');
    }

    /**
     * Update social media links
     */
    public function updateSocialMedia(Request $request)
    {
        $request->validate([
            'social_facebook' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
        ]);

        Setting::set('social_facebook', $request->social_facebook);
        Setting::set('social_instagram', $request->social_instagram);
        Setting::set('social_twitter', $request->social_twitter);
        Setting::set('social_youtube', $request->social_youtube);
        Setting::set('social_tiktok', $request->social_tiktok);
        Setting::set('social_linkedin', $request->social_linkedin);

        return redirect()->back()->with('success', 'Link sosial media berhasil diperbarui!');
    }

    public function updateStatistics(Request $request)
    {
        $validated = $request->validate([
            'stat1_value' => 'required|string|max:50',
            'stat1_label' => 'required|string|max:100',
            'stat2_value' => 'required|string|max:50',
            'stat2_label' => 'required|string|max:100',
            'stat3_value' => 'required|string|max:50',
            'stat3_label' => 'required|string|max:100',
            'stat4_value' => 'required|string|max:50',
            'stat4_label' => 'required|string|max:100',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Statistik homepage berhasil diperbarui!');
    }

    public function updatePpdbBrochure(Request $request)
    {
        $validated = $request->validate([
            'ppdb_brochure' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'ppdb_brochure_title' => 'nullable|string|max:255',
            'ppdb_brochure_description' => 'nullable|string|max:500',
        ]);

        // Handle file upload
        if ($request->hasFile('ppdb_brochure')) {
            // Delete old brochure if exists
            $oldBrochure = Setting::where('key', 'ppdb_brochure')->first();
            if ($oldBrochure && $oldBrochure->value && Storage::disk('public')->exists($oldBrochure->value)) {
                Storage::disk('public')->delete($oldBrochure->value);
            }

            // Store new brochure
            $path = $request->file('ppdb_brochure')->store('brochures', 'public');
            Setting::updateOrCreate(
                ['key' => 'ppdb_brochure'],
                ['value' => $path]
            );
        }

        // Update title and description
        if ($request->filled('ppdb_brochure_title')) {
            Setting::updateOrCreate(
                ['key' => 'ppdb_brochure_title'],
                ['value' => $request->ppdb_brochure_title]
            );
        }

        if ($request->filled('ppdb_brochure_description')) {
            Setting::updateOrCreate(
                ['key' => 'ppdb_brochure_description'],
                ['value' => $request->ppdb_brochure_description]
            );
        }

        return redirect()->back()->with('success', 'Brosur PPDB berhasil diperbarui!');
    }

    public function deletePpdbBrochure()
    {
        $brochure = Setting::where('key', 'ppdb_brochure')->first();
        
        if ($brochure && $brochure->value && Storage::disk('public')->exists($brochure->value)) {
            Storage::disk('public')->delete($brochure->value);
            $brochure->delete();
        }

        return redirect()->back()->with('success', 'Brosur PPDB berhasil dihapus!');
    }
}
