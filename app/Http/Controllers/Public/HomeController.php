<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Competency;
use App\Models\HomeSlider;
use App\Models\IndustryPartner;
use App\Models\News;
use App\Models\PpdbSetting;
use App\Models\Setting;
use App\Models\Statistic;

class HomeController extends Controller
{
    /**
     * Display the conversion-focused homepage.
     */
    public function index()
    {
        $sliders = HomeSlider::active()->ordered()->get();

        // Keep administrative updates out of the achievement/news block.
        $latestNews = News::published()
            ->with(['category', 'author'])
            ->where(function ($query) {
                $query->whereNull('category_id')
                    ->orWhereHas('category', function ($category) {
                        $category->whereNotIn('name', ['Seputar KBM', 'Pengumuman', 'Administrasi']);
                    });
            })
            ->where('title', 'not like', '%absensi%')
            ->where('title', 'not like', '%jadwal%')
            ->where('title', 'not like', '%administrasi%')
            ->latest('published_at')
            ->limit(6)
            ->get();

        $featuredCompetencies = Competency::active()->ordered()->limit(3)->get();
        $statistics = Statistic::active()->get();
        $industryPartners = IndustryPartner::active()->ordered()->get();
        $ppdbSetting = PpdbSetting::current();
        $announcements = Announcement::active()->ordered()->limit(6)->get();

        $brochurePath = trim((string) Setting::get('ppdb_brochure', ''));
        $brochure = $brochurePath ? [
            'url' => asset('storage/' . $brochurePath),
            'title' => Setting::get('ppdb_brochure_title', 'Brosur SPMB'),
            'description' => Setting::get('ppdb_brochure_description', ''),
            'is_image' => (bool) preg_match('/\.(jpe?g|png|gif|webp)$/i', $brochurePath),
        ] : null;

        $testimonials = $this->jsonSetting('homepage_testimonials');
        $programStudentCounts = $this->jsonSetting('program_student_counts');
        $bkkPlacementRate = trim((string) Setting::get('bkk_placement_rate', ''));

        return view('public.home-conversion', [
            'sliders' => $sliders,
            'latestNews' => $latestNews,
            'featuredCompetencies' => $featuredCompetencies,
            'statistics' => $statistics,
            'industryPartners' => $industryPartners,
            'ppdbSetting' => $ppdbSetting,
            'announcements' => $announcements,
            'brochure' => $brochure,
            'testimonials' => $testimonials,
            'programStudentCounts' => $programStudentCounts,
            'bkkPlacementRate' => $bkkPlacementRate,
            'schoolFacts' => config('school.facts', []),
            'foundedYear' => (int) config('school.founded_year', 2000),
            'partnerNames' => config('school.industry_partners', []),
            'experienceYears' => max(0, now()->year - (int) config('school.founded_year', 2000)),
            'contact' => [
                'address' => Setting::get('contact_address', config('school.address')),
                'phone' => Setting::get('contact_phone', config('school.phone')),
                'email' => Setting::get('contact_email', config('school.email')),
                'whatsapp' => preg_replace('/\\D+/', '', (string) Setting::get('contact_whatsapp', config('school.whatsapp'))),
            ],
            'socialLinks' => $this->officialSocialLinks(),
        ]);
    }

    private function jsonSetting(string $key): array
    {
        $value = Setting::get($key, []);
        if (is_array($value)) return $value;

        $decoded = json_decode((string) $value, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function officialSocialLinks(): array
    {
        $definitions = [
            'Facebook' => ['key' => 'social_facebook', 'hosts' => ['facebook.com']],
            'Instagram' => ['key' => 'social_instagram', 'hosts' => ['instagram.com']],
            'YouTube' => ['key' => 'social_youtube', 'hosts' => ['youtube.com', 'youtu.be']],
            'TikTok' => ['key' => 'social_tiktok', 'hosts' => ['tiktok.com']],
            'LinkedIn' => ['key' => 'social_linkedin', 'hosts' => ['linkedin.com']],
        ];

        $links = [];
        $usedUrls = [];
        foreach ($definitions as $label => $definition) {
            $url = trim((string) Setting::get($definition['key'], ''));
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            $host = preg_replace('/^www\\./', '', $host);

            if (!filter_var($url, FILTER_VALIDATE_URL)
                || str_contains($host, 'sekolahkami')
                || !in_array($host, $definition['hosts'], true)
                || in_array($url, $usedUrls, true)) {
                continue;
            }

            $links[] = ['label' => $label, 'url' => $url];
            $usedUrls[] = $url;
        }

        // This channel is linked from the official website homepage.
        if (!collect($links)->contains('label', 'YouTube')) {
            $links[] = ['label' => 'YouTube', 'url' => 'https://www.youtube.com/@smkbinamandiri268'];
        }

        return $links;
    }
}
