@extends('layouts.public-tailwind')

@section('title', 'SMK Bina Mandiri Kota Bekasi | SPMB 2026')
@section('description', 'SMK Bina Mandiri Kota Bekasi dengan 3 program keahlian: Teknik Kendaraan Ringan, Teknik Sepeda Motor, dan Teknik Komputer & Jaringan. Kenali sekolah dan informasi SPMB 2026.')
@section('keywords', 'SMK Bina Mandiri Kota Bekasi, SPMB 2026, SMK Bekasi, Teknik Kendaraan Ringan, Teknik Sepeda Motor, Teknik Komputer Jaringan')
@section('og_title', 'SMK Bina Mandiri Kota Bekasi | SPMB 2026')
@section('og_description', 'Kenali program keahlian, pembelajaran praktik, mitra industri, dan informasi SPMB SMK Bina Mandiri Kota Bekasi.')

@php
    $heroImage = $sliders->first()?->image_path;
    $programFallbacks = [
        ['name' => 'Teknik Kendaraan Ringan', 'description' => 'Pembelajaran keahlian kendaraan ringan berbasis praktik.', 'slug' => null],
        ['name' => 'Teknik Sepeda Motor', 'description' => 'Pembelajaran perawatan dan teknologi sepeda motor berbasis praktik.', 'slug' => null],
        ['name' => 'Teknik Komputer & Jaringan', 'description' => 'Pembelajaran komputer, jaringan, dan teknologi informasi.', 'slug' => null],
    ];
    $programs = $featuredCompetencies->count() > 0
        ? $featuredCompetencies->map(fn ($program) => [
            'name' => $program->name,
            'description' => Str::limit(strip_tags($program->description), 150),
            'slug' => $program->slug,
            'image' => $program->image,
            'student_count' => $programStudentCounts[$program->slug] ?? null,
        ])->values()
        : collect($programFallbacks);
    $faqItems = [
        ['question' => 'Bagaimana cara mendaftar SPMB 2026?', 'answer' => 'Buka halaman pendaftaran SPMB melalui tombol Daftar SPMB. Ikuti formulir dan petunjuk yang ditampilkan. Jika membutuhkan bantuan, hubungi sekolah melalui kontak resmi.'],
        ['question' => 'Kapan jadwal SPMB dibuka?', 'answer' => $ppdbSetting ? 'Periode pendaftaran: ' . $ppdbSetting->registration_start->translatedFormat('d F Y') . ' sampai ' . $ppdbSetting->registration_end->translatedFormat('d F Y') . '.' : 'Jadwal SPMB belum dipublikasikan. Silakan hubungi sekolah untuk mendapatkan informasi terbaru.'],
        ['question' => 'Berapa biaya pendaftaran dan pendidikan?', 'answer' => 'Rincian biaya dapat berubah sesuai kebijakan sekolah. Silakan konfirmasi langsung melalui WhatsApp atau telepon resmi agar memperoleh informasi yang tepat.'],
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
@endphp

@section('og_image', $heroImage ? asset('storage/' . $heroImage) : asset('storage/' . setting('site_logo', 'images/logo-default.png')))

@section('content')
<div class="bg-slate-50 text-slate-900 homepage-conversion">
    <!-- 1. Hero: conversion-first, one H1 only -->
    <section class="relative overflow-hidden bg-[#0B1F4B] text-white" aria-labelledby="homepage-title">
        @if($sliders->count() > 0)
            <div class="swiper homepage-hero-swiper">
                <div class="swiper-wrapper">
                    @foreach($sliders as $index => $slider)
                        <div class="swiper-slide relative min-h-[620px] md:min-h-[700px] flex items-center">
                            @if($slider->image_path)
                                <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title ?: 'Kegiatan SMK Bina Mandiri Kota Bekasi' }}" class="absolute inset-0 w-full h-full object-cover" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" @if($index === 0) fetchpriority="high" @endif>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-r from-[#061536]/95 via-[#0B1F4B]/75 to-[#0B1F4B]/30"></div>
                            <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-24">
                                <div class="max-w-3xl">
                                    @if($index === 0)
                                        <p class="mb-4 text-sm font-bold uppercase tracking-[.22em] text-amber-300">SMK Bina Mandiri Kota Bekasi</p>
                                        <h1 id="homepage-title" class="text-4xl sm:text-5xl lg:text-7xl font-black leading-[1.05] tracking-tight">Bangun Masa Depanmu dengan Keahlian yang Siap Dipakai</h1>
                                        <p class="mt-6 max-w-2xl text-lg sm:text-xl text-blue-100 leading-relaxed">Unggul dalam Prestasi, Berkarakter dalam Budi Pekerti. Kenali pembelajaran praktik, program keahlian, dan kemitraan industri kami.</p>
                                    @else
                                        <p class="mb-4 text-sm font-bold uppercase tracking-[.22em] text-amber-300">Pembelajaran Vokasi</p>
                                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">{{ $slider->title ?: 'Belajar dari praktik, tumbuh bersama industri' }}</h2>
                                        @if($slider->subtitle)<p class="mt-6 max-w-2xl text-lg text-blue-100 leading-relaxed">{{ $slider->subtitle }}</p>@endif
                                    @endif
                                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                                        <a href="{{ route('ppdb.register') }}" class="inline-flex items-center justify-center rounded-xl bg-[#3B82F6] px-6 py-3.5 text-base font-bold text-white shadow-lg shadow-blue-950/30 transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300">Daftar SPMB 2026 <span class="ml-2" aria-hidden="true">→</span></a>
                                        <a href="{{ route('public.competencies.index') }}" class="inline-flex items-center justify-center rounded-xl border border-white/70 bg-white/10 px-6 py-3.5 text-base font-bold text-white backdrop-blur-sm transition hover:bg-white/20 focus:outline-none focus:ring-4 focus:ring-white/50">Lihat Program Keahlian</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($sliders->count() > 1)
                    <button type="button" class="homepage-hero-prev absolute left-4 top-1/2 z-20 hidden -translate-y-1/2 rounded-full bg-white/15 p-3 text-white backdrop-blur hover:bg-white/25 md:block" aria-label="Slide sebelumnya">←</button>
                    <button type="button" class="homepage-hero-next absolute right-4 top-1/2 z-20 hidden -translate-y-1/2 rounded-full bg-white/15 p-3 text-white backdrop-blur hover:bg-white/25 md:block" aria-label="Slide berikutnya">→</button>
                    <div class="homepage-hero-pagination absolute bottom-8 left-1/2 z-20 -translate-x-1/2"></div>
                @endif
            </div>
        @else
            <div class="relative min-h-[620px] flex items-center">
                <div class="absolute inset-0 bg-gradient-to-br from-[#0B1F4B] via-blue-800 to-[#3B82F6]"></div>
                <div class="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-28">
                    <p class="mb-4 text-sm font-bold uppercase tracking-[.22em] text-amber-300">SMK Bina Mandiri Kota Bekasi</p>
                    <h1 id="homepage-title" class="max-w-4xl text-4xl sm:text-5xl lg:text-7xl font-black leading-tight">Bangun Masa Depanmu dengan Keahlian yang Siap Dipakai</h1>
                    <p class="mt-6 max-w-2xl text-lg text-blue-100">Unggul dalam Prestasi, Berkarakter dalam Budi Pekerti.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3"><a href="{{ route('ppdb.register') }}" class="rounded-xl bg-white px-6 py-3.5 text-center font-bold text-[#1E3A8A]">Daftar SPMB 2026</a><a href="{{ route('public.competencies.index') }}" class="rounded-xl border border-white px-6 py-3.5 text-center font-bold text-white">Lihat Program Keahlian</a></div>
                </div>
            </div>
        @endif
    </section>
    <!-- 2. Verified school facts -->
    <section class="relative z-20 -mt-10 pb-4" aria-labelledby="facts-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="facts-title" class="sr-only">Fakta SMK Bina Mandiri Kota Bekasi</h2>
            <div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 shadow-xl md:grid-cols-4">
                <div class="bg-white p-5 text-center sm:p-7"><strong class="block text-3xl font-black text-[#1E3A8A] sm:text-4xl">{{ $schoolFacts['active_students'] ?? '1400+' }}</strong><span class="mt-1 block text-xs font-semibold text-slate-500 sm:text-sm">Siswa Aktif</span></div>
                <div class="bg-white p-5 text-center sm:p-7"><strong class="block text-3xl font-black text-[#1E3A8A] sm:text-4xl">{{ $schoolFacts['teachers'] ?? '85' }}</strong><span class="mt-1 block text-xs font-semibold text-slate-500 sm:text-sm">Guru Berpengalaman</span></div>
                <div class="bg-white p-5 text-center sm:p-7"><strong class="block text-3xl font-black text-[#1E3A8A] sm:text-4xl">{{ $schoolFacts['programs'] ?? '3' }}</strong><span class="mt-1 block text-xs font-semibold text-slate-500 sm:text-sm">Program Keahlian</span></div>
                <div class="bg-white p-5 text-center sm:p-7"><strong class="block text-3xl font-black text-[#1E3A8A] sm:text-4xl">{{ $foundedYear }}</strong><span class="mt-1 block text-xs font-semibold text-slate-500 sm:text-sm">Berdiri Sejak</span></div>
            </div>
        </div>
    </section>

    <!-- 2b. Announcements and PPDB brochure: only render verified CMS records -->
    @if($announcements->count() > 0 || $brochure)
        <section id="pengumuman" class="bg-white py-16 sm:py-20" aria-labelledby="announcement-title">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Informasi Terbaru</p>
                    <h2 id="announcement-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Pengumuman & Brosur SPMB</h2>
                    <p class="mt-3 text-slate-600">Ikuti pengumuman resmi sekolah dan unduh brosur SPMB untuk informasi pendaftaran secara lengkap.</p>
                </div>
                <div class="mt-10 grid gap-6 lg:grid-cols-[1.5fr_1fr] lg:items-start">
                    @if($announcements->count() > 0)
                        <div class="grid gap-5 sm:grid-cols-2" x-data="{ lightboxUrl: null, lightboxTitle: '' }" @keydown.escape.window="lightboxUrl = null">
                            @foreach($announcements as $announcement)
                                @php $announcementCard = 'group block w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl text-left'; @endphp
                                @if($announcement->link_url)
                                    <a href="{{ $announcement->link_url }}" target="_blank" rel="noopener noreferrer" class="{{ $announcementCard }}">
                                        <div class="relative aspect-[4/5] overflow-hidden bg-blue-50 sm:aspect-square"><img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" class="h-full w-full object-contain transition duration-500 group-hover:scale-105" loading="lazy"></div>
                                        <div class="p-5"><h3 class="text-base font-black text-[#0B1F4B] group-hover:text-[#1D4ED8]">{{ $announcement->title }}</h3><span class="mt-3 inline-flex items-center text-sm font-bold text-[#1D4ED8]">Lihat detail <span class="ml-1" aria-hidden="true">→</span></span></div>
                                    </a>
                                @else
                                    <button type="button" @click="lightboxUrl = '{{ $announcement->image_url }}'; lightboxTitle = '{{ addslashes($announcement->title) }}'" class="{{ $announcementCard }}">
                                        <div class="relative aspect-[4/5] overflow-hidden bg-blue-50 sm:aspect-square"><img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" class="h-full w-full object-contain transition duration-500 group-hover:scale-105" loading="lazy"></div>
                                        <div class="p-5"><h3 class="text-base font-black text-[#0B1F4B]">{{ $announcement->title }}</h3><span class="mt-3 inline-flex items-center text-sm font-bold text-[#1D4ED8]">Perbesar gambar <span class="ml-1" aria-hidden="true">⤢</span></span></div>
                                    </button>
                                @endif
                            @endforeach

                            <!-- Lightbox: enlarge announcement poster on click -->
                            <div x-show="lightboxUrl" x-cloak @click.self="lightboxUrl = null" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/85 p-4" style="display: none;">
                                <div class="relative max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl" @click.stop>
                                    <button type="button" @click="lightboxUrl = null" class="absolute right-3 top-3 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-xl font-bold text-slate-700 shadow hover:bg-white" aria-label="Tutup">×</button>
                                    <img :src="lightboxUrl" :alt="lightboxTitle" class="max-h-[90vh] w-full object-contain">
                                    <p x-show="lightboxTitle" x-text="lightboxTitle" class="p-4 text-center text-sm font-bold text-[#0B1F4B]"></p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($brochure)
                        <aside class="overflow-hidden rounded-2xl border border-slate-200 bg-[#0B1F4B] text-white shadow-lg">
                            @if($brochure['is_image'])
                                <img src="{{ $brochure['url'] }}" alt="{{ $brochure['title'] }}" class="h-56 w-full object-cover" loading="lazy">
                            @else
                                <div class="flex h-40 items-center justify-center bg-white/10 text-5xl" aria-hidden="true">📄</div>
                            @endif
                            <div class="p-6">
                                <p class="text-sm font-bold uppercase tracking-[.18em] text-blue-300">Brosur Resmi</p>
                                <h3 class="mt-2 text-xl font-black">{{ $brochure['title'] }}</h3>
                                @if($brochure['description'])<p class="mt-3 text-sm leading-relaxed text-blue-100">{{ $brochure['description'] }}</p>@endif
                                <a href="{{ $brochure['url'] }}" target="_blank" rel="noopener noreferrer" download class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#3B82F6] px-5 py-3 font-bold text-white transition hover:bg-blue-500">Unduh Brosur <span class="ml-2" aria-hidden="true">↓</span></a>
                            </div>
                        </aside>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- 3. Why choose us -->
    <section class="bg-slate-50 py-16 sm:py-20" aria-labelledby="why-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Mengapa Memilih Kami</p>
                <h2 id="why-title" class="mt-3 text-3xl font-black tracking-tight text-[#0B1F4B] sm:text-4xl">Sekolah vokasi yang dekat dengan kebutuhan masa depan</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">Ikhlas Berkarya Pelayanan Prima menjadi semangat kami dalam mendampingi siswa belajar, bertumbuh, dan menyiapkan langkah setelah lulus.</p>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-[#1E3A8A]" aria-hidden="true">⚙</div><h3 class="mt-5 text-lg font-bold text-[#0B1F4B]">Belajar berbasis praktik</h3><p class="mt-2 text-sm leading-relaxed text-slate-600">Siswa mengembangkan kompetensi melalui pembelajaran kejuruan dan pengalaman praktik yang relevan.</p></article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-[#1E3A8A]" aria-hidden="true">👨‍🏫</div><h3 class="mt-5 text-lg font-bold text-[#0B1F4B]">Didampingi 65 guru</h3><p class="mt-2 text-sm leading-relaxed text-slate-600">Tenaga pendidik mendampingi proses belajar dengan fokus pada kompetensi dan karakter.</p></article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-[#1E3A8A]" aria-hidden="true">🤝</div><h3 class="mt-5 text-lg font-bold text-[#0B1F4B]">Terhubung dengan industri</h3><p class="mt-2 text-sm leading-relaxed text-slate-600">Kemitraan dengan enam institusi industri membuka konteks belajar dan wawasan dunia kerja.</p></article>
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl text-[#1E3A8A]" aria-hidden="true">★</div><h3 class="mt-5 text-lg font-bold text-[#0B1F4B]">Karakter dan prestasi</h3><p class="mt-2 text-sm leading-relaxed text-slate-600">Pendidikan diarahkan untuk membangun siswa yang berkarakter, percaya diri, dan terus berprestasi.</p></article>
            </div>
        </div>
    </section>

    <!-- 4. Programs -->
    <section id="program-keahlian" class="bg-white py-16 sm:py-20" aria-labelledby="program-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div><p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Pilihan Masa Depan</p><h2 id="program-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Program Keahlian</h2><p class="mt-3 max-w-2xl text-slate-600">Kenali kompetensi yang dapat menjadi langkah awal menuju dunia kerja, wirausaha, atau pendidikan lanjutan.</p></div>
                <a href="{{ route('public.competencies.index') }}" class="inline-flex items-center font-bold text-[#1D4ED8] hover:text-[#1E3A8A]">Lihat semua program <span class="ml-2" aria-hidden="true">→</span></a>
            </div>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach($programs as $program)
                    <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative flex h-40 items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100 p-6">
                            @if(!empty($program['image']))
                                <img src="{{ Storage::url($program['image']) }}" alt="Logo {{ $program['name'] }}" class="max-h-24 max-w-[55%] object-contain transition duration-300 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-3xl text-blue-300 shadow-sm" aria-hidden="true">⚙</div>
                            @endif
                            <span class="absolute left-4 top-4 rounded-full bg-[#0B1F4B]/90 px-3 py-1 text-xs font-bold text-white">Program Keahlian</span>
                        </div>
                        <div class="p-6"><h3 class="text-xl font-black text-[#0B1F4B]">{{ $program['name'] }}</h3><p class="mt-3 min-h-12 text-sm leading-relaxed text-slate-600">{{ $program['description'] ?: 'Informasi kompetensi program tersedia pada halaman detail.' }}</p>
                            @if(!empty($program['student_count']))<p class="mt-4 text-sm font-bold text-[#1D4ED8]">{{ $program['student_count'] }} siswa terdata</p>@else<p class="mt-4 text-xs text-slate-500">Jumlah siswa per jurusan ditampilkan setelah data akademik diverifikasi.</p>@endif
                            @if(!empty($program['slug']))<a href="{{ route('public.competencies.show', $program['slug']) }}" class="mt-5 inline-flex font-bold text-[#1D4ED8]">Pelajari program <span class="ml-2" aria-hidden="true">→</span></a>@else<a href="{{ route('public.competencies.index') }}" class="mt-5 inline-flex font-bold text-[#1D4ED8]">Lihat detail program <span class="ml-2" aria-hidden="true">→</span></a>@endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    <!-- 5. Alumni testimonials: only render verified CMS records -->
    @if(count($testimonials) > 0)
        <section class="bg-slate-50 py-16 sm:py-20" aria-labelledby="testimonial-title">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Cerita Alumni</p><h2 id="testimonial-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Langkah mereka setelah lulus</h2><div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $testimonial)
                    @if(!empty($testimonial['name']) && !empty($testimonial['quote']))<figure class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center gap-4">@if(!empty($testimonial['photo']))<img src="{{ asset('storage/' . $testimonial['photo']) }}" alt="Foto {{ $testimonial['name'] }}" class="h-14 w-14 rounded-full object-cover" loading="lazy">@else<div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 font-bold text-[#1E3A8A]">{{ strtoupper(substr($testimonial['name'], 0, 1)) }}</div>@endif<div><figcaption class="font-bold text-[#0B1F4B]">{{ $testimonial['name'] }}</figcaption>@if(!empty($testimonial['role']))<p class="text-sm text-slate-500">{{ $testimonial['role'] }}</p>@endif</div></div><blockquote class="mt-5 text-sm leading-relaxed text-slate-700">“{{ $testimonial['quote'] }}”</blockquote></figure>@endif
                @endforeach
            </div></div>
        </section>
    @endif

    <!-- 6. Industry partners and BKK -->
    <section id="mitra-bkk" class="bg-white py-16 sm:py-20" aria-labelledby="industry-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl"><p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Dunia Kerja</p><h2 id="industry-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Mitra Industri & Bursa Kerja Khusus</h2><p class="mt-4 text-lg leading-relaxed text-slate-600">Kemitraan membantu sekolah menjaga relevansi pembelajaran dengan kebutuhan dunia kerja.</p></div>
            <div class="mt-10 grid gap-8 lg:grid-cols-[1.4fr_.8fr] lg:items-start">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @forelse($industryPartners as $partner)
                        <div class="flex min-h-24 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-4 text-center">@if($partner->logo)<img src="{{ asset('storage/' . $partner->logo) }}" alt="Logo {{ $partner->name }}" class="max-h-14 max-w-full object-contain" loading="lazy">@else<span class="text-sm font-bold text-[#0B1F4B]">{{ $partner->name }}</span>@endif</div>
                    @empty
                        @foreach($partnerNames as $partnerName)<div class="flex min-h-24 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-4 text-center text-sm font-bold text-[#0B1F4B]">{{ $partnerName }}</div>@endforeach
                    @endforelse
                </div>
                <aside class="rounded-2xl bg-[#0B1F4B] p-6 text-white shadow-lg"><p class="text-sm font-bold uppercase tracking-[.18em] text-blue-300">BKK SMK Bina Mandiri</p><h3 class="mt-3 text-2xl font-black">Jembatan menuju dunia kerja</h3>@if($bkkPlacementRate)<p class="mt-5 text-5xl font-black text-amber-300">{{ $bkkPlacementRate }}</p><p class="mt-1 text-blue-100">tingkat penyaluran kerja alumni</p>@else<p class="mt-5 text-sm leading-relaxed text-blue-100">Angka penyaluran kerja alumni akan ditampilkan setelah data BKK diverifikasi dan diperbarui oleh sekolah.</p>@endif<a href="{{ route('info.contact') }}" class="mt-6 inline-flex rounded-xl bg-[#3B82F6] px-5 py-3 font-bold text-white hover:bg-blue-500">Tanya informasi BKK <span class="ml-2" aria-hidden="true">→</span></a></aside>
            </div>
        </div>
    </section>

    <!-- 7. Student achievement/news -->
    @if($latestNews->count() > 0)
        <section class="bg-slate-50 py-16 sm:py-20" aria-labelledby="news-title">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Kabar & Prestasi</p><h2 id="news-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Aktivitas dan pencapaian terbaru</h2></div><a href="{{ route('public.news.index') }}" class="font-bold text-[#1D4ED8]">Lihat semua berita <span aria-hidden="true">→</span></a></div><div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($latestNews as $news)<a href="{{ route('public.news.show', $news->slug) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">@if($news->featured_image)<img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="h-48 w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">@else<div class="flex h-48 items-center justify-center bg-blue-100 text-5xl text-blue-300" aria-hidden="true">★</div>@endif<div class="p-5">@if($news->category)<span class="text-xs font-bold uppercase tracking-wide text-[#3B82F6]">{{ $news->category->name }}</span>@endif<h3 class="mt-2 line-clamp-2 text-lg font-black text-[#0B1F4B] group-hover:text-[#1D4ED8]">{{ $news->title }}</h3><p class="mt-3 line-clamp-2 text-sm leading-relaxed text-slate-600">{{ Str::limit(strip_tags($news->excerpt ?? $news->content), 110) }}</p><time datetime="{{ optional($news->published_at)->toIso8601String() }}" class="mt-4 block text-xs text-slate-500">{{ optional($news->published_at)->translatedFormat('d F Y') }}</time></div></a>@endforeach
            </div></div>
        </section>
    @endif
    <!-- 7a. YouTube video: school profile, managed via admin Contact & Social settings -->
    @if($youtubeVideoId)
        <section id="video-profil" class="bg-white py-16 sm:py-20" aria-labelledby="video-title">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Video Profil</p>
                    <h2 id="video-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">Kenali SMK Bina Mandiri Kota Bekasi</h2>
                    <p class="mt-3 text-slate-600">Saksikan kegiatan pembelajaran, fasilitas, dan prestasi siswa-siswi kami.</p>
                </div>
                <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200 shadow-xl">
                    <div class="relative aspect-video">
                        <iframe
                            class="absolute inset-0 h-full w-full"
                            src="https://www.youtube.com/embed/{{ $youtubeVideoId }}"
                            title="Video Profil SMK Bina Mandiri Kota Bekasi"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- 7b. Instagram: official channel promo, links out to the live profile -->
    @if($instagramUrl)
        <section id="instagram" class="bg-white py-16 sm:py-20" aria-labelledby="instagram-title">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-[#405DE6] via-[#C13584] to-[#F77737] shadow-xl">
                    <div class="flex flex-col items-start gap-8 p-8 sm:p-12 lg:flex-row lg:items-center lg:justify-between">
                        <div class="text-white">
                            <p class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-[.2em] text-white/80">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.248.638.415 1.363.465 2.428.048 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.638.248-1.363.415-2.428.465-1.066.048-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.248-.638-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.638-.248 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 1.802c-2.67 0-2.987.01-4.04.058-.976.045-1.505.207-1.858.344-.466.181-.8.398-1.15.748-.35.35-.567.684-.748 1.15-.137.353-.3.882-.344 1.858-.048 1.053-.058 1.37-.058 4.04 0 2.67.01 2.987.058 4.04.045.976.207 1.505.344 1.858.181.466.399.8.748 1.15.35.35.684.567 1.15.748.353.137.882.3 1.858.344 1.053.048 1.37.058 4.04.058 2.67 0 2.987-.01 4.04-.058.976-.045 1.505-.207 1.858-.344.466-.181.8-.399 1.15-.748.35-.35.567-.684.748-1.15.137-.353.3-.882.344-1.858.048-1.053.058-1.37.058-4.04 0-2.67-.01-2.987-.058-4.04-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.858-.344-1.053-.048-1.37-.058-4.04-.058zm0 4.595a5.603 5.603 0 110 11.206 5.603 5.603 0 010-11.206zm0 1.802a3.801 3.801 0 100 7.602 3.801 3.801 0 000-7.602zm5.633-3.594a1.32 1.32 0 110 2.64 1.32 1.32 0 010-2.64z"/></svg>
                                Instagram Resmi
                            </p>
                            <h2 id="instagram-title" class="mt-3 text-3xl font-black leading-tight sm:text-4xl">Ikuti keseharian dan kegiatan siswa di Instagram kami</h2>
                            <p class="mt-4 max-w-xl text-lg leading-relaxed text-white/90">Foto dan video kegiatan praktik, prestasi siswa, serta informasi terkini SPMB dibagikan langsung melalui akun Instagram resmi sekolah{{ $instagramHandle ? ' ' . $instagramHandle : '' }}.</p>
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="mt-8 inline-flex items-center justify-center rounded-xl bg-white px-6 py-3.5 text-base font-bold text-[#C13584] shadow-lg transition hover:bg-white/90 focus:outline-none focus:ring-4 focus:ring-white/50">
                                Kunjungi Instagram Kami <span class="ml-2" aria-hidden="true">→</span>
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

    <!-- 8. FAQ -->
    <section id="faq" class="bg-white py-16 sm:py-20" aria-labelledby="faq-title">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"><div class="text-center"><p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Pertanyaan Umum</p><h2 id="faq-title" class="mt-3 text-3xl font-black text-[#0B1F4B] sm:text-4xl">FAQ SPMB</h2><p class="mt-3 text-slate-600">Informasi ringkas untuk membantu calon siswa dan orang tua memulai proses pendaftaran.</p></div><div class="mt-10 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white shadow-sm">
            @foreach($faqItems as $faq)<details class="group p-5 sm:p-6"><summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-bold text-[#0B1F4B]"><span>{{ $faq['question'] }}</span><span class="text-2xl text-[#3B82F6] transition group-open:rotate-45" aria-hidden="true">+</span></summary><p class="mt-4 max-w-3xl text-sm leading-relaxed text-slate-600">{{ $faq['answer'] }}</p></details>@endforeach
        </div></div>
    </section>

    <!-- 9. Final CTA and verified contact/social links -->
    <section id="daftar" class="relative overflow-hidden bg-[#0B1F4B] py-16 pb-32 text-white sm:py-20 sm:pb-24" aria-labelledby="final-cta-title">
        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#3B82F6]/25 blur-3xl"></div><div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"><div class="grid gap-10 lg:grid-cols-[1.1fr_.9fr] lg:items-center"><div><p class="text-sm font-bold uppercase tracking-[.2em] text-amber-300">Langkah berikutnya</p><h2 id="final-cta-title" class="mt-3 text-3xl font-black sm:text-5xl">Siap menyiapkan masa depan bersama SMK Bina Mandiri?</h2><p class="mt-5 max-w-2xl text-lg leading-relaxed text-blue-100">Dapatkan informasi SPMB, program keahlian, dan layanan sekolah melalui kanal resmi kami.</p><div class="mt-8 flex flex-col gap-3 sm:flex-row"><a href="{{ route('ppdb.register') }}" class="inline-flex items-center justify-center rounded-xl bg-[#3B82F6] px-6 py-3.5 font-bold text-white hover:bg-blue-500">Daftar SPMB 2026 <span class="ml-2" aria-hidden="true">→</span></a><a href="{{ route('info.contact') }}" class="inline-flex items-center justify-center rounded-xl border border-white/60 px-6 py-3.5 font-bold text-white hover:bg-white/10">Hubungi sekolah</a></div></div><div class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur"><h3 class="text-xl font-black">Kontak resmi</h3><div class="mt-5 space-y-4 text-sm text-blue-100">@if(!empty($contact['address']))<p class="flex gap-3"><span aria-hidden="true">📍</span><span>{{ $contact['address'] }}</span></p>@endif @if(!empty($contact['phone']))<a href="tel:{{ $contact['phone'] }}" class="flex gap-3 hover:text-white"><span aria-hidden="true">☎</span><span>{{ $contact['phone'] }}</span></a>@endif @if(!empty($contact['email']))<a href="mailto:{{ $contact['email'] }}" class="flex gap-3 hover:text-white"><span aria-hidden="true">✉</span><span>{{ $contact['email'] }}</span></a>@endif @if(!empty($contact['whatsapp']))<a href="https://wa.me/{{ $contact['whatsapp'] }}" target="_blank" rel="noopener noreferrer" class="flex gap-3 font-bold text-green-300 hover:text-green-200"><span aria-hidden="true">◉</span><span>WhatsApp resmi sekolah</span></a>@endif</div>@if(count($socialLinks) > 0)<div class="mt-6 border-t border-white/15 pt-5"><p class="text-xs font-bold uppercase tracking-wider text-blue-200">Ikuti kanal resmi</p><div class="mt-3 flex flex-wrap gap-2">@foreach($socialLinks as $social)<a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-white/20 px-3 py-2 text-xs font-bold text-white hover:bg-white/10">{{ $social['label'] }}</a>@endforeach</div></div>@endif</div></div></div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .homepage-conversion .swiper-pagination-bullet { background: rgba(255,255,255,.7); opacity: 1; }
    .homepage-conversion .swiper-pagination-bullet-active { background: #FBBF24; }

    /* Motion ringan untuk hero: tetap mempertahankan warna, ukuran, dan layout asli. */
    .homepage-conversion .homepage-hero-swiper .swiper-slide > img {
        transform: scale(1.03);
        transform-origin: center center;
        transition: transform 700ms ease-out;
        will-change: transform;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > img {
        animation: homepageHeroImageZoom 12s ease-in-out infinite alternate;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div {
        animation: homepageHeroFloat 5s ease-in-out 900ms infinite;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active a span[aria-hidden="true"] {
        display: inline-block;
        animation: homepageHeroArrow 1.8s ease-in-out infinite;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide:not(.swiper-slide-active) > .relative.z-10 {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > * {
        opacity: 0;
        animation: homepageHeroContentIn 700ms cubic-bezier(.22, 1, .36, 1) forwards;
        will-change: opacity, transform;
    }

    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > :nth-child(1) { animation-delay: 80ms; }
    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > :nth-child(2) { animation-delay: 170ms; }
    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > :nth-child(3) { animation-delay: 260ms; }
    .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > :nth-child(4) { animation-delay: 350ms; }

    @keyframes homepageHeroImageZoom {
        from { transform: scale(1.03); }
        to { transform: scale(1.09); }
    }

    @keyframes homepageHeroFloat {
        0%, 100% { transform: translate3d(0, 0, 0); }
        50% { transform: translate3d(0, -5px, 0); }
    }

    @keyframes homepageHeroArrow {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(4px); }
    }

    @keyframes homepageHeroContentIn {
        from { opacity: 0; transform: translate3d(0, 18px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
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

        .homepage-conversion .homepage-hero-swiper .swiper-slide > img,
        .homepage-conversion .homepage-hero-swiper .swiper-slide-active > img,
        .homepage-conversion .homepage-hero-swiper .swiper-slide-active > .relative.z-10 > div > * {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
            transition: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var hero = document.querySelector('.homepage-hero-swiper');
    if (!hero || typeof Swiper === 'undefined') return;
    new Swiper(hero, {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed: 700,
        autoplay: { delay: 5500, disableOnInteraction: false, pauseOnMouseEnter: true },
        pagination: { el: '.homepage-hero-pagination', clickable: true },
        navigation: { nextEl: '.homepage-hero-next', prevEl: '.homepage-hero-prev' },
        keyboard: { enabled: true },
        a11y: { enabled: true }
    });
});
</script>
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => collect($faqItems)->map(fn ($faq) => ['@type' => 'Question', 'name' => $faq['question'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']]])->values()->all()], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
