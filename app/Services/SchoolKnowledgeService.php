<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Competency;
use App\Models\GalleryAlbum;
use App\Models\IndustryPartner;
use App\Models\Menu;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\PpdbSetting;
use App\Models\Setting;
use App\Models\StaffProfile;
use App\Models\Statistic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Mengumpulkan SELURUH isi website sekolah menjadi konteks teks yang bisa dibaca AI.
 *
 * Terdiri dari dua bagian:
 * 1. baseContext() - ringkasan seluruh isi web (profil, kontak, jurusan, guru,
 *    SPMB, galeri, berita terbaru, halaman, menu navigasi). Di-cache agar tidak
 *    query berulang setiap pesan masuk.
 * 2. retrieve() - pencarian dinamis sesuai pertanyaan user (berita, halaman,
 *    jurusan, guru, album galeri) supaya AI bisa menjawab pertanyaan spesifik
 *    dengan data asli dari database, bukan mengarang.
 */
class SchoolKnowledgeService
{
    /** Kunci & durasi cache konteks statis (detik). */
    private const CACHE_KEY = 'chatbot_knowledge_base';
    private const CACHE_TTL = 600;

    /** Kata umum bahasa Indonesia yang diabaikan saat mengambil kata kunci. */
    private const STOPWORDS = [
        'yang', 'untuk', 'dengan', 'adalah', 'apakah', 'siapa', 'kapan', 'dimana',
        'dari', 'atau', 'saya', 'kamu', 'anda', 'kami', 'itu', 'ini', 'bisa',
        'boleh', 'tolong', 'mohon', 'gimana', 'bagaimana', 'berapa', 'mau',
        'ingin', 'tahu', 'info', 'informasi', 'tentang', 'punya', 'sekolah',
        'bina', 'mandiri', 'bekasi', 'halo', 'apa', 'ada', 'kah', 'nya', 'dan',
        'ada', 'aja', 'saja', 'juga', 'pada', 'oleh', 'akan', 'sudah', 'belum',
        'mana', 'kalau', 'jika', 'nih', 'dong', 'sih', 'mas', 'bang', 'min',
        'kak', 'pak', 'ibu', 'buat', 'lagi', 'gak', 'nggak', 'tidak', 'iya',
    ];

    /**
     * Sinonim / kepanjangan singkatan supaya pencarian tetap menemukan konten
     * walau penanya memakai istilah pendek.
     *
     * @var array<string, array<int, string>>
     */
    private const SYNONYMS = [
        'tkj' => ['teknik komputer', 'jaringan'],
        'rpl' => ['rekayasa perangkat lunak'],
        'tsm' => ['sepeda motor'],
        'tkro' => ['kendaraan ringan'],
        'tkr' => ['kendaraan ringan'],
        'otomotif' => ['kendaraan', 'sepeda motor'],
        'ppdb' => ['spmb', 'pendaftaran'],
        'spmb' => ['ppdb', 'pendaftaran'],
        'daftar' => ['pendaftaran'],
        'kepsek' => ['kepala sekolah'],
        'ekskul' => ['ekstrakurikuler'],
        'pkl' => ['praktik kerja', 'prakerin'],
        'prakerin' => ['praktik kerja'],
        'ukk' => ['uji kompetensi'],
        'mpls' => ['pengenalan lingkungan sekolah'],
        'guru' => ['pengajar'],
        'biaya' => ['spp', 'pembayaran'],
        'lulusan' => ['alumni'],
        'lomba' => ['juara', 'prestasi'],
        'prestasi' => ['juara'],
    ];

    /**
     * Ringkasan lengkap isi website (di-cache).
     */
    public function baseContext(): string
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, fn () => $this->buildBaseContext());
    }

    /**
     * Hapus cache konteks, dipakai bila konten website baru saja berubah.
     */
    public function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Cari konten website yang relevan dengan pertanyaan user.
     * Hasilnya ditempel ke prompt sebagai data pendukung.
     */
    public function retrieve(string $question): string
    {
        $keywords = $this->keywords($question);

        if (empty($keywords)) {
            return '';
        }

        $blocks = array_filter([
            $this->searchNews($keywords),
            $this->searchPages($keywords),
            $this->searchCompetencies($keywords),
            $this->searchStaff($keywords),
            $this->searchGallery($keywords),
        ]);

        if (empty($blocks)) {
            return '';
        }

        return "=== DATA PENDUKUNG DARI ISI WEBSITE (relevan dengan pertanyaan) ===\n"
            . implode("\n\n", $blocks);
    }

    /* ------------------------------------------------------------------ */
    /* Konteks statis                                                      */
    /* ------------------------------------------------------------------ */

    private function buildBaseContext(): string
    {
        $sections = [
            $this->sectionIdentity(),
            $this->sectionVisionMission(),
            $this->sectionPrincipal(),
            $this->sectionStatistics(),
            $this->sectionCompetencies(),
            $this->sectionStaff(),
            $this->sectionPpdb(),
            $this->sectionPartners(),
            $this->sectionAnnouncements(),
            $this->sectionNews(),
            $this->sectionPages(),
            $this->sectionGallery(),
            $this->sectionNavigation(),
        ];

        return implode("\n\n", array_filter($sections));
    }

    private function sectionIdentity(): string
    {
        $school = config('school');

        $name = $this->setting('site_name', $school['name']);
        $tagline = $this->setting('site_tagline', $school['tagline']);
        $address = $this->setting('contact_address', $school['address']);
        $phone = $this->setting('contact_phone', $school['phone']);
        $email = $this->setting('contact_email', $school['email']);
        $whatsapp = $this->setting('contact_whatsapp', $school['whatsapp']);
        $website = $school['website'];

        $hours = [];
        foreach ([
            'Senin-Jumat' => 'contact_office_hours_weekday',
            'Sabtu' => 'contact_office_hours_saturday',
            'Minggu' => 'contact_office_hours_sunday',
        ] as $label => $key) {
            $value = trim((string) $this->setting($key, ''));
            if ($value !== '') {
                $hours[] = $label . ': ' . $value;
            }
        }
        $hoursText = $hours
            ? implode(' | ', $hours)
            : (trim((string) $this->setting('contact_office_hours', '')) ?: 'Belum tercantum di website, arahkan menghubungi kontak resmi.');

        $socials = [];
        foreach (['facebook', 'instagram', 'youtube', 'tiktok', 'twitter', 'linkedin'] as $platform) {
            $value = trim((string) $this->setting('social_' . $platform, ''));
            if ($value !== '') {
                $socials[] = ucfirst($platform) . ': ' . $value;
            }
        }
        $socialText = $socials ? implode(', ', $socials) : 'Belum ada akun media sosial yang terdaftar di website.';

        $overview = $this->plain($this->setting('school_overview', ''), 800);
        $overviewText = $overview !== '' ? "\nSekilas sekolah: " . $overview : '';

        return "=== IDENTITAS & KONTAK SEKOLAH ===\n"
            . "Nama: {$name}\n"
            . "Slogan: {$tagline}\n"
            . "Berdiri sejak: {$school['founded_year']}\n"
            . "Alamat: {$address}\n"
            . "Telepon: {$phone}\n"
            . "Email: {$email}\n"
            . "WhatsApp: {$whatsapp}\n"
            . "Website: {$website}\n"
            . "Jam layanan: {$hoursText}\n"
            . "Media sosial: {$socialText}"
            . $overviewText;
    }

    private function sectionVisionMission(): string
    {
        $vision = $this->plain($this->setting('about_vision', ''), 700);
        $mission = $this->plain($this->setting('about_mission', ''), 900);

        if ($vision === '' && $mission === '') {
            return '';
        }

        $text = '=== VISI & MISI ===';
        if ($vision !== '') {
            $text .= "\nVisi: " . $vision;
        }
        if ($mission !== '') {
            $text .= "\nMisi: " . $mission;
        }
        $text .= "\nHalaman lengkap: " . $this->url('info.about');

        return $text;
    }

    private function sectionPrincipal(): string
    {
        $name = trim((string) $this->setting('principal_name', ''));
        $message = $this->plain($this->setting('principal_message', ''), 600);

        if ($name === '' && $message === '') {
            return '';
        }

        $text = '=== KEPALA SEKOLAH ===';
        if ($name !== '') {
            $text .= "\nNama kepala sekolah: {$name}";
        }
        if ($message !== '') {
            $text .= "\nRingkasan sambutan: {$message}";
        }
        $text .= "\nHalaman sambutan: " . $this->url('info.principal-message');

        return $text;
    }

    private function sectionStatistics(): string
    {
        $stats = $this->safe(fn () => Statistic::active()->get()
            ->map(fn ($s) => "{$s->label}: {$s->value}{$s->suffix}")
            ->implode(', '), '');

        if ($stats === '') {
            $facts = config('school.facts');
            $stats = "Siswa aktif: {$facts['active_students']}, Guru: {$facts['teachers']}, Program keahlian: {$facts['programs']}";
        }

        $placement = trim((string) $this->setting('bkk_placement_rate', ''));
        if ($placement !== '') {
            $stats .= ", Tingkat penyaluran kerja (BKK): {$placement}";
        }

        return "=== STATISTIK RESMI ===\n" . $stats;
    }

    private function sectionCompetencies(): string
    {
        $items = $this->safe(fn () => Competency::active()->ordered()->get(), collect());

        if ($items->isEmpty()) {
            return '';
        }

        $lines = $items->map(function ($competency) {
            $line = '- ' . $competency->name
                . ' (link: ' . $this->url('public.competencies.show', ['competency' => $competency->slug]) . ')';

            $description = $this->plain($competency->description, 350);
            if ($description !== '') {
                $line .= "\n  Deskripsi: " . $description;
            }
            if (! empty($competency->head_of_program_name)) {
                $line .= "\n  Kepala program: " . $competency->head_of_program_name;
            }

            return $line;
        })->implode("\n");

        return '=== PROGRAM KEAHLIAN / JURUSAN (' . $items->count() . " jurusan) ===\n"
            . $lines
            . "\nDaftar semua jurusan: " . $this->url('public.competencies.index');
    }

    private function sectionStaff(): string
    {
        $staff = $this->safe(fn () => StaffProfile::active()->ordered()->get(), collect());

        if ($staff->isEmpty()) {
            return '';
        }

        $byCategory = $staff->groupBy(fn ($item) => $item->category ?: 'Lainnya')
            ->map(fn ($group, $category) => $category . ': ' . $group->count() . ' orang')
            ->implode(', ');

        $highlight = $staff->take(40)->map(function ($item) {
            $parts = [$item->display_name ?: $item->name];
            if (! empty($item->position)) {
                $parts[] = $item->position;
            }
            if (! empty($item->subjects)) {
                $parts[] = 'mapel: ' . Str::limit((string) $item->subjects, 80);
            }
            if (! empty($item->jurusan)) {
                $parts[] = 'jurusan: ' . $item->jurusan;
            }

            return '- ' . implode(' | ', $parts);
        })->implode("\n");

        $remaining = $staff->count() - 40;

        return '=== GURU & KARYAWAN (total ' . $staff->count() . " profil terpublikasi) ===\n"
            . "Rekap: {$byCategory}\n"
            . $highlight
            . ($remaining > 0 ? "\n- (dan {$remaining} profil lainnya, lihat halaman profil guru & karyawan)" : '')
            . "\nHalaman profil guru & karyawan: " . $this->url('public.staff-profiles.index');
    }

    private function sectionPpdb(): string
    {
        $ppdb = $this->safe(fn () => PpdbSetting::current(), null);

        $text = '=== SPMB / PPDB (PENERIMAAN PESERTA DIDIK BARU) ===';

        if ($ppdb) {
            $status = $ppdb->isOpen() ? 'SEDANG DIBUKA' : ($ppdb->isUpcoming() ? 'BELUM DIBUKA' : 'SUDAH DITUTUP');
            $text .= "\nStatus pendaftaran saat ini: {$status}";
            $text .= "\nPeriode resmi: {$ppdb->formatted_period}";
            if (! empty($ppdb->requirements)) {
                $text .= "\nDokumen/persyaratan: " . implode(', ', (array) $ppdb->requirements);
            }
        } else {
            $text .= "\nInformasi periode pendaftaran belum dipublikasikan di website. Arahkan pengguna menghubungi kontak resmi sekolah.";
        }

        $brochureTitle = trim((string) $this->setting('ppdb_brochure_title', ''));
        $brochureDescription = $this->plain($this->setting('ppdb_brochure_description', ''), 300);
        if ($brochureTitle !== '' || $brochureDescription !== '') {
            $text .= "\nBrosur: " . trim($brochureTitle . ' ' . $brochureDescription);
        }

        $text .= "\nHalaman pendaftaran online: " . $this->url('ppdb.register');
        $text .= "\nHalaman cek status pendaftaran: " . $this->url('ppdb.check-status');
        $text .= "\nAlur singkat: calon siswa mengisi formulir online di halaman pendaftaran, lalu menerima nomor pendaftaran yang dipakai untuk mengecek status.";

        return $text;
    }

    private function sectionPartners(): string
    {
        $partners = $this->safe(fn () => IndustryPartner::active()->ordered()->pluck('name'), collect());

        if ($partners->isEmpty()) {
            $partners = collect(config('school.industry_partners', []));
        }

        if ($partners->isEmpty()) {
            return '';
        }

        return '=== MITRA INDUSTRI / DUNIA KERJA (' . $partners->count() . " mitra) ===\n"
            . $partners->implode(', ');
    }

    private function sectionAnnouncements(): string
    {
        $items = $this->safe(fn () => Announcement::active()->ordered()->limit(8)->get(), collect());

        if ($items->isEmpty()) {
            return "=== PENGUMUMAN ===\nTidak ada pengumuman aktif saat ini.";
        }

        return "=== PENGUMUMAN AKTIF ===\n"
            . $items->map(fn ($item) => '- ' . $item->title . ($item->link_url ? ' (' . $item->link_url . ')' : ''))
                ->implode("\n");
    }

    private function sectionNews(): string
    {
        $news = $this->safe(
            fn () => News::published()->with('category')->latest('published_at')->limit(12)->get(),
            collect()
        );

        if ($news->isEmpty()) {
            return '';
        }

        $categories = $this->safe(fn () => NewsCategory::pluck('name')->implode(', '), '');

        $lines = $news->map(function ($item) {
            $date = optional($item->published_at)->translatedFormat('d F Y');
            $meta = array_filter([$date, $item->category ? 'kategori: ' . $item->category->name : null]);

            return '- ' . $item->title
                . ($meta ? ' (' . implode(', ', $meta) . ')' : '')
                . "\n  Ringkasan: " . $this->plain($item->excerpt ?: $item->content, 200)
                . "\n  Link: " . $this->url('public.news.show', ['news' => $item->slug]);
        })->implode("\n");

        return "=== BERITA / ARTIKEL TERBARU ===\n"
            . ($categories !== '' ? "Kategori berita yang tersedia: {$categories}\n" : '')
            . $lines
            . "\nSemua berita: " . $this->url('public.news.index');
    }

    private function sectionPages(): string
    {
        $pages = $this->safe(fn () => Page::published()->get(['title', 'slug', 'meta_description']), collect());

        if ($pages->isEmpty()) {
            return '';
        }

        $lines = $pages->map(function ($page) {
            $line = '- ' . $page->title . ' (link: ' . $this->url('public.pages.show', ['slug' => $page->slug]) . ')';
            if (! empty($page->meta_description)) {
                $line .= "\n  " . $this->plain($page->meta_description, 160);
            }

            return $line;
        })->implode("\n");

        return "=== HALAMAN STATIS DI WEBSITE ===\n" . $lines;
    }

    private function sectionGallery(): string
    {
        $albums = $this->safe(
            fn () => GalleryAlbum::withCount('items')->orderBy('sort_order')->limit(15)->get(),
            collect()
        );

        if ($albums->isEmpty()) {
            return '';
        }

        $lines = $albums->map(fn ($album) => '- ' . $album->name
            . ' (' . $album->items_count . ' foto/video, link: '
            . $this->url('public.gallery.show', ['galleryAlbum' => $album->slug]) . ')')
            ->implode("\n");

        return "=== GALERI KEGIATAN ===\n" . $lines
            . "\nSemua album: " . $this->url('public.gallery.index');
    }

    private function sectionNavigation(): string
    {
        $menus = $this->safe(
            fn () => Menu::active()
                ->parents()
                ->with(['children' => fn ($query) => $query->where('status', 'active')])
                ->orderBy('order')
                ->get(),
            collect()
        );

        $lines = $menus->map(function ($menu) {
            $line = '- ' . $menu->title . ': ' . $menu->full_url;
            foreach ($menu->children as $child) {
                $line .= "\n  - " . $child->title . ': ' . $child->full_url;
            }

            return $line;
        })->implode("\n");

        $fixed = "Halaman penting:\n"
            . '- Beranda: ' . $this->url('home') . "\n"
            . '- Profil sekolah (visi & misi): ' . $this->url('info.about') . "\n"
            . '- Sekilas sekolah: ' . $this->url('info.overview') . "\n"
            . '- Sambutan kepala sekolah: ' . $this->url('info.principal-message') . "\n"
            . '- Kontak & lokasi (tersedia form pesan): ' . $this->url('info.contact') . "\n"
            . '- Program keahlian: ' . $this->url('public.competencies.index') . "\n"
            . '- Berita: ' . $this->url('public.news.index') . "\n"
            . '- Galeri: ' . $this->url('public.gallery.index') . "\n"
            . '- Profil guru & karyawan: ' . $this->url('public.staff-profiles.index') . "\n"
            . '- Pendaftaran SPMB: ' . $this->url('ppdb.register') . "\n"
            . '- Cek status pendaftaran: ' . $this->url('ppdb.check-status') . "\n"
            . '- Pencarian konten website: ' . $this->url('search');

        return "=== STRUKTUR / MENU WEBSITE ===\n"
            . ($lines !== '' ? $lines . "\n" : '')
            . $fixed;
    }

    /* ------------------------------------------------------------------ */
    /* Pencarian dinamis                                                   */
    /* ------------------------------------------------------------------ */

    /**
     * Ambil kata kunci penting dari pertanyaan user, lengkap dengan sinonimnya.
     *
     * @return array<int, string>
     */
    private function keywords(string $question): array
    {
        $clean = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', Str::lower($question));
        $words = preg_split('/\s+/', trim((string) $clean)) ?: [];

        $words = array_values(array_unique(array_filter(
            $words,
            fn ($word) => mb_strlen($word) >= 3 && ! in_array($word, self::STOPWORDS, true)
        )));

        $words = array_slice($words, 0, 6);

        $expanded = $words;
        foreach ($words as $word) {
            foreach (self::SYNONYMS[$word] ?? [] as $synonym) {
                $expanded[] = $synonym;
            }
        }

        return array_slice(array_values(array_unique($expanded)), 0, 12);
    }

    /**
     * Urutkan hasil pencarian berdasarkan seberapa banyak kata kunci yang cocok,
     * dengan bobot lebih besar untuk kecocokan di judul/nama.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  array<int, string>  $keywords
     * @param  array<string, int>  $weights  Nama kolom => bobot
     * @return \Illuminate\Support\Collection
     */
    private function rank($items, array $keywords, array $weights, int $take)
    {
        return $items
            ->map(function ($item) use ($keywords, $weights) {
                $score = 0;

                foreach ($weights as $column => $weight) {
                    $value = Str::lower(strip_tags((string) $item->getAttribute($column)));

                    if ($value === '') {
                        continue;
                    }

                    foreach ($keywords as $keyword) {
                        if (str_contains($value, $keyword)) {
                            $score += $weight;
                        }
                    }
                }

                return ['item' => $item, 'score' => $score];
            })
            ->filter(fn ($row) => $row['score'] > 0)
            ->sortByDesc('score')
            ->take($take)
            ->map(fn ($row) => $row['item'])
            ->values();
    }

    /**
     * Bangun closure "where LIKE" untuk sekumpulan kolom.
     *
     * @param  array<int, string>  $keywords
     * @param  array<int, string>  $columns
     */
    private function likeFilter(array $keywords, array $columns): \Closure
    {
        return function ($query) use ($keywords, $columns) {
            foreach ($keywords as $keyword) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            }
        };
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function searchNews(array $keywords): string
    {
        $candidates = $this->safe(fn () => News::published()
            ->where($this->likeFilter($keywords, ['title', 'excerpt', 'content']))
            ->latest('published_at')
            ->limit(20)
            ->get(), collect());

        $news = $this->rank($candidates, $keywords, ['title' => 5, 'excerpt' => 2, 'content' => 1], 3);

        if ($news->isEmpty()) {
            return '';
        }

        return "[BERITA TERKAIT]\n" . $news->map(function ($item) {
            $date = optional($item->published_at)->translatedFormat('d F Y');
            $body = $this->plain($item->content, 700) ?: $this->plain($item->excerpt, 300);

            return '- ' . $item->title . ($date ? " ({$date})" : '')
                . ($body !== '' ? "\n  Isi: " . $body : '')
                . "\n  Link: " . $this->url('public.news.show', ['news' => $item->slug]);
        })->implode("\n");
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function searchPages(array $keywords): string
    {
        $candidates = $this->safe(fn () => Page::published()
            ->where($this->likeFilter($keywords, ['title', 'content']))
            ->limit(10)
            ->get(), collect());

        $pages = $this->rank($candidates, $keywords, ['title' => 5, 'content' => 1], 2);

        if ($pages->isEmpty()) {
            return '';
        }

        return "[HALAMAN TERKAIT]\n" . $pages->map(function ($page) {
            return '- ' . $page->title
                . "\n  Isi: " . $this->plain($page->content, 900)
                . "\n  Link: " . $this->url('public.pages.show', ['slug' => $page->slug]);
        })->implode("\n");
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function searchCompetencies(array $keywords): string
    {
        $candidates = $this->safe(fn () => Competency::active()
            ->where($this->likeFilter($keywords, ['name', 'description', 'head_of_program_name']))
            ->limit(10)
            ->get(), collect());

        $items = $this->rank($candidates, $keywords, ['name' => 5, 'head_of_program_name' => 3, 'description' => 1], 2);

        if ($items->isEmpty()) {
            return '';
        }

        return "[JURUSAN TERKAIT]\n" . $items->map(function ($competency) {
            $line = '- ' . $competency->name
                . "\n  Deskripsi: " . $this->plain($competency->description, 900);

            if (! empty($competency->head_of_program_name)) {
                $line .= "\n  Kepala program: " . $competency->head_of_program_name;
            }
            if (! empty($competency->head_of_program_message)) {
                $line .= "\n  Sambutan kepala program: " . $this->plain($competency->head_of_program_message, 400);
            }

            return $line . "\n  Link: " . $this->url('public.competencies.show', ['competency' => $competency->slug]);
        })->implode("\n");
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function searchStaff(array $keywords): string
    {
        $candidates = $this->safe(fn () => StaffProfile::active()
            ->where($this->likeFilter($keywords, ['name', 'position', 'subjects', 'jurusan', 'education', 'bio', 'category']))
            ->ordered()
            ->limit(20)
            ->get(), collect());

        $staff = $this->rank(
            $candidates,
            $keywords,
            ['name' => 5, 'position' => 4, 'subjects' => 4, 'jurusan' => 3, 'category' => 2, 'education' => 1, 'bio' => 1],
            5
        );

        if ($staff->isEmpty()) {
            return '';
        }

        return "[GURU/KARYAWAN TERKAIT]\n" . $staff->map(function ($item) {
            $parts = [$item->display_name ?: $item->name];
            if (! empty($item->position)) {
                $parts[] = 'Jabatan: ' . $item->position;
            }
            if (! empty($item->subjects)) {
                $parts[] = 'Mapel: ' . $item->subjects;
            }
            if (! empty($item->jurusan)) {
                $parts[] = 'Jurusan: ' . $item->jurusan;
            }
            if (! empty($item->education)) {
                $parts[] = 'Pendidikan: ' . Str::limit((string) $item->education, 120);
            }

            return '- ' . implode(' | ', $parts)
                . "\n  Link: " . $this->url('public.staff-profiles.show', ['staffProfile' => $item->slug ?: $item->id]);
        })->implode("\n");
    }

    /**
     * @param  array<int, string>  $keywords
     */
    private function searchGallery(array $keywords): string
    {
        $candidates = $this->safe(fn () => GalleryAlbum::withCount('items')
            ->where($this->likeFilter($keywords, ['name', 'description']))
            ->limit(10)
            ->get(), collect());

        $albums = $this->rank($candidates, $keywords, ['name' => 5, 'description' => 1], 2);

        if ($albums->isEmpty()) {
            return '';
        }

        return "[ALBUM GALERI TERKAIT]\n" . $albums->map(function ($album) {
            return '- ' . $album->name . ' (' . $album->items_count . ' item)'
                . (! empty($album->description) ? "\n  " . $this->plain($album->description, 200) : '')
                . "\n  Link: " . $this->url('public.gallery.show', ['galleryAlbum' => $album->slug]);
        })->implode("\n");
    }

    /* ------------------------------------------------------------------ */
    /* Helper                                                              */
    /* ------------------------------------------------------------------ */

    /**
     * Bersihkan HTML dan spasi berlebih, lalu potong sesuai batas karakter.
     */
    private function plain($value, int $limit): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $value)) ?? '');

        return $text === '' ? '' : Str::limit($text, $limit);
    }

    private function setting(string $key, $default = '')
    {
        try {
            $value = Setting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }

        return $value === null ? $default : $value;
    }

    /**
     * Jalankan query dengan aman; bila tabel/model bermasalah, pakai nilai default
     * supaya chatbot tetap menjawab.
     *
     * @template TValue
     *
     * @param  \Closure():TValue  $callback
     * @param  TValue  $default
     * @return TValue
     */
    private function safe(\Closure $callback, $default)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            Log::warning('Chatbot knowledge query gagal: ' . $e->getMessage());

            return $default;
        }
    }

    private function url(string $routeName, array $parameters = []): string
    {
        try {
            return route($routeName, $parameters);
        } catch (\Throwable $e) {
            return (string) config('school.website');
        }
    }
}
