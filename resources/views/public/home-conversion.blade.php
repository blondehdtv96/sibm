@extends('layouts.public-tailwind')

@section('title', 'SMK Bina Mandiri Kota Bekasi | SPMB 2026')
@section('description', 'SMK Bina Mandiri Kota Bekasi dengan 3 program keahlian: Teknik Kendaraan Ringan, Teknik Sepeda Motor, dan Teknik Komputer & Jaringan. Kenali sekolah dan informasi SPMB 2026.')
@section('keywords', 'SMK Bina Mandiri Kota Bekasi, SPMB 2026, SMK Bekasi, Teknik Kendaraan Ringan, Teknik Sepeda Motor, Teknik Komputer Jaringan')
@section('og_title', 'SMK Bina Mandiri Kota Bekasi | SPMB 2026')
@section('og_description', 'Kenali program keahlian, pembelajaran praktik, mitra industri, dan informasi SPMB SMK Bina Mandiri Kota Bekasi.')

@php
    $heroImage = $sliders->first()?->image_path;

    // CMS bodies are rich text: strip_tags alone leaves entities such as &nbsp;
    // behind, which Blade then escapes and prints literally. Decode first, then
    // collapse the resulting whitespace (non-breaking spaces included).
    $plainText = function ($value): string {
        $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xC2\xA0", ' ', $text);
        return trim(preg_replace('/\s+/u', ' ', $text));
    };

    $programFallbacks = [
        ['name' => 'Teknik Kendaraan Ringan', 'description' => 'Pembelajaran keahlian kendaraan ringan berbasis praktik.', 'slug' => null],
        ['name' => 'Teknik Sepeda Motor', 'description' => 'Pembelajaran perawatan dan teknologi sepeda motor berbasis praktik.', 'slug' => null],
        ['name' => 'Teknik Komputer & Jaringan', 'description' => 'Pembelajaran komputer, jaringan, dan teknologi informasi.', 'slug' => null],
    ];
    $programs = $featuredCompetencies->count() > 0
        ? $featuredCompetencies->map(fn ($program) => [
            'name' => $program->name,
            'description' => Str::limit($plainText($program->description), 150),
            'slug' => $program->slug,
            'image' => $program->image,
            'student_count' => $programStudentCounts[$program->slug] ?? null,
        ])->values()
        : collect($programFallbacks);

    // Pick a Heroicon that matches the program name, so each card stays
    // recognisable even when the program has no logo uploaded yet.
    $programIcon = function (string $name): string {
        $name = Str::lower($name);
        return match (true) {
            Str::contains($name, ['komputer', 'jaringan', 'tkj', 'informatika', 'perangkat lunak', 'rpl']) => 'computer-desktop',
            Str::contains($name, ['sepeda motor', 'tsm']) => 'cog-6-tooth',
            Str::contains($name, ['kendaraan', 'otomotif', 'tkr', 'mobil']) => 'truck',
            Str::contains($name, ['akuntansi', 'keuangan', 'perbankan']) => 'banknotes',
            Str::contains($name, ['bisnis', 'pemasaran', 'manajemen', 'perkantoran']) => 'presentation-chart-line',
            default => 'wrench-screwdriver',
        };
    };

    // Statistics come from the CMS when the school has published them,
    // otherwise fall back to the verified facts in config/school.php.
    $statIcon = function (string $label): string {
        $label = Str::lower($label);
        return match (true) {
            Str::contains($label, ['siswa', 'murid', 'peserta didik']) => 'user-group',
            Str::contains($label, ['guru', 'pendidik', 'pengajar', 'tenaga']) => 'academic-cap',
            Str::contains($label, ['program', 'jurusan', 'keahlian', 'kompetensi']) => 'squares-2x2',
            Str::contains($label, ['mitra', 'industri', 'perusahaan']) => 'briefcase',
            Str::contains($label, ['alumni', 'lulus']) => 'rocket-launch',
            Str::contains($label, ['prestasi', 'juara', 'penghargaan']) => 'trophy',
            Str::contains($label, ['tahun', 'berdiri', 'pengalaman']) => 'flag',
            Str::contains($label, ['ruang', 'lab', 'fasilitas', 'kelas']) => 'beaker',
            default => 'check-badge',
        };
    };

    // Split a displayed figure into the parts the count-up animation needs:
    // "1.400+" becomes prefix "", number 1400, suffix "+".
    $parseStat = function (string $display): array {
        $display = trim($display);
        $blank = ['prefix' => $display, 'number' => null, 'suffix' => '', 'decimals' => 0, 'animate' => false];

        if (!preg_match('/^(\D*)([\d.,]*\d)(.*)$/u', $display, $matches)) {
            return $blank;
        }

        // Indonesian notation: dot groups thousands, comma marks decimals.
        $normalised = str_replace(',', '.', str_replace('.', '', $matches[2]));
        if (!is_numeric($normalised)) {
            return $blank;
        }

        $decimals = str_contains($normalised, '.') ? strlen(Str::after($normalised, '.')) : 0;

        return [
            'prefix' => $matches[1],
            'number' => (float) $normalised,
            'suffix' => $matches[3],
            'decimals' => $decimals,
            // A bare year reads oddly when it counts up from zero.
            'animate' => !($matches[1] === '' && $matches[3] === '' && preg_match('/^(19|20)\d{2}$/', $matches[2])),
        ];
    };

    $rawStats = $statistics->count() > 0
        ? $statistics->map(fn ($stat) => [
            'display' => trim($stat->value . ($stat->suffix ?? '')),
            'label' => $stat->label,
            'icon' => $statIcon((string) $stat->label),
        ])->values()->all()
        : [
            ['display' => $schoolFacts['active_students'] ?? '1400+', 'label' => 'Siswa Aktif', 'icon' => 'user-group'],
            ['display' => $schoolFacts['teachers'] ?? '65', 'label' => 'Guru & Tenaga Pendidik', 'icon' => 'academic-cap'],
            ['display' => $schoolFacts['programs'] ?? '3', 'label' => 'Program Keahlian', 'icon' => 'squares-2x2'],
            ['display' => (string) $foundedYear, 'label' => 'Berdiri Sejak', 'icon' => 'flag'],
        ];

    $statCards = array_map(fn ($stat) => $stat + $parseStat($stat['display']), $rawStats);

    // The SPMB status band only states what the CMS record actually says, so no
    // schedule is claimed when the school has not published a period yet.
    $spmbState = 'unknown';
    if ($ppdbSetting) {
        $spmbState = $ppdbSetting->isOpen()
            ? 'open'
            : ($ppdbSetting->isUpcoming() ? 'upcoming' : ($ppdbSetting->isClosed() ? 'closed' : 'unknown'));
    }
    $spmbRequirements = collect($ppdbSetting?->requirements ?? [])
        ->map(fn ($item) => trim((string) $item))
        ->filter()
        ->values();

    $registrationSteps = [
        ['icon' => 'pencil-square', 'title' => 'Isi formulir pendaftaran', 'description' => 'Lengkapi data calon siswa pada formulir SPMB online melalui website resmi sekolah.'],
        ['icon' => 'document-text', 'title' => 'Siapkan dokumen', 'description' => 'Siapkan dokumen persyaratan sesuai ketentuan sekolah untuk proses verifikasi.'],
        ['icon' => 'clipboard-document-check', 'title' => 'Verifikasi sekolah', 'description' => 'Panitia SPMB memeriksa kelengkapan data dan dokumen yang Anda kirimkan.'],
        ['icon' => 'check-badge', 'title' => 'Cek status & daftar ulang', 'description' => 'Pantau status pendaftaran melalui halaman cek status, lalu lakukan daftar ulang di sekolah.'],
    ];

    $advantages = [
        ['icon' => 'wrench-screwdriver', 'title' => 'Belajar berbasis praktik', 'description' => 'Siswa mengembangkan kompetensi melalui pembelajaran kejuruan dan pengalaman praktik yang relevan dengan dunia kerja.'],
        ['icon' => 'academic-cap', 'title' => 'Didampingi ' . ($schoolFacts['teachers'] ?? '65') . ' guru', 'description' => 'Tenaga pendidik mendampingi proses belajar dengan fokus pada penguasaan kompetensi dan pembentukan karakter.'],
        ['icon' => 'briefcase', 'title' => 'Terhubung dengan industri', 'description' => 'Kemitraan dengan institusi industri membuka konteks belajar dan wawasan nyata tentang dunia kerja.'],
        ['icon' => 'trophy', 'title' => 'Karakter dan prestasi', 'description' => 'Pendidikan diarahkan untuk membangun siswa yang berkarakter, percaya diri, dan terus berprestasi.'],
    ];

    $faqItems = [
        ['question' => 'Bagaimana cara mendaftar SPMB 2026?', 'answer' => 'Buka halaman pendaftaran SPMB melalui tombol Daftar SPMB. Ikuti formulir dan petunjuk yang ditampilkan. Jika membutuhkan bantuan, hubungi sekolah melalui kontak resmi.'],
        ['question' => 'Kapan jadwal SPMB dibuka?', 'answer' => $ppdbSetting ? 'Periode pendaftaran: ' . $ppdbSetting->registration_start->translatedFormat('d F Y') . ' sampai ' . $ppdbSetting->registration_end->translatedFormat('d F Y') . '.' : 'Jadwal SPMB belum dipublikasikan. Silakan hubungi sekolah untuk mendapatkan informasi terbaru.'],
        ['question' => 'Program keahlian apa saja yang tersedia?', 'answer' => 'SMK Bina Mandiri Kota Bekasi membuka ' . $programs->count() . ' program keahlian: ' . $programs->pluck('name')->implode(', ') . '. Rincian setiap program dapat dibaca pada halaman Program Keahlian.'],
        ['question' => 'Berapa biaya pendaftaran dan pendidikan?', 'answer' => 'Rincian biaya dapat berubah sesuai kebijakan sekolah. Silakan konfirmasi langsung melalui WhatsApp atau telepon resmi agar memperoleh informasi yang tepat.'],
        ['question' => 'Bagaimana cara mengecek status pendaftaran saya?', 'answer' => 'Gunakan halaman Cek Status SPMB dan masukkan nomor pendaftaran yang Anda terima setelah mengirim formulir.'],
        ['question' => 'Di mana lokasi SMK Bina Mandiri Kota Bekasi?', 'answer' => !empty($contact['address']) ? 'Sekolah berlokasi di ' . $contact['address'] . '.' : 'Alamat lengkap sekolah tersedia pada halaman Kontak.'],
    ];

    // Official Instagram: managed via Admin > Settings > Contact & Social (social_instagram key).
    $instagramUrl = trim((string) setting('social_instagram', 'https://www.instagram.com/smkbinamandiri_bekasi.official/'));
    $instagramHandle = null;
    if ($instagramUrl) {
        $instagramPath = trim((string) parse_url($instagramUrl, PHP_URL_PATH), '/');
        $instagramHandle = $instagramPath ? '@' . rawurldecode($instagramPath) : null;
    }

    // Homepage YouTube video: managed via Admin > Settings > Contact & Social (homepage_youtube_video key).
    $youtubeVideoUrl = trim((string) setting('homepage_youtube_video', 'https://www.youtube.com/watch?v=s5l8HAA2evI'));
    $youtubeVideoId = null;
    if ($youtubeVideoUrl) {
        $ytHost = strtolower((string) parse_url($youtubeVideoUrl, PHP_URL_HOST));
        $ytHost = preg_replace('/^www\./', '', $ytHost);
        if ($ytHost === 'youtu.be') {
            $youtubeVideoId = trim((string) parse_url($youtubeVideoUrl, PHP_URL_PATH), '/');
        } elseif (in_array($ytHost, ['youtube.com', 'm.youtube.com'], true)) {
            parse_str((string) parse_url($youtubeVideoUrl, PHP_URL_QUERY), $ytQuery);
            if (!empty($ytQuery['v'])) {
                $youtubeVideoId = $ytQuery['v'];
            } else {
                $ytPath = trim((string) parse_url($youtubeVideoUrl, PHP_URL_PATH), '/');
                if (Str::startsWith($ytPath, 'embed/')) {
                    $youtubeVideoId = Str::after($ytPath, 'embed/');
                } elseif (Str::startsWith($ytPath, 'shorts/')) {
                    $youtubeVideoId = Str::after($ytPath, 'shorts/');
                }
            }
        }
        $youtubeVideoId = $youtubeVideoId ? preg_replace('/[^A-Za-z0-9_-]/', '', $youtubeVideoId) : null;
    }

    $featuredNews = $latestNews->first();
    $secondaryNews = $latestNews->skip(1)->take(4);
    // Some articles are image-only, so the summary can legitimately be empty.
    $featuredSummary = $featuredNews ? Str::limit($plainText($featuredNews->excerpt ?? $featuredNews->content), 180) : '';
@endphp

@section('og_image', $heroImage ? asset('storage/' . $heroImage) : asset('storage/' . setting('site_logo', 'images/logo-default.png')))

@section('content')
<div class="homepage-conversion bg-white text-slate-900">

    <!-- 1. YouTube video hero; image slider remains as a fallback -->
    @if($youtubeVideoId)
        <section class="relative overflow-hidden bg-slate-950" aria-labelledby="homepage-title">
            <h1 id="homepage-title" class="sr-only">SMK Bina Mandiri Kota Bekasi</h1>
            <div class="relative mx-auto aspect-video w-full max-w-[1920px] overflow-hidden bg-slate-950">
                <iframe
                    class="pointer-events-none absolute inset-0 block h-full w-full border-0"
                    src="https://www.youtube-nocookie.com/embed/{{ $youtubeVideoId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeVideoId }}&controls=0&rel=0&modestbranding=1&playsinline=1&disablekb=1"
                    title="Video Profil SMK Bina Mandiri Kota Bekasi"
                    allow="autoplay; encrypted-media; picture-in-picture"
                    referrerpolicy="strict-origin-when-cross-origin"
                    loading="eager"
                    tabindex="-1"
                ></iframe>
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-slate-950/10" aria-hidden="true"></div>
            </div>
        </section>
    @elseif($sliders->count() > 0)
        <section class="relative overflow-hidden bg-white" aria-labelledby="homepage-title">
            <h1 id="homepage-title" class="sr-only">SMK Bina Mandiri Kota Bekasi</h1>
            <div class="swiper homepage-hero-swiper w-full">
                <div class="swiper-wrapper items-start">
                    @foreach($sliders as $index => $slider)
                        <div class="swiper-slide bg-white">
                            @if($slider->image_path)
                                <img
                                    src="{{ $slider->image_url }}"
                                    alt="{{ $slider->title ?: 'Kegiatan SMK Bina Mandiri Kota Bekasi' }}"
                                    class="block h-auto w-full object-contain"
                                    width="1920"
                                    height="1080"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    @if($index === 0) fetchpriority="high" @endif
                                >
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($sliders->count() > 1)
                    <button type="button" class="homepage-hero-prev absolute left-2 top-1/2 z-20 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-slate-950/45 text-white shadow-lg backdrop-blur-sm transition hover:bg-slate-950/65 sm:flex lg:left-5 lg:h-12 lg:w-12" aria-label="Slide sebelumnya">←</button>
                    <button type="button" class="homepage-hero-next absolute right-2 top-1/2 z-20 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-slate-950/45 text-white shadow-lg backdrop-blur-sm transition hover:bg-slate-950/65 sm:flex lg:right-5 lg:h-12 lg:w-12" aria-label="Slide berikutnya">→</button>
                    <div class="homepage-hero-pagination absolute bottom-3 left-1/2 z-20 -translate-x-1/2 sm:bottom-5"></div>
                @endif
            </div>
        </section>
    @endif

    {{-- 2. Running text: managed via Admin > Pengaturan > Konten Sekolah --}}
    @if($runningText['enabled'])
        <section class="relative z-30 bg-brand-900 text-white" aria-label="Informasi terbaru sekolah">
            <div class="flex items-stretch">
                <p class="relative z-10 flex shrink-0 items-center gap-2 bg-brand-600 px-4 py-3 text-xs font-bold uppercase tracking-[.14em] sm:px-6 sm:text-sm">
                    <x-icon name="megaphone" class="h-4 w-4" />
                    <span class="hidden sm:inline">Info Terbaru</span>
                </p>

                {{-- The track is duplicated by script until it is wider than the rail,
                     so the loop never shows a gap. Without JS the first copy simply
                     sits still and stays readable. --}}
                <div class="marquee relative min-w-0 flex-1 overflow-hidden" data-marquee style="--marquee-duration: {{ $runningText['duration'] }}s">
                    <ul class="marquee__track" data-marquee-track>
                        <li class="marquee__group flex shrink-0 items-center">
                            @foreach($runningText['items'] as $item)
                                <span class="flex items-center whitespace-nowrap py-3 text-sm">
                                    <span class="mx-3 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-400 sm:mx-4" aria-hidden="true"></span>
                                    @if($item['url'])
                                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-white underline-offset-4 transition hover:text-brand-200 hover:underline focus-visible:underline">{{ $item['label'] }}</a>
                                    @else
                                        <span class="text-brand-50">{{ $item['label'] }}</span>
                                    @endif
                                </span>
                            @endforeach
                        </li>
                    </ul>
                    <div class="pointer-events-none absolute inset-y-0 right-0 w-12 bg-gradient-to-l from-brand-900 to-transparent" aria-hidden="true"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- 3. Verified school facts --}}
    <section class="relative z-20 bg-slate-50 pb-12 pt-6 sm:pb-16 sm:pt-0" aria-labelledby="facts-title">
        {{-- flow-root keeps the panel's negative margin from collapsing into the
             section, so only the panel lifts over the hero and the slate
             background stays put. With the running text present that strip is
             the transition instead, so the lift is dropped. --}}
        <div class="mx-auto flow-root max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 id="facts-title" class="sr-only">Fakta SMK Bina Mandiri Kota Bekasi</h2>

            {{-- gap-px over a slate background draws hairline rules between cells
                 in both the 2-column and 4-column layouts. --}}
            <div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 shadow-card lg:grid-cols-4 {{ $runningText['enabled'] ? 'sm:mt-10' : 'sm:-mt-16' }}">
                @foreach($statCards as $index => $stat)
                    <div class="stat-cell group relative overflow-hidden bg-white px-5 py-6 sm:px-7 sm:py-8" data-reveal style="--reveal-delay: {{ $index * 90 }}ms">
                        <x-icon
                            :name="$stat['icon']"
                            class="pointer-events-none absolute right-4 top-4 h-9 w-9 text-brand-100 transition duration-500 group-hover:-translate-y-0.5 group-hover:text-brand-300 sm:right-5 sm:top-5 sm:h-11 sm:w-11"
                            stroke="1.25"
                        />

                        <p class="relative flex items-baseline font-black leading-none tracking-tight text-brand-900">
                            @if($stat['prefix'] !== '' && $stat['number'] !== null)
                                <span class="text-2xl text-brand-500 sm:text-3xl">{{ $stat['prefix'] }}</span>
                            @endif
                            <span
                                class="stat-number text-3xl sm:text-4xl"
                                @if($stat['animate'])
                                    data-count-to="{{ $stat['number'] }}"
                                    data-count-decimals="{{ $stat['decimals'] }}"
                                @endif
                            >{{ $stat['animate'] ? number_format($stat['number'], $stat['decimals'], ',', '.') : $stat['display'] }}</span>
                            @if($stat['suffix'] !== '')
                                <span class="text-2xl text-brand-500 sm:text-3xl">{{ $stat['suffix'] }}</span>
                            @endif
                        </p>

                        <span class="stat-rule relative mt-4 block h-[3px] w-10 origin-left rounded-full bg-brand-500 transition-[width] duration-500 group-hover:w-16" aria-hidden="true"></span>

                        <p class="relative mt-3 text-xs font-bold uppercase leading-snug tracking-[.1em] text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. SPMB status band: wording follows the published registration period --}}
    <section id="spmb" class="bg-slate-50 pb-16 sm:pb-20" aria-labelledby="spmb-status-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-brand-900 px-6 py-10 text-white shadow-card-hover sm:px-10 sm:py-12">
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-500/25 blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-28 -left-20 h-64 w-64 rounded-full bg-brand-400/15 blur-3xl" aria-hidden="true"></div>

                <div class="relative grid gap-8 lg:grid-cols-[1.4fr_1fr] lg:items-center">
                    <div>
                        @if($spmbState === 'open')
                            <p class="inline-flex items-center gap-2 rounded-full bg-emerald-400/15 px-3 py-1.5 text-xs font-bold uppercase tracking-[.16em] text-emerald-300 ring-1 ring-inset ring-emerald-400/30">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75 motion-reduce:animate-none"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                                </span>
                                Pendaftaran Dibuka
                            </p>
                            <h2 id="spmb-status-title" class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-4xl">SPMB SMK Bina Mandiri sedang dibuka</h2>
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-brand-100 sm:text-lg">
                                Periode pendaftaran berlangsung {{ $ppdbSetting->registration_start->translatedFormat('d F Y') }} sampai {{ $ppdbSetting->registration_end->translatedFormat('d F Y') }}.
                            </p>
                        @elseif($spmbState === 'upcoming')
                            <p class="inline-flex items-center gap-2 rounded-full bg-amber-400/15 px-3 py-1.5 text-xs font-bold uppercase tracking-[.16em] text-amber-300 ring-1 ring-inset ring-amber-400/30">
                                <x-icon name="clock" class="h-3.5 w-3.5" /> Segera Dibuka
                            </p>
                            <h2 id="spmb-status-title" class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-4xl">SPMB dibuka {{ $ppdbSetting->registration_start->translatedFormat('d F Y') }}</h2>
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-brand-100 sm:text-lg">
                                Siapkan dokumen Anda lebih awal agar proses pendaftaran berjalan lancar saat periode SPMB dimulai.
                            </p>
                        @elseif($spmbState === 'closed')
                            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-[.16em] text-brand-200 ring-1 ring-inset ring-white/20">
                                <x-icon name="flag" class="h-3.5 w-3.5" /> Periode Berakhir
                            </p>
                            <h2 id="spmb-status-title" class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-4xl">Periode SPMB terakhir telah ditutup</h2>
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-brand-100 sm:text-lg">
                                Periode {{ $ppdbSetting->registration_start->translatedFormat('d F Y') }} &ndash; {{ $ppdbSetting->registration_end->translatedFormat('d F Y') }} telah berakhir. Hubungi sekolah untuk menanyakan jadwal berikutnya.
                            </p>
                        @else
                            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-[.16em] text-brand-200 ring-1 ring-inset ring-white/20">
                                <x-icon name="megaphone" class="h-3.5 w-3.5" /> Informasi SPMB
                            </p>
                            <h2 id="spmb-status-title" class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-4xl">Informasi SPMB SMK Bina Mandiri</h2>
                            <p class="mt-4 max-w-xl text-base leading-relaxed text-brand-100 sm:text-lg">
                                Jadwal SPMB terbaru akan dipublikasikan melalui kanal resmi sekolah. Hubungi kami untuk memperoleh informasi pendaftaran.
                            </p>
                        @endif

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('ppdb.register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-3.5 text-base font-bold text-white shadow-lg shadow-brand-500/25 transition hover:bg-brand-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                Daftar SPMB 2026 <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                            <a href="{{ route('ppdb.check-status') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/5 px-6 py-3.5 text-base font-bold text-white transition hover:bg-white/15 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                <x-icon name="magnifying-glass-plus" class="h-4 w-4" /> Cek status pendaftaran
                            </a>
                        </div>
                    </div>

                    @if($spmbRequirements->count() > 0)
                        <aside class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm">
                            <h3 class="flex items-center gap-2 text-base font-black">
                                <x-icon name="clipboard-document-check" class="h-5 w-5 text-brand-300" /> Dokumen persyaratan
                            </h3>
                            <ul class="mt-4 space-y-2.5 text-sm text-brand-100">
                                @foreach($spmbRequirements as $requirement)
                                    <li class="flex gap-2.5">
                                        <x-icon name="check-circle" class="mt-0.5 h-4 w-4 text-emerald-300" />
                                        <span>{{ $requirement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                    @else
                        <aside class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur-sm">
                            <h3 class="flex items-center gap-2 text-base font-black">
                                <x-icon name="chat-bubble-left-right" class="h-5 w-5 text-brand-300" /> Butuh bantuan?
                            </h3>
                            <p class="mt-3 text-sm leading-relaxed text-brand-100">Panitia SPMB siap membantu menjawab pertanyaan Anda melalui kanal resmi sekolah.</p>
                            <div class="mt-5 space-y-2.5 text-sm">
                                @if(!empty($contact['whatsapp']))
                                    <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 font-semibold text-emerald-300 transition hover:text-emerald-200">
                                        <x-icon name="chat-bubble-left-right" class="h-4 w-4" /> WhatsApp resmi sekolah
                                    </a>
                                @endif
                                @if(!empty($contact['phone']))
                                    <a href="tel:{{ $contact['phone'] }}" class="flex items-center gap-2.5 text-brand-100 transition hover:text-white">
                                        <x-icon name="phone" class="h-4 w-4" /> {{ $contact['phone'] }}
                                    </a>
                                @endif
                            </div>
                        </aside>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- 4. Why choose us --}}
    <section class="bg-white py-16 sm:py-20" aria-labelledby="why-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                    <x-icon name="sparkles" class="h-4 w-4" /> Mengapa Memilih Kami
                </p>
                <h2 id="why-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Sekolah vokasi yang dekat dengan kebutuhan masa depan</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">Ikhlas Berkarya Pelayanan Prima menjadi semangat kami dalam mendampingi siswa belajar, bertumbuh, dan menyiapkan langkah setelah lulus.</p>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach($advantages as $advantage)
                    <article class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-card transition duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-card-hover">
                        <span class="pointer-events-none absolute -right-10 -top-10 h-24 w-24 rounded-full bg-brand-50 transition duration-500 group-hover:scale-150" aria-hidden="true"></span>
                        <span class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-brand-100 text-brand-700 transition duration-300 group-hover:bg-brand-600 group-hover:text-white">
                            <x-icon :name="$advantage['icon']" class="h-6 w-6" />
                        </span>
                        <h3 class="relative mt-5 text-lg font-bold text-brand-900">{{ $advantage['title'] }}</h3>
                        <p class="relative mt-2 text-sm leading-relaxed text-slate-600">{{ $advantage['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. Programs --}}
    <section id="program-keahlian" class="bg-slate-50 py-16 sm:py-20" aria-labelledby="program-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                        <x-icon name="squares-2x2" class="h-4 w-4" /> Pilihan Masa Depan
                    </p>
                    <h2 id="program-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Program Keahlian</h2>
                    <p class="mt-3 text-slate-600">Kenali kompetensi yang dapat menjadi langkah awal menuju dunia kerja, wirausaha, atau pendidikan lanjutan.</p>
                </div>
                <a href="{{ route('public.competencies.index') }}" class="group inline-flex shrink-0 items-center gap-2 font-bold text-brand-600 transition hover:text-brand-700">
                    Lihat semua program
                    <x-icon name="arrow-long-right" class="h-5 w-5 transition group-hover:translate-x-1" />
                </a>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($programs as $program)
                    @php $programHref = !empty($program['slug']) ? route('public.competencies.show', $program['slug']) : route('public.competencies.index'); @endphp
                    <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card transition duration-300 hover:-translate-y-1.5 hover:border-brand-200 hover:shadow-card-hover">
                        <div class="relative flex h-44 items-center justify-center overflow-hidden bg-gradient-to-br from-brand-50 via-white to-slate-100 p-6">
                            @if(!empty($program['image']))
                                <img
                                    src="{{ Storage::url($program['image']) }}"
                                    alt="Logo program keahlian {{ $program['name'] }} SMK Bina Mandiri Kota Bekasi"
                                    class="max-h-24 max-w-[55%] object-contain transition duration-500 group-hover:scale-110"
                                    loading="lazy" decoding="async"
                                >
                            @else
                                <span class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white text-brand-500 shadow-card">
                                    <x-icon :name="$programIcon($program['name'])" class="h-10 w-10" stroke="1.25" />
                                </span>
                            @endif
                            <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-900/90 px-3 py-1 text-xs font-bold text-white backdrop-blur-sm">
                                <x-icon :name="$programIcon($program['name'])" class="h-3.5 w-3.5" /> Program Keahlian
                            </span>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="text-xl font-black leading-snug text-brand-900">
                                <a href="{{ $programHref }}" class="transition hover:text-brand-600">{{ $program['name'] }}</a>
                            </h3>
                            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $program['description'] ?: 'Informasi kompetensi program tersedia pada halaman detail.' }}</p>

                            @if(!empty($program['student_count']))
                                <p class="mt-5 inline-flex items-center gap-2 self-start rounded-lg bg-brand-50 px-3 py-1.5 text-sm font-bold text-brand-700">
                                    <x-icon name="user-group" class="h-4 w-4" /> {{ $program['student_count'] }} siswa terdata
                                </p>
                            @else
                                <p class="mt-5 text-xs leading-relaxed text-slate-500">Jumlah siswa per jurusan ditampilkan setelah data akademik diverifikasi.</p>
                            @endif

                            <a href="{{ $programHref }}" class="mt-5 inline-flex items-center gap-2 font-bold text-brand-600 transition hover:text-brand-700">
                                {{ !empty($program['slug']) ? 'Pelajari program' : 'Lihat detail program' }}
                                <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 6. Registration flow --}}
    <section id="alur-spmb" class="bg-white py-16 sm:py-20" aria-labelledby="flow-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                    <x-icon name="clipboard-document-check" class="h-4 w-4" /> Alur Pendaftaran
                </p>
                <h2 id="flow-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Empat langkah menjadi siswa baru</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">Prosesnya ringkas dan dapat diikuti dari rumah. Panitia SPMB akan mendampingi setiap tahapnya.</p>
            </div>

            <ol class="relative mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <span class="pointer-events-none absolute left-0 right-0 top-7 hidden border-t-2 border-dashed border-brand-100 lg:block" aria-hidden="true"></span>
                @foreach($registrationSteps as $index => $step)
                    <li class="relative flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-card transition duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-card-hover">
                        <div class="flex items-center gap-3">
                            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-900 text-white ring-4 ring-white">
                                <x-icon :name="$step['icon']" class="h-6 w-6" />
                            </span>
                            <span class="text-4xl font-black leading-none text-brand-100" aria-hidden="true">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-brand-900"><span class="sr-only">Langkah {{ $index + 1 }}: </span>{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $step['description'] }}</p>
                    </li>
                @endforeach
            </ol>

            <div class="mt-10 flex flex-wrap items-center gap-4 rounded-2xl border border-brand-100 bg-brand-50 p-6">
                <x-icon name="light-bulb" class="h-6 w-6 text-brand-600" />
                <p class="flex-1 text-sm font-semibold leading-relaxed text-brand-900 sm:text-base">Sudah menyiapkan dokumen? Mulai pendaftaran sekarang, prosesnya hanya beberapa menit.</p>
                <a href="{{ route('ppdb.register') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 font-bold text-white transition hover:bg-brand-700">
                    Mulai daftar <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>

    {{-- 7. Announcements and SPMB brochure: only render verified CMS records --}}
    @if($announcements->count() > 0 || $brochure)
        <section id="pengumuman" class="bg-slate-50 py-16 sm:py-20" aria-labelledby="announcement-title">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                        <x-icon name="megaphone" class="h-4 w-4" /> Informasi Terbaru
                    </p>
                    <h2 id="announcement-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Pengumuman &amp; Brosur SPMB</h2>
                    <p class="mt-3 text-slate-600">Ikuti pengumuman resmi sekolah dan unduh brosur SPMB untuk informasi pendaftaran secara lengkap.</p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-[1.5fr_1fr] lg:items-start">
                    @if($announcements->count() > 0)
                        <div class="grid gap-5 sm:grid-cols-2" x-data="{ lightboxUrl: null, lightboxTitle: '' }" @keydown.escape.window="lightboxUrl = null">
                            @foreach($announcements as $announcement)
                                @php $announcementCard = 'group block w-full overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-card transition duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-card-hover'; @endphp
                                @if($announcement->link_url)
                                    <a href="{{ $announcement->link_url }}" target="_blank" rel="noopener noreferrer" class="{{ $announcementCard }}">
                                        <div class="relative aspect-[4/5] overflow-hidden bg-brand-50 sm:aspect-square">
                                            <img src="{{ $announcement->image_url }}" alt="Pengumuman: {{ $announcement->title }}" class="h-full w-full object-contain transition duration-500 group-hover:scale-105" loading="lazy" decoding="async"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span class="h-full w-full items-center justify-center" style="display: none;"><x-icon name="photo" class="h-14 w-14 text-brand-300" stroke="1" /></span>
                                        </div>
                                        <div class="p-5">
                                            <h3 class="text-base font-black leading-snug text-brand-900 transition group-hover:text-brand-600">{{ $announcement->title }}</h3>
                                            <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600">
                                                Lihat detail <x-icon name="arrow-top-right-on-square" class="h-4 w-4" />
                                            </span>
                                        </div>
                                    </a>
                                @else
                                    <button type="button" @click="lightboxUrl = '{{ $announcement->image_url }}'; lightboxTitle = @js($announcement->title)" class="{{ $announcementCard }}">
                                        <div class="relative aspect-[4/5] overflow-hidden bg-brand-50 sm:aspect-square">
                                            <img src="{{ $announcement->image_url }}" alt="Pengumuman: {{ $announcement->title }}" class="h-full w-full object-contain transition duration-500 group-hover:scale-105" loading="lazy" decoding="async"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span class="h-full w-full items-center justify-center" style="display: none;"><x-icon name="photo" class="h-14 w-14 text-brand-300" stroke="1" /></span>
                                        </div>
                                        <div class="p-5">
                                            <h3 class="text-base font-black leading-snug text-brand-900 transition group-hover:text-brand-600">{{ $announcement->title }}</h3>
                                            <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600">
                                                Perbesar gambar <x-icon name="magnifying-glass-plus" class="h-4 w-4" />
                                            </span>
                                        </div>
                                    </button>
                                @endif
                            @endforeach

                            {{-- Lightbox: enlarge announcement poster on click --}}
                            <div x-show="lightboxUrl" x-cloak @click.self="lightboxUrl = null" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/85 p-4 backdrop-blur-sm" style="display: none;">
                                <div class="relative max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
                                    <button type="button" @click="lightboxUrl = null" class="absolute right-3 top-3 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-700 shadow transition hover:bg-white" aria-label="Tutup gambar">
                                        <x-icon name="x-mark" class="h-5 w-5" stroke="2" />
                                    </button>
                                    <img :src="lightboxUrl" :alt="lightboxTitle" class="max-h-[90vh] w-full object-contain">
                                    <p x-show="lightboxTitle" x-text="lightboxTitle" class="p-4 text-center text-sm font-bold text-brand-900"></p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($brochure)
                        <aside class="overflow-hidden rounded-2xl border border-brand-800 bg-brand-900 text-white shadow-card-hover">
                            @if($brochure['is_image'])
                                {{-- Drop the preview rather than show a broken image; the card below still reads. --}}
                                <img src="{{ $brochure['url'] }}" alt="{{ $brochure['title'] }}" class="h-56 w-full object-cover" loading="lazy" decoding="async" onerror="this.remove();">
                            @else
                                <div class="flex h-40 items-center justify-center bg-white/10">
                                    <x-icon name="document-text" class="h-16 w-16 text-brand-200" stroke="1" />
                                </div>
                            @endif
                            <div class="p-6">
                                <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.18em] text-brand-300">
                                    <x-icon name="document-arrow-down" class="h-4 w-4" /> Brosur Resmi
                                </p>
                                <h3 class="mt-3 text-xl font-black">{{ $brochure['title'] }}</h3>
                                @if($brochure['description'])
                                    <p class="mt-3 text-sm leading-relaxed text-brand-100">{{ $brochure['description'] }}</p>
                                @endif
                                <a href="{{ $brochure['url'] }}" target="_blank" rel="noopener noreferrer" download class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-3 font-bold text-white transition hover:bg-brand-400">
                                    Unduh Brosur <x-icon name="arrow-down-tray" class="h-4 w-4" />
                                </a>
                            </div>
                        </aside>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- 8. Alumni testimonials: only render verified CMS records --}}
    @if(count($testimonials) > 0)
        <section class="bg-white py-16 sm:py-20" aria-labelledby="testimonial-title">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                        <x-icon name="chat-bubble-left-right" class="h-4 w-4" /> Cerita Alumni
                    </p>
                    <h2 id="testimonial-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Langkah mereka setelah lulus</h2>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($testimonials as $testimonial)
                        @if(!empty($testimonial['name']) && !empty($testimonial['quote']))
                            <figure class="flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-card transition duration-300 hover:-translate-y-1 hover:shadow-card-hover">
                                <x-icon name="chat-bubble-left-right" class="h-8 w-8 text-brand-200" stroke="1.25" />
                                <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-slate-700">&ldquo;{{ $testimonial['quote'] }}&rdquo;</blockquote>
                                <div class="mt-6 flex items-center gap-4 border-t border-slate-100 pt-5">
                                    @if(!empty($testimonial['photo']))
                                        <img src="{{ asset('storage/' . $testimonial['photo']) }}" alt="Foto alumni {{ $testimonial['name'] }}" class="h-12 w-12 rounded-full object-cover" width="48" height="48" loading="lazy" decoding="async">
                                    @else
                                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 font-bold text-brand-700">{{ Str::upper(Str::substr($testimonial['name'], 0, 1)) }}</span>
                                    @endif
                                    <div class="min-w-0">
                                        <figcaption class="truncate font-bold text-brand-900">{{ $testimonial['name'] }}</figcaption>
                                        @if(!empty($testimonial['role']))
                                            <p class="truncate text-sm text-slate-500">{{ $testimonial['role'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </figure>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 9. Industry partners and BKK --}}
    <section id="mitra-bkk" class="bg-slate-50 py-16 sm:py-20" aria-labelledby="industry-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                    <x-icon name="briefcase" class="h-4 w-4" /> Dunia Kerja
                </p>
                <h2 id="industry-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Mitra Industri &amp; Bursa Kerja Khusus</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">Kemitraan membantu sekolah menjaga relevansi pembelajaran dengan kebutuhan dunia kerja.</p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-[1.4fr_.8fr] lg:items-start">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @php $partnerCardClass = 'group relative flex min-h-28 items-center justify-center rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-card'; @endphp
                    @forelse($industryPartners as $partner)
                        <div class="{{ $partnerCardClass }}">
                            @if($partner->logo)
                                {{-- Fall back to the partner name if the logo file is missing, so the
                                     grid never shows a broken image. --}}
                                <img
                                    src="{{ asset('storage/' . $partner->logo) }}"
                                    alt="Logo mitra industri {{ $partner->name }}"
                                    class="max-h-14 max-w-full object-contain opacity-90 transition duration-300 group-hover:scale-105 group-hover:opacity-100"
                                    loading="lazy" decoding="async"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
                                >
                                <span class="text-sm font-bold text-brand-900" style="display: none;">{{ $partner->name }}</span>
                            @else
                                <span class="text-sm font-bold text-brand-900">{{ $partner->name }}</span>
                            @endif

                            @if($partner->website)
                                {{-- Stretched link: keeps one card markup for both linked and plain partners. --}}
                                <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer nofollow" class="absolute inset-0 rounded-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                                    <span class="sr-only">Kunjungi situs {{ $partner->name }}</span>
                                </a>
                            @endif
                        </div>
                    @empty
                        @foreach($partnerNames as $partnerName)
                            <div class="{{ $partnerCardClass }}">
                                <span class="text-sm font-bold text-brand-900">{{ $partnerName }}</span>
                            </div>
                        @endforeach
                    @endforelse
                </div>

                <aside class="relative overflow-hidden rounded-2xl bg-brand-900 p-6 text-white shadow-card-hover sm:p-8">
                    <span class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-brand-500/20 blur-2xl" aria-hidden="true"></span>
                    <div class="relative">
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10">
                            <x-icon name="rocket-launch" class="h-6 w-6 text-brand-300" />
                        </span>
                        <p class="mt-5 text-sm font-bold uppercase tracking-[.18em] text-brand-300">BKK SMK Bina Mandiri</p>
                        <h3 class="mt-2 text-2xl font-black leading-tight">Jembatan menuju dunia kerja</h3>
                        @if($bkkPlacementRate)
                            <p class="mt-6 text-5xl font-black tracking-tight text-amber-300">{{ $bkkPlacementRate }}</p>
                            <p class="mt-1 text-brand-100">tingkat penyaluran kerja alumni</p>
                        @else
                            <p class="mt-5 text-sm leading-relaxed text-brand-100">Angka penyaluran kerja alumni akan ditampilkan setelah data BKK diverifikasi dan diperbarui oleh sekolah.</p>
                        @endif
                        <a href="{{ route('info.contact') }}" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-3 font-bold text-white transition hover:bg-brand-400">
                            Tanya informasi BKK <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- 10. Student achievement/news --}}
    @if($latestNews->count() > 0)
        <section class="bg-white py-16 sm:py-20" aria-labelledby="news-title">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div class="max-w-2xl">
                        <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                            <x-icon name="newspaper" class="h-4 w-4" /> Kabar &amp; Prestasi
                        </p>
                        <h2 id="news-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">Aktivitas dan pencapaian terbaru</h2>
                    </div>
                    <a href="{{ route('public.news.index') }}" class="group inline-flex shrink-0 items-center gap-2 font-bold text-brand-600 transition hover:text-brand-700">
                        Lihat semua berita <x-icon name="arrow-long-right" class="h-5 w-5 transition group-hover:translate-x-1" />
                    </a>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-2">
                    {{-- Featured article --}}
                    <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card transition duration-300 hover:border-brand-200 hover:shadow-card-hover">
                        <a href="{{ route('public.news.show', $featuredNews->slug) }}" class="flex h-full flex-col">
                            <div class="relative aspect-[16/10] overflow-hidden bg-brand-50">
                                @if($featuredNews->featured_image)
                                    <img src="{{ Storage::url($featuredNews->featured_image) }}" alt="{{ $featuredNews->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" decoding="async"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <span class="h-full w-full items-center justify-center" style="display: none;">
                                        <x-icon name="trophy" class="h-16 w-16 text-brand-300" stroke="1" />
                                    </span>
                                @else
                                    <span class="flex h-full w-full items-center justify-center">
                                        <x-icon name="trophy" class="h-16 w-16 text-brand-300" stroke="1" />
                                    </span>
                                @endif
                                @if($featuredNews->category)
                                    <span class="absolute left-4 top-4 rounded-full bg-brand-900/90 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white backdrop-blur-sm">{{ $featuredNews->category->name }}</span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6 sm:p-7">
                                <h3 class="text-xl font-black leading-snug text-brand-900 transition group-hover:text-brand-600 sm:text-2xl">{{ $featuredNews->title }}</h3>
                                @if($featuredSummary)
                                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $featuredSummary }}</p>
                                @endif
                                <div class="mt-auto flex items-center gap-2 pt-5 text-xs text-slate-500">
                                    <x-icon name="calendar-days" class="h-4 w-4" />
                                    <time datetime="{{ optional($featuredNews->published_at)->toIso8601String() }}">{{ optional($featuredNews->published_at)->translatedFormat('d F Y') }}</time>
                                </div>
                            </div>
                        </a>
                    </article>

                    {{-- Secondary list --}}
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                        @foreach($secondaryNews as $news)
                            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card transition duration-300 hover:border-brand-200 hover:shadow-card-hover">
                                <a href="{{ route('public.news.show', $news->slug) }}" class="flex h-full flex-col sm:flex-row">
                                    <div class="relative aspect-[16/10] shrink-0 overflow-hidden bg-brand-50 sm:aspect-square sm:w-36">
                                        @if($news->featured_image)
                                            <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" decoding="async"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span class="h-full w-full items-center justify-center" style="display: none;">
                                                <x-icon name="star" class="h-9 w-9 text-brand-300" stroke="1.25" />
                                            </span>
                                        @else
                                            <span class="flex h-full w-full items-center justify-center">
                                                <x-icon name="star" class="h-9 w-9 text-brand-300" stroke="1.25" />
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-1 flex-col p-5">
                                        @if($news->category)
                                            <span class="text-xs font-bold uppercase tracking-wide text-brand-500">{{ $news->category->name }}</span>
                                        @endif
                                        <h3 class="mt-1.5 line-clamp-2 font-bold leading-snug text-brand-900 transition group-hover:text-brand-600">{{ $news->title }}</h3>
                                        <div class="mt-auto flex items-center gap-2 pt-3 text-xs text-slate-500">
                                            <x-icon name="calendar-days" class="h-3.5 w-3.5" />
                                            <time datetime="{{ optional($news->published_at)->toIso8601String() }}">{{ optional($news->published_at)->translatedFormat('d F Y') }}</time>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- 11. Instagram: official channel promo, links out to the live profile --}}
    @if($instagramUrl)
        <section id="instagram" class="bg-slate-50 py-16 sm:py-20" aria-labelledby="instagram-title">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-[#405DE6] via-[#C13584] to-[#F77737] shadow-card-hover">
                    <div class="flex flex-col items-start gap-8 p-6 sm:p-10 lg:flex-row lg:items-center lg:justify-between lg:p-12">
                        {{-- Stacked, this column needs a definite width: with auto width the
                             flex item sizes to min-content, which the long Instagram handle
                             pushes past the card on narrow screens (overflow-wrap does not
                             shrink min-content). Side by side, min-w-0 lets it shrink instead. --}}
                        <div class="w-full min-w-0 text-white lg:w-auto">
                            <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-white/80">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.248.638.415 1.363.465 2.428.048 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.638.248-1.363.415-2.428.465-1.066.048-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.248-.638-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.638-.248 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 1.802c-2.67 0-2.987.01-4.04.058-.976.045-1.505.207-1.858.344-.466.181-.8.398-1.15.748-.35.35-.567.684-.748 1.15-.137.353-.3.882-.344 1.858-.048 1.053-.058 1.37-.058 4.04 0 2.67.01 2.987.058 4.04.045.976.207 1.505.344 1.858.181.466.399.8.748 1.15.35.35.684.567 1.15.748.353.137.882.3 1.858.344 1.053.048 1.37.058 4.04.058 2.67 0 2.987-.01 4.04-.058.976-.045 1.505-.207 1.858-.344.466-.181.8-.399 1.15-.748.35-.35.567-.684.748-1.15.137-.353.3-.882.344-1.858.048-1.053.058-1.37.058-4.04 0-2.67-.01-2.987-.058-4.04-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.858-.344-1.053-.048-1.37-.058-4.04-.058zm0 4.595a5.603 5.603 0 110 11.206 5.603 5.603 0 010-11.206zm0 1.802a3.801 3.801 0 100 7.602 3.801 3.801 0 000-7.602zm5.633-3.594a1.32 1.32 0 110 2.64 1.32 1.32 0 010-2.64z"/></svg>
                                Instagram Resmi
                            </p>
                            <h2 id="instagram-title" class="mt-3 text-2xl font-black leading-tight sm:text-3xl lg:text-4xl">Ikuti keseharian dan kegiatan siswa di Instagram kami</h2>
                            <p class="mt-4 max-w-xl break-words text-lg leading-relaxed text-white/90">Foto dan video kegiatan praktik, prestasi siswa, serta informasi terkini SPMB dibagikan langsung melalui akun Instagram resmi sekolah{{ $instagramHandle ? ' ' . $instagramHandle : '' }}.</p>
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3.5 text-base font-bold text-[#C13584] shadow-lg transition hover:bg-white/90 focus:outline-none focus:ring-4 focus:ring-white/50">
                                Kunjungi Instagram Kami <x-icon name="arrow-top-right-on-square" class="h-4 w-4" />
                            </a>
                        </div>
                        <div class="flex h-32 w-32 shrink-0 items-center justify-center rounded-full bg-white/15 backdrop-blur-sm sm:h-40 sm:w-40" aria-hidden="true">
                            <svg class="h-16 w-16 text-white sm:h-20 sm:w-20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.248.638.415 1.363.465 2.428.048 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.638.248-1.363.415-2.428.465-1.066.048-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.248-.638-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.638-.248 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 1.802c-2.67 0-2.987.01-4.04.058-.976.045-1.505.207-1.858.344-.466.181-.8.398-1.15.748-.35.35-.567.684-.748 1.15-.137.353-.3.882-.344 1.858-.048 1.053-.058 1.37-.058 4.04 0 2.67.01 2.987.058 4.04.045.976.207 1.505.344 1.858.181.466.399.8.748 1.15.35.35.684.567 1.15.748.353.137.882.3 1.858.344 1.053.048 1.37.058 4.04.058 2.67 0 2.987-.01 4.04-.058.976-.045 1.505-.207 1.858-.344.466-.181.8-.399 1.15-.748.35-.35.567-.684.748-1.15.137-.353.3-.882.344-1.858.048-1.053.058-1.37.058-4.04 0-2.67-.01-2.987-.058-4.04-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.858-.344-1.053-.048-1.37-.058-4.04-.058zm0 4.595a5.603 5.603 0 110 11.206 5.603 5.603 0 010-11.206zm0 1.802a3.801 3.801 0 100 7.602 3.801 3.801 0 000-7.602zm5.633-3.594a1.32 1.32 0 110 2.64 1.32 1.32 0 010-2.64z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- 12. FAQ --}}
    <section id="faq" class="bg-white py-16 sm:py-20" aria-labelledby="faq-title">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-brand-500">
                    <x-icon name="question-mark-circle" class="h-4 w-4" /> Pertanyaan Umum
                </p>
                <h2 id="faq-title" class="mt-4 text-3xl font-black tracking-tight text-brand-900 sm:text-4xl">FAQ SPMB</h2>
                <p class="mt-3 text-slate-600">Informasi ringkas untuk membantu calon siswa dan orang tua memulai proses pendaftaran.</p>
            </div>

            <div class="mt-12 divide-y divide-slate-200 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-card">
                @foreach($faqItems as $faq)
                    <details class="group">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 font-bold text-brand-900 transition hover:bg-slate-50 sm:p-6">
                            <span>{{ $faq['question'] }}</span>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 transition group-open:rotate-45 group-open:bg-brand-600 group-open:text-white">
                                <x-icon name="plus" class="h-4 w-4" stroke="2" />
                            </span>
                        </summary>
                        <p class="px-5 pb-6 text-sm leading-relaxed text-slate-600 sm:px-6">{{ $faq['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 13. Final CTA and verified contact/social links --}}
    <section id="daftar" class="relative overflow-hidden bg-brand-900 py-16 pb-32 text-white sm:py-20 sm:pb-24" aria-labelledby="final-cta-title">
        <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-brand-500/25 blur-3xl" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 left-1/4 h-72 w-72 rounded-full bg-brand-400/10 blur-3xl" aria-hidden="true"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.1fr_.9fr] lg:items-center">
                <div>
                    <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-amber-300">
                        <x-icon name="rocket-launch" class="h-4 w-4" /> Langkah berikutnya
                    </p>
                    <h2 id="final-cta-title" class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-5xl">Siap menyiapkan masa depan bersama SMK Bina Mandiri?</h2>
                    <p class="mt-5 max-w-2xl text-lg leading-relaxed text-brand-100">Dapatkan informasi SPMB, program keahlian, dan layanan sekolah melalui kanal resmi kami.</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('ppdb.register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-3.5 font-bold text-white shadow-lg shadow-brand-500/25 transition hover:bg-brand-400">
                            Daftar SPMB 2026 <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                        <a href="{{ route('info.contact') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/40 px-6 py-3.5 font-bold text-white transition hover:bg-white/10">
                            <x-icon name="envelope" class="h-4 w-4" /> Hubungi sekolah
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-7">
                    <h3 class="flex items-center gap-2 text-xl font-black">
                        <x-icon name="identification" class="h-5 w-5 text-brand-300" /> Kontak resmi
                    </h3>
                    <div class="mt-5 space-y-4 text-sm text-brand-100">
                        @if(!empty($contact['address']))
                            <p class="flex gap-3"><x-icon name="map-pin" class="mt-0.5 h-4 w-4 text-brand-300" /><span>{{ $contact['address'] }}</span></p>
                        @endif
                        @if(!empty($contact['phone']))
                            <a href="tel:{{ $contact['phone'] }}" class="flex gap-3 transition hover:text-white"><x-icon name="phone" class="mt-0.5 h-4 w-4 text-brand-300" /><span>{{ $contact['phone'] }}</span></a>
                        @endif
                        @if(!empty($contact['email']))
                            <a href="mailto:{{ $contact['email'] }}" class="flex gap-3 transition hover:text-white"><x-icon name="envelope" class="mt-0.5 h-4 w-4 text-brand-300" /><span class="break-all">{{ $contact['email'] }}</span></a>
                        @endif
                        @if(!empty($contact['whatsapp']))
                            <a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener noreferrer" class="flex gap-3 font-bold text-emerald-300 transition hover:text-emerald-200"><x-icon name="chat-bubble-left-right" class="mt-0.5 h-4 w-4" /><span>WhatsApp resmi sekolah</span></a>
                        @endif
                    </div>

                    @if(count($socialLinks) > 0)
                        <div class="mt-6 border-t border-white/15 pt-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-brand-200">Ikuti kanal resmi</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($socialLinks as $social)
                                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-lg border border-white/20 px-3 py-2 text-xs font-bold text-white transition hover:bg-white/10">
                                        <x-icon name="link" class="h-3.5 w-3.5" /> {{ $social['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .homepage-conversion .homepage-hero-swiper,
    .homepage-conversion .homepage-hero-swiper .swiper-slide {
        background: #fff;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide > img {
        display: block;
        width: 100%;
        height: auto;
    }

    .homepage-conversion .homepage-hero-pagination {
        width: auto;
    }

    .homepage-conversion .swiper-pagination-bullet {
        width: 9px;
        height: 9px;
        border: 1px solid rgba(15, 23, 42, .45);
        background: rgba(255, 255, 255, .9);
        box-shadow: 0 1px 4px rgba(15, 23, 42, .3);
        opacity: 1;
    }

    .homepage-conversion .swiper-pagination-bullet-active {
        background: #FBBF24;
    }

    /* Running text ------------------------------------------------------- */
    .homepage-conversion .marquee__track {
        display: flex;
        width: max-content;
        margin: 0;
        padding: 0;
        list-style: none;
        animation: homepage-marquee var(--marquee-duration, 35s) linear infinite;
    }

    /* Pause while the reader is looking at it, or tabbing through its links. */
    .homepage-conversion .marquee:hover .marquee__track,
    .homepage-conversion .marquee:focus-within .marquee__track {
        animation-play-state: paused;
    }

    @keyframes homepage-marquee {
        from { transform: translateX(0); }
        to   { transform: translateX(calc(-1 * var(--marquee-shift, 50%))); }
    }

    /* Reveal on scroll --------------------------------------------------- */
    /* .js-reveal is set by script, so without JS nothing is ever hidden. */
    .js-reveal .homepage-conversion [data-reveal] {
        opacity: 0;
        transform: translateY(18px);
    }

    .js-reveal .homepage-conversion [data-reveal].is-visible {
        opacity: 1;
        transform: none;
        transition:
            opacity .6s cubic-bezier(.22, .61, .36, 1) var(--reveal-delay, 0ms),
            transform .6s cubic-bezier(.22, .61, .36, 1) var(--reveal-delay, 0ms);
    }

    .js-reveal .homepage-conversion [data-reveal] .stat-rule {
        transform: scaleX(0);
    }

    .js-reveal .homepage-conversion [data-reveal].is-visible .stat-rule {
        transform: scaleX(1);
        transition: transform .7s cubic-bezier(.22, .61, .36, 1) calc(var(--reveal-delay, 0ms) + 200ms);
    }

    /* Keep the counter from reflowing its row as the digits change. */
    .homepage-conversion .stat-number {
        font-variant-numeric: tabular-nums;
    }

    /* The custom +/- button replaces the native disclosure marker, which
       otherwise still renders on Safari and Firefox. */
    .homepage-conversion details > summary::-webkit-details-marker {
        display: none;
    }

    .homepage-conversion details > summary::marker {
        content: '';
    }

    @media (max-width: 639px) {
        .homepage-conversion .homepage-hero-pagination {
            bottom: .5rem !important;
        }

        .homepage-conversion .swiper-pagination-bullet {
            width: 7px;
            height: 7px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .homepage-conversion *,
        .homepage-conversion *::before,
        .homepage-conversion *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
            animation-delay: 0ms !important;
        }

        /* Let the reader scroll the messages themselves instead of animating. */
        .homepage-conversion .marquee {
            overflow-x: auto;
        }

        .homepage-conversion .marquee__track {
            animation: none !important;
            transform: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var hero = document.querySelector('.homepage-hero-swiper');
    if (!hero || typeof Swiper === 'undefined') return;
    var slider = new Swiper(hero, {
        loop: true,
        autoHeight: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed: 700,
        autoplay: { delay: 5500, disableOnInteraction: false, pauseOnMouseEnter: true },
        pagination: { el: '.homepage-hero-pagination', clickable: true },
        navigation: { nextEl: '.homepage-hero-next', prevEl: '.homepage-hero-prev' },
        keyboard: { enabled: true },
        a11y: { enabled: true },
        observer: true,
        observeParents: true
    });

    hero.querySelectorAll('img').forEach(function (image) {
        if (!image.complete) {
            image.addEventListener('load', function () {
                slider.updateAutoHeight(0);
            }, { once: true });
        }
    });
});
</script>

<script>
(function () {
    'use strict';

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ----------------------------------------------------------------- *
     * Running text: clone the message group until the track is wider than
     * the rail, then shift by exactly one group so the loop is seamless.
     * ----------------------------------------------------------------- */
    function setUpMarquee(marquee) {
        var track = marquee.querySelector('[data-marquee-track]');
        var group = track && track.firstElementChild;
        if (!track || !group) return;

        function layout() {
            track.querySelectorAll('[data-marquee-clone]').forEach(function (node) {
                node.remove();
            });

            var groupWidth = group.getBoundingClientRect().width;
            var railWidth = marquee.getBoundingClientRect().width;
            if (!groupWidth || !railWidth) return;

            var copies = Math.ceil((railWidth * 2) / groupWidth);
            for (var i = 0; i < copies; i++) {
                var clone = group.cloneNode(true);
                clone.setAttribute('aria-hidden', 'true');
                clone.setAttribute('data-marquee-clone', '');
                // Duplicated links must not become extra tab stops.
                clone.querySelectorAll('a').forEach(function (link) {
                    link.setAttribute('tabindex', '-1');
                });
                track.appendChild(clone);
            }

            marquee.style.setProperty('--marquee-shift', groupWidth + 'px');
        }

        layout();

        // Web fonts change the measured width, so lay out again once they land.
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(layout).catch(function () {});
        }

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(layout, 200);
        });
    }

    /* ----------------------------------------------------------------- *
     * Statistics count-up, started when the panel scrolls into view.
     * ----------------------------------------------------------------- */
    function countUp(el) {
        var target = parseFloat(el.getAttribute('data-count-to'));
        if (isNaN(target)) return;

        var decimals = parseInt(el.getAttribute('data-count-decimals'), 10) || 0;
        var format = function (value) {
            return value.toLocaleString('id-ID', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        };

        if (reduceMotion) {
            el.textContent = format(target);
            return;
        }

        var duration = 1400;
        var started = null;

        function frame(now) {
            if (started === null) started = now;
            var progress = Math.min((now - started) / duration, 1);
            // easeOutExpo: fast at first, settling gently on the final figure.
            var eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            el.textContent = format(target * eased);
            if (progress < 1) requestAnimationFrame(frame);
        }

        el.textContent = format(0);
        requestAnimationFrame(frame);
    }

    /* ----------------------------------------------------------------- *
     * Reveal on scroll. The hiding styles only apply once .js-reveal is
     * set here, so the page stays fully visible when JS is unavailable.
     * ----------------------------------------------------------------- */
    function setUpReveal() {
        var targets = document.querySelectorAll('.homepage-conversion [data-reveal]');
        if (!targets.length) return;

        var counters = document.querySelectorAll('.homepage-conversion .stat-number[data-count-to]');

        if (reduceMotion || !('IntersectionObserver' in window)) {
            targets.forEach(function (el) { el.classList.add('is-visible'); });
            counters.forEach(countUp);
            return;
        }

        document.documentElement.classList.add('js-reveal');

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                entry.target.querySelectorAll('.stat-number[data-count-to]').forEach(countUp);
                observer.unobserve(entry.target);
            });
        }, { rootMargin: '0px 0px -10% 0px', threshold: 0.15 });

        targets.forEach(function (el) { observer.observe(el); });
    }

    function init() {
        document.querySelectorAll('[data-marquee]').forEach(setUpMarquee);
        setUpReveal();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>

{{-- Structured data: FAQ rich results --}}
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($faqItems)->map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq['question'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

{{-- Structured data: site search, so Google can offer a sitelinks search box --}}
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'SMK Bina Mandiri Kota Bekasi',
    'url' => url('/'),
    'inLanguage' => 'id-ID',
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => ['@type' => 'EntryPoint', 'urlTemplate' => route('search') . '?q={search_term_string}'],
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

{{-- Structured data: the programs offered, as an ordered list of courses --}}
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => 'Program Keahlian SMK Bina Mandiri Kota Bekasi',
    'itemListElement' => $programs->values()->map(fn ($program, $index) => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'item' => array_filter([
            '@type' => 'Course',
            'name' => $program['name'],
            'description' => $program['description'] ?: null,
            'url' => !empty($program['slug']) ? route('public.competencies.show', $program['slug']) : route('public.competencies.index'),
            'provider' => [
                '@type' => 'EducationalOrganization',
                'name' => 'SMK Bina Mandiri Kota Bekasi',
                'sameAs' => url('/'),
            ],
        ]),
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
