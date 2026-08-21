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
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg,ico|max:20480',
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
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
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
        $homepageYoutubeVideo = Setting::get('homepage_youtube_video', 'https://www.youtube.com/watch?v=s5l8HAA2evI');

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
            'socialLinkedin',
            'homepageYoutubeVideo'
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

    /**
     * Update the YouTube video featured on the homepage
     */
    public function updateHomepageYoutubeVideo(Request $request)
    {
        $request->validate([
            'homepage_youtube_video' => [
                'nullable',
                'url',
                'max:255',
                function ($attribute, $value, $fail) {
                    $host = strtolower((string) parse_url($value, PHP_URL_HOST));
                    $host = preg_replace('/^www\./', '', $host);
                    if (!in_array($host, ['youtube.com', 'youtu.be'], true)) {
                        $fail('Link harus berupa URL YouTube yang valid.');
                    }
                },
            ],
        ]);

        Setting::set('homepage_youtube_video', $request->homepage_youtube_video);

        return redirect()->back()->with('success', 'Video YouTube homepage berhasil diperbarui!');
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
            'ppdb_brochure' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:10240',
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

    /**
     * Show about page content management
     */
    public function aboutContent()
    {
        // Hero Section
        $aboutHeroTitle = Setting::get('about_hero_title', 'Tentang SMK Bina Mandiri Bekasi');
        $aboutHeroSubtitle = Setting::get('about_hero_subtitle', 'Membangun Generasi Unggul Melalui Pendidikan Berkualitas');
        $aboutHeroDescription = Setting::get('about_hero_description', 'Pelajari lebih lanjut tentang sejarah, visi, misi, dan komitmen kami dalam memberikan pendidikan terbaik untuk masa depan yang cemerlang');

        // Quick Stats
        $aboutStat1Value = Setting::get('about_stat1_value', '25+');
        $aboutStat1Label = Setting::get('about_stat1_label', 'Tahun Pengalaman');
        $aboutStat2Value = Setting::get('about_stat2_value', '5000+');
        $aboutStat2Label = Setting::get('about_stat2_label', 'Alumni Sukses');
        $aboutStat3Value = Setting::get('about_stat3_value', '100+');
        $aboutStat3Label = Setting::get('about_stat3_label', 'Tenaga Pendidik');
        $aboutStat4Value = Setting::get('about_stat4_value', '15+');
        $aboutStat4Label = Setting::get('about_stat4_label', 'Program Keahlian');

        // Vision & Mission
        $aboutVision = Setting::get('about_vision', 'Menjadi lembaga pendidikan terdepan yang menghasilkan lulusan kompeten, inovatif, dan berkarakter yang siap menghadapi tantangan global serta berkontribusi positif bagi masyarakat.');
        $aboutMission = Setting::get('about_mission', "1. Menyelenggarakan pendidikan berkualitas yang memenuhi standar nasional dan internasional\n2. Mengembangkan kompetensi siswa melalui pendekatan pembelajaran inovatif dan praktis\n3. Membina pengembangan karakter berdasarkan nilai-nilai moral dan etika\n4. Membangun kemitraan dengan industri dan masyarakat untuk hasil pembelajaran yang optimal\n5. Menciptakan lingkungan belajar yang kondusif dan berbasis teknologi");

        // Values
        $aboutValue1Title = Setting::get('about_value1_title', 'Keunggulan');
        $aboutValue1Desc = Setting::get('about_value1_desc', 'Berusaha mencapai standar tertinggi dalam setiap hal yang kami lakukan');
        $aboutValue2Title = Setting::get('about_value2_title', 'Integritas');
        $aboutValue2Desc = Setting::get('about_value2_desc', 'Bertindak dengan kejujuran dan prinsip moral yang kuat');
        $aboutValue3Title = Setting::get('about_value3_title', 'Inovasi');
        $aboutValue3Desc = Setting::get('about_value3_desc', 'Mengembangkan kreativitas dan ide-ide baru dalam pembelajaran');
        $aboutValue4Title = Setting::get('about_value4_title', 'Menghargai');
        $aboutValue4Desc = Setting::get('about_value4_desc', 'Menghargai keberagaman dan memperlakukan setiap orang dengan martabat');

        return view('admin.settings.about-content', compact(
            'aboutHeroTitle', 'aboutHeroSubtitle', 'aboutHeroDescription',
            'aboutStat1Value', 'aboutStat1Label', 'aboutStat2Value', 'aboutStat2Label',
            'aboutStat3Value', 'aboutStat3Label', 'aboutStat4Value', 'aboutStat4Label',
            'aboutVision', 'aboutMission',
            'aboutValue1Title', 'aboutValue1Desc', 'aboutValue2Title', 'aboutValue2Desc',
            'aboutValue3Title', 'aboutValue3Desc', 'aboutValue4Title', 'aboutValue4Desc'
        ));
    }

    /**
     * Update about hero section
     */
    public function updateAboutHero(Request $request)
    {
        $request->validate([
            'about_hero_title' => 'required|string|max:255',
            'about_hero_subtitle' => 'required|string|max:255',
            'about_hero_description' => 'required|string|max:500',
        ]);

        Setting::set('about_hero_title', $request->about_hero_title);
        Setting::set('about_hero_subtitle', $request->about_hero_subtitle);
        Setting::set('about_hero_description', $request->about_hero_description, 'text');

        return redirect()->back()->with('success', 'Hero section berhasil diperbarui!');
    }

    /**
     * Update about statistics
     */
    public function updateAboutStats(Request $request)
    {
        $request->validate([
            'about_stat1_value' => 'required|string|max:50',
            'about_stat1_label' => 'required|string|max:100',
            'about_stat2_value' => 'required|string|max:50',
            'about_stat2_label' => 'required|string|max:100',
            'about_stat3_value' => 'required|string|max:50',
            'about_stat3_label' => 'required|string|max:100',
            'about_stat4_value' => 'required|string|max:50',
            'about_stat4_label' => 'required|string|max:100',
        ]);

        Setting::set('about_stat1_value', $request->about_stat1_value);
        Setting::set('about_stat1_label', $request->about_stat1_label);
        Setting::set('about_stat2_value', $request->about_stat2_value);
        Setting::set('about_stat2_label', $request->about_stat2_label);
        Setting::set('about_stat3_value', $request->about_stat3_value);
        Setting::set('about_stat3_label', $request->about_stat3_label);
        Setting::set('about_stat4_value', $request->about_stat4_value);
        Setting::set('about_stat4_label', $request->about_stat4_label);

        return redirect()->back()->with('success', 'Statistik berhasil diperbarui!');
    }

    /**
     * Update about vision & mission
     */
    public function updateAboutVisionMission(Request $request)
    {
        $request->validate([
            'about_vision' => 'required|string',
            'about_mission' => 'required|string',
        ]);

        Setting::set('about_vision', $request->about_vision, 'text');
        Setting::set('about_mission', $request->about_mission, 'text');

        return redirect()->back()->with('success', 'Visi & Misi berhasil diperbarui!');
    }

    /**
     * Update about values
     */
    public function updateAboutValues(Request $request)
    {
        $request->validate([
            'about_value1_title' => 'required|string|max:100',
            'about_value1_desc' => 'required|string|max:255',
            'about_value2_title' => 'required|string|max:100',
            'about_value2_desc' => 'required|string|max:255',
            'about_value3_title' => 'required|string|max:100',
            'about_value3_desc' => 'required|string|max:255',
            'about_value4_title' => 'required|string|max:100',
            'about_value4_desc' => 'required|string|max:255',
        ]);

        Setting::set('about_value1_title', $request->about_value1_title);
        Setting::set('about_value1_desc', $request->about_value1_desc);
        Setting::set('about_value2_title', $request->about_value2_title);
        Setting::set('about_value2_desc', $request->about_value2_desc);
        Setting::set('about_value3_title', $request->about_value3_title);
        Setting::set('about_value3_desc', $request->about_value3_desc);
        Setting::set('about_value4_title', $request->about_value4_title);
        Setting::set('about_value4_desc', $request->about_value4_desc);

        return redirect()->back()->with('success', 'Nilai-nilai berhasil diperbarui!');
    }

    /**
     * Show contact page content management
     */
    public function contactContent()
    {
        // Hero Section
        $contactPageTitle = Setting::get('contact_page_title', 'Hubungi Kami');
        $contactPageSubtitle = Setting::get('contact_page_subtitle', 'Kami Siap Membantu dan Menjawab Pertanyaan Anda');
        $contactPageDescription = Setting::get('contact_page_description', 'Tim kami siap memberikan informasi lengkap tentang program pendidikan, fasilitas, dan segala hal yang ingin Anda ketahui');
        
        // Office Hours
        $contactOfficeHours = Setting::get('contact_office_hours', '07:00 - 16:00');
        $contactOfficeHoursWeekday = Setting::get('contact_office_hours_weekday', '07:00 - 16:00');
        $contactOfficeHoursSaturday = Setting::get('contact_office_hours_saturday', '07:00 - 12:00');
        $contactOfficeHoursSunday = Setting::get('contact_office_hours_sunday', 'Tutup');
        
        // Google Maps
        $contactMapEmbed = Setting::get('contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.239246932022!2d106.95795700000001!3d-6.2321594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698dc327deb0c1%3A0x23448146f6e2f463!2sSMK%20BINA%20MANDIRI!5e0!3m2!1sid!2sid!4v1760448328414!5m2!1sid!2sid');

        return view('admin.settings.contact-content', compact(
            'contactPageTitle', 'contactPageSubtitle', 'contactPageDescription',
            'contactOfficeHours', 'contactOfficeHoursWeekday', 'contactOfficeHoursSaturday', 'contactOfficeHoursSunday',
            'contactMapEmbed'
        ));
    }

    /**
     * Update contact page content
     */
    public function updateContactContent(Request $request)
    {
        $request->validate([
            'contact_page_title' => 'required|string|max:255',
            'contact_page_subtitle' => 'required|string|max:255',
            'contact_page_description' => 'required|string|max:500',
            'contact_office_hours' => 'required|string|max:50',
            'contact_office_hours_weekday' => 'required|string|max:50',
            'contact_office_hours_saturday' => 'required|string|max:50',
            'contact_office_hours_sunday' => 'required|string|max:50',
            'contact_map_embed' => 'nullable|string|max:2000',
        ]);

        Setting::set('contact_page_title', $request->contact_page_title);
        Setting::set('contact_page_subtitle', $request->contact_page_subtitle);
        Setting::set('contact_page_description', $request->contact_page_description, 'text');
        Setting::set('contact_office_hours', $request->contact_office_hours);
        Setting::set('contact_office_hours_weekday', $request->contact_office_hours_weekday);
        Setting::set('contact_office_hours_saturday', $request->contact_office_hours_saturday);
        Setting::set('contact_office_hours_sunday', $request->contact_office_hours_sunday);
        Setting::set('contact_map_embed', $request->contact_map_embed, 'text');

        return redirect()->back()->with('success', 'Konten halaman kontak berhasil diperbarui!');
    }
}
