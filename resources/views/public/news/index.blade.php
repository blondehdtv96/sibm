@extends('layouts.public-tailwind')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . 'Berita & Kegiatan - ' . config('school.name'))
@section('description', 'Berita, kegiatan, dan prestasi terbaru ' . config('school.name') . '. Ikuti perkembangan sekolah langsung dari sumber resminya.')
@section('og_type', 'website')
@section('og_title', 'Berita & Kegiatan - ' . config('school.name'))
@section('og_description', 'Kabar terbaru seputar kegiatan, prestasi, dan pengumuman ' . config('school.name') . '.')

@section('content')
@php
    // Ringkas teks berita: buang tag HTML dan entitas seperti &nbsp; agar
    // kutipan di kartu selalu rapi walau kontennya dibuat lewat editor.
    $ringkas = function ($text, $limit = 140) {
        $clean = html_entity_decode(strip_tags((string) $text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $clean = trim(preg_replace('/\s+/u', ' ', str_replace("\xC2\xA0", ' ', $clean)) ?? '');

        return $clean === '' ? '' : Str::limit($clean, $limit);
    };
@endphp

<!-- Header Halaman -->
<section class="bg-[#0B1F4B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-24 sm:pb-16 sm:pt-32">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-blue-200" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
            <span aria-hidden="true">/</span>
            <span class="font-semibold text-white">Berita</span>
            @if($selectedCategory)
                <span aria-hidden="true">/</span>
                <span class="font-semibold text-white">{{ $selectedCategory->name }}</span>
            @endif
        </nav>

        <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-sm font-bold uppercase tracking-[.2em] text-[#60A5FA]">Informasi Sekolah</p>
                <h1 class="mt-3 text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">
                    @if(request('search'))
                        Hasil pencarian &ldquo;{{ request('search') }}&rdquo;
                    @elseif($selectedCategory)
                        {{ $selectedCategory->name }}
                    @else
                        Berita &amp; Kegiatan
                    @endif
                </h1>
                <p class="mt-4 text-base leading-relaxed text-blue-100 sm:text-lg">
                    @if($selectedCategory && $selectedCategory->description)
                        {{ $selectedCategory->description }}
                    @else
                        Kabar kegiatan belajar, prestasi siswa, dan pengumuman resmi {{ config('school.name') }}.
                    @endif
                </p>
            </div>

            <dl class="grid w-full max-w-md grid-cols-3 gap-px overflow-hidden rounded-2xl border border-white/15 bg-white/15 text-center">
                <div class="bg-[#0B1F4B] px-3 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-blue-200">Artikel</dt>
                    <dd class="mt-1 text-2xl font-black">{{ $news->total() }}</dd>
                </div>
                <div class="bg-[#0B1F4B] px-3 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-blue-200">Kategori</dt>
                    <dd class="mt-1 text-2xl font-black">{{ $categories->where('published_news_count', '>', 0)->count() }}</dd>
                </div>
                <div class="bg-[#0B1F4B] px-3 py-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-blue-200">Terbaru</dt>
                    <dd class="mt-1 text-sm font-bold leading-tight">
                        {{ $latestPublishedAt ? $latestPublishedAt->translatedFormat('d M Y') : '-' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</section>

@if($headlines->isNotEmpty())
    <!-- Sorotan: slider berita utama -->
    <section class="bg-white py-10 sm:py-14" aria-labelledby="headline-title">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Sorotan</p>
                    <h2 id="headline-title" class="mt-2 text-2xl font-black text-[#0B1F4B] sm:text-3xl">Berita utama</h2>
                </div>
                <div class="hidden items-center gap-2 sm:flex">
                    <button type="button" class="headline-prev flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-lg text-[#0B1F4B] shadow-sm transition hover:bg-slate-50" aria-label="Sorotan sebelumnya">&#8592;</button>
                    <button type="button" class="headline-next flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-lg text-[#0B1F4B] shadow-sm transition hover:bg-slate-50" aria-label="Sorotan berikutnya">&#8594;</button>
                </div>
            </div>

            <div class="swiper headline-swiper mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-slate-900 shadow-xl">
                <div class="swiper-wrapper">
                    @foreach($headlines as $index => $headline)
                        <div class="swiper-slide">
                            <a href="{{ route('public.news.show', $headline->slug) }}" class="group relative block">
                                <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-800 sm:aspect-[21/9]">
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-[#0B1F4B] to-[#1E3A8A] text-5xl text-blue-300/60" aria-hidden="true">&#9733;</div>
                                    <img src="{{ asset('storage/' . $headline->featured_image) }}"
                                         alt="{{ $headline->title }}"
                                         class="relative h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                         onerror="this.style.display='none'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/55 to-transparent"></div>
                                </div>

                                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-8 lg:p-10">
                                    <div class="flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-wide">
                                        @if($headline->category)
                                            <span class="rounded-full bg-[#3B82F6] px-3 py-1 text-white">{{ $headline->category->name }}</span>
                                        @endif
                                        <time datetime="{{ optional($headline->published_at)->toIso8601String() }}" class="text-blue-100">
                                            {{ optional($headline->published_at)->translatedFormat('d F Y') }}
                                        </time>
                                    </div>
                                    <h3 class="mt-3 max-w-3xl text-lg font-black leading-snug text-white sm:text-2xl lg:text-3xl">
                                        {{ $headline->title }}
                                    </h3>
                                    @if($ringkas($headline->excerpt ?? $headline->content, 160))
                                        <p class="mt-3 hidden max-w-2xl text-sm leading-relaxed text-blue-50 sm:block">
                                            {{ $ringkas($headline->excerpt ?? $headline->content, 160) }}
                                        </p>
                                    @endif
                                    <span class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-white">
                                        Baca berita <span aria-hidden="true" class="transition group-hover:translate-x-1">&#8594;</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if($headlines->count() > 1)
                    <div class="headline-pagination absolute bottom-4 right-5 z-20 !w-auto"></div>
                @endif
            </div>
        </div>
    </section>
@endif

<!-- Pencarian & Filter -->
<section class="border-y border-slate-200 bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('public.news.index') }}" class="w-full lg:max-w-md">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <label for="news-search" class="sr-only">Cari berita</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="news-search"
                           type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari judul atau isi berita..."
                           class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-24 text-sm text-slate-900 shadow-sm transition focus:border-[#3B82F6] focus:ring-2 focus:ring-[#3B82F6]/30">
                    <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-lg bg-[#1D4ED8] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#1E40AF]">
                        Cari
                    </button>
                </div>
            </form>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('public.news.index') }}"
                   class="rounded-full px-4 py-2 text-sm font-bold transition {{ !request('category') ? 'bg-[#0B1F4B] text-white shadow-sm' : 'border border-slate-300 bg-white text-slate-700 hover:border-[#3B82F6] hover:text-[#1D4ED8]' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    @if($category->published_news_count > 0)
                        <a href="{{ route('public.news.index', ['category' => $category->slug]) }}"
                           class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-bold transition {{ request('category') === $category->slug ? 'bg-[#0B1F4B] text-white shadow-sm' : 'border border-slate-300 bg-white text-slate-700 hover:border-[#3B82F6] hover:text-[#1D4ED8]' }}">
                            {{ $category->name }}
                            <span class="rounded-full px-1.5 py-0.5 text-[11px] {{ request('category') === $category->slug ? 'bg-white/20' : 'bg-slate-100 text-slate-500' }}">
                                {{ $category->published_news_count }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        @if(request()->hasAny(['search', 'category']))
            <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-600">
                <span>Menampilkan {{ $news->count() }} dari {{ $news->total() }} artikel.</span>
                <a href="{{ route('public.news.index') }}" class="font-bold text-[#1D4ED8] hover:underline">Hapus filter</a>
            </div>
        @endif
    </div>
</section>

<!-- Daftar Berita -->
<section class="bg-white py-14 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($news->count() > 0)
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Arsip</p>
                    <h2 class="mt-2 text-2xl font-black text-[#0B1F4B] sm:text-3xl">
                        @if(request('search'))
                            Hasil pencarian
                        @elseif($selectedCategory)
                            Artikel {{ $selectedCategory->name }}
                        @else
                            Semua berita
                        @endif
                    </h2>
                </div>
                <p class="hidden text-sm text-slate-500 sm:block">
                    Halaman {{ $news->currentPage() }} dari {{ $news->lastPage() }}
                </p>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($news as $article)
                    <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <a href="{{ route('public.news.show', $article->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100">
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-slate-100 text-4xl text-blue-300" aria-hidden="true">&#9733;</div>
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                     alt="{{ $article->title }}"
                                     class="relative h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                     loading="lazy"
                                     onerror="this.style.display='none'">
                            @endif
                            @if($article->category)
                                <span class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-[#1D4ED8] shadow-sm backdrop-blur">
                                    {{ $article->category->name }}
                                </span>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-5">
                            <time datetime="{{ optional($article->published_at)->toIso8601String() }}" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                {{ optional($article->published_at)->translatedFormat('d F Y') }}
                            </time>

                            <h3 class="mt-2 text-base font-black leading-snug text-[#0B1F4B] transition group-hover:text-[#1D4ED8]">
                                <a href="{{ route('public.news.show', $article->slug) }}" class="line-clamp-3">{{ $article->title }}</a>
                            </h3>

                            @if($ringkas($article->excerpt ?? $article->content, 120))
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                    {{ $ringkas($article->excerpt ?? $article->content, 120) }}
                                </p>
                            @endif

                            <a href="{{ route('public.news.show', $article->slug) }}"
                               class="mt-auto inline-flex items-center gap-2 pt-4 text-sm font-bold text-[#1D4ED8]">
                                Baca selengkapnya
                                <span aria-hidden="true" class="transition group-hover:translate-x-1">&#8594;</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($news->hasPages())
                <div class="mt-12">
                    {{ $news->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Belum ada hasil -->
            <div class="mx-auto max-w-lg rounded-2xl border border-slate-200 bg-slate-50 px-6 py-14 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h2 class="mt-6 text-xl font-black text-[#0B1F4B]">
                    @if(request('search'))
                        Tidak ada berita yang cocok
                    @elseif($selectedCategory)
                        Belum ada artikel di kategori ini
                    @else
                        Belum ada berita
                    @endif
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                    @if(request('search'))
                        Kata kunci &ldquo;{{ request('search') }}&rdquo; belum menemukan hasil. Coba kata lain atau lihat seluruh arsip berita.
                    @elseif($selectedCategory)
                        Artikel untuk kategori {{ $selectedCategory->name }} akan tampil di sini setelah dipublikasikan.
                    @else
                        Berita akan tampil di halaman ini setelah dipublikasikan oleh sekolah.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('public.news.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#1E40AF]">
                        Lihat semua berita <span aria-hidden="true">&#8594;</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- Ajakan -->
<section class="bg-slate-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start gap-6 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-xl font-black text-[#0B1F4B] sm:text-2xl">Ingin tahu lebih banyak tentang sekolah kami?</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    Pelajari program keahlian yang tersedia atau hubungi sekolah untuk informasi pendaftaran dan kunjungan.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('public.competencies.index') }}" class="rounded-xl bg-[#1D4ED8] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#1E40AF]">
                    Program Keahlian
                </a>
                <a href="{{ route('info.contact') }}" class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-[#0B1F4B] transition hover:border-[#3B82F6] hover:text-[#1D4ED8]">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .headline-swiper { position: relative; }

    .headline-swiper .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: #ffffff;
        opacity: .45;
        transition: all .3s ease;
    }

    .headline-swiper .swiper-pagination-bullet-active {
        width: 26px;
        border-radius: 9999px;
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var headline = document.querySelector('.headline-swiper');

    if (!headline || typeof Swiper === 'undefined') {
        return;
    }

    new Swiper(headline, {
        loop: headline.querySelectorAll('.swiper-slide').length > 1,
        speed: 600,
        autoplay: { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
        pagination: { el: '.headline-pagination', clickable: true },
        navigation: { nextEl: '.headline-next', prevEl: '.headline-prev' },
        keyboard: { enabled: true, onlyInViewport: true },
        a11y: { enabled: true },
        grabCursor: true
    });
});
</script>
@endpush
