@extends('layouts.public-tailwind')

@php
    $plainContent = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $news->content), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? '');
    $metaDescription = $news->excerpt ? Str::limit(strip_tags($news->excerpt), 160) : Str::limit($plainContent, 160);
    $wordCount = $plainContent === '' ? 0 : str_word_count($plainContent);
    $readingMinutes = max(1, (int) ceil($wordCount / 200));
    $shareUrl = route('public.news.show', $news->slug);
    $galleryImages = $news->images ?? collect();

    // Sebagian berita memakai judul sebagai excerpt; jangan tampilkan dua kali.
    $excerptText = trim(strip_tags((string) $news->excerpt));
    $normalize = fn ($value) => Str::lower(trim(preg_replace('/[^a-z0-9]+/i', ' ', (string) $value) ?? ''));
    $showExcerpt = $excerptText !== '' && $normalize($excerptText) !== $normalize($news->title);
@endphp

@section('title', $news->title . ' - ' . config('school.name'))
@section('description', $metaDescription)
@section('og_type', 'article')
@section('og_title', $news->title)
@section('og_description', $metaDescription)
@if($news->featured_image)
    @section('og_image', asset('storage/' . $news->featured_image))
    @section('twitter_image', asset('storage/' . $news->featured_image))
@endif

@section('content')
<article class="bg-white">
    <!-- Kepala artikel -->
    <header class="bg-[#0B1F4B] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 pt-24 sm:pb-14 sm:pt-32">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-blue-200" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('public.news.index') }}" class="transition hover:text-white">Berita</a>
                @if($news->category)
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" class="transition hover:text-white">
                        {{ $news->category->name }}
                    </a>
                @endif
            </nav>

            <div class="mt-6 max-w-4xl">
                @if($news->category)
                    <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}"
                       class="inline-flex rounded-full bg-[#3B82F6] px-3 py-1 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-blue-500">
                        {{ $news->category->name }}
                    </a>
                @endif

                <h1 class="mt-4 text-2xl font-black leading-tight sm:text-4xl lg:text-[2.75rem]">
                    {{ $news->title }}
                </h1>

                <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-blue-100">
                    <time datetime="{{ optional($news->published_at)->toIso8601String() }}" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ optional($news->published_at)->translatedFormat('l, d F Y') }}
                    </time>

                    @if($news->author)
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $news->author->name }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $readingMinutes }} menit baca
                    </span>

                    @if($galleryImages->count() > 0)
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $galleryImages->count() }} foto
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="bg-slate-50 py-10 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                <!-- Isi artikel -->
                <div class="lg:col-span-8">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        @if($news->featured_image)
                            <!-- Gambar utama: latar buram + gambar utuh, jadi foto apa pun rasionya tetap rapi -->
                            <figure class="relative aspect-[16/9] w-full overflow-hidden bg-slate-900">
                                <img src="{{ asset('storage/' . $news->featured_image) }}"
                                     alt=""
                                     aria-hidden="true"
                                     class="absolute inset-0 h-full w-full scale-110 object-cover opacity-45 blur-xl"
                                     onerror="this.style.display='none'">
                                <img src="{{ asset('storage/' . $news->featured_image) }}"
                                     alt="{{ $news->title }}"
                                     class="relative h-full w-full object-contain"
                                     onerror="this.closest('figure').remove()">
                            </figure>
                        @endif

                        <div class="p-6 sm:p-8 lg:p-10">
                            @if($showExcerpt)
                                <p class="border-l-4 border-[#3B82F6] bg-blue-50/60 px-5 py-4 text-base font-medium leading-relaxed text-slate-700 sm:text-lg">
                                    {{ $excerptText }}
                                </p>
                            @endif

                            <div class="article-content-html {{ $showExcerpt ? 'mt-8' : '' }}">
                                {!! $news->content !!}
                            </div>

                            @if($galleryImages->count() > 0)
                                <!-- Galeri foto -->
                                <section class="mt-12" aria-labelledby="gallery-title" data-gallery>
                                    <div class="flex items-end justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-bold uppercase tracking-[.2em] text-[#3B82F6]">Dokumentasi</p>
                                            <h2 id="gallery-title" class="mt-2 text-2xl font-black text-[#0B1F4B]">Galeri Foto</h2>
                                        </div>
                                        <p class="shrink-0 text-sm font-semibold text-slate-500">
                                            <span data-gallery-current>1</span> / {{ $galleryImages->count() }}
                                        </p>
                                    </div>

                                    <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-slate-900">
                                        <div class="swiper gallery-swiper relative">
                                            <div class="swiper-wrapper">
                                                @foreach($galleryImages as $index => $image)
                                                    <div class="swiper-slide">
                                                        <div class="relative h-[260px] w-full overflow-hidden bg-slate-900 sm:h-[380px] lg:h-[460px]">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                 alt=""
                                                                 aria-hidden="true"
                                                                 class="absolute inset-0 h-full w-full scale-110 object-cover opacity-40 blur-2xl"
                                                                 loading="lazy"
                                                                 onerror="this.style.display='none'">
                                                            <button type="button"
                                                                    class="group relative flex h-full w-full cursor-zoom-in items-center justify-center"
                                                                    data-lightbox-open="{{ $index }}"
                                                                    aria-label="Perbesar foto {{ $index + 1 }}">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                     alt="{{ $image->caption ?: 'Foto dokumentasi ' . $news->title }}"
                                                                     class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-[1.02]"
                                                                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                                                     onerror="this.style.display='none'">
                                                                <span class="pointer-events-none absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-slate-950/50 text-white opacity-0 transition group-hover:opacity-100">
                                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @if($galleryImages->count() > 1)
                                                <button type="button" class="gallery-prev absolute left-3 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-slate-950/55 text-xl text-white shadow-lg backdrop-blur transition hover:bg-slate-950/80" aria-label="Foto sebelumnya">&#8592;</button>
                                                <button type="button" class="gallery-next absolute right-3 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-slate-950/55 text-xl text-white shadow-lg backdrop-blur transition hover:bg-slate-950/80" aria-label="Foto berikutnya">&#8594;</button>
                                            @endif
                                        </div>

                                        <!-- Keterangan foto -->
                                        <p class="min-h-[2.75rem] border-t border-white/10 px-5 py-3 text-sm leading-relaxed text-slate-200" data-gallery-caption>
                                            {{ $galleryImages->first()->caption ?: 'Dokumentasi ' . $news->title }}
                                        </p>
                                    </div>

                                    @if($galleryImages->count() > 1)
                                        <!-- Deretan thumbnail -->
                                        <div class="mt-4 flex gap-3 overflow-x-auto pb-2" data-gallery-thumbs>
                                            @foreach($galleryImages as $index => $image)
                                                <button type="button"
                                                        data-gallery-thumb="{{ $index }}"
                                                        class="relative h-16 w-24 shrink-0 overflow-hidden rounded-lg border-2 border-transparent bg-slate-100 transition hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-[#3B82F6] {{ $index === 0 ? '' : 'opacity-60' }}"
                                                        aria-label="Lihat foto {{ $index + 1 }}">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                         alt=""
                                                         class="h-full w-full object-cover"
                                                         loading="lazy"
                                                         onerror="this.style.display='none'">
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </section>
                            @endif

                            <!-- Bagikan -->
                            <div class="mt-12 flex flex-col gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="text-sm font-bold text-[#0B1F4B]">Bagikan:</span>
                                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . $shareUrl) }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-500 hover:text-emerald-600">
                                        WhatsApp
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-blue-500 hover:text-blue-600">
                                        Facebook
                                    </a>
                                    <button type="button"
                                            data-copy-link="{{ $shareUrl }}"
                                            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-[#3B82F6] hover:text-[#1D4ED8]">
                                        Salin tautan
                                    </button>
                                </div>

                                <a href="{{ route('public.news.index') }}"
                                   class="inline-flex items-center gap-2 text-sm font-bold text-[#1D4ED8] hover:underline">
                                    <span aria-hidden="true">&#8592;</span> Kembali ke daftar berita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="space-y-6 lg:col-span-4">
                    @if($relatedNews->count() > 0)
                        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-black text-[#0B1F4B]">Berita lainnya</h2>
                            <div class="mt-5 space-y-5">
                                @foreach($relatedNews as $related)
                                    <a href="{{ route('public.news.show', $related->slug) }}" class="group flex gap-4">
                                        <div class="relative h-20 w-24 shrink-0 overflow-hidden rounded-xl bg-slate-100">
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-slate-100 text-2xl text-blue-300" aria-hidden="true">&#9733;</div>
                                            @if($related->featured_image)
                                                <img src="{{ asset('storage/' . $related->featured_image) }}"
                                                     alt="{{ $related->title }}"
                                                     class="relative h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                                     loading="lazy"
                                                     onerror="this.style.display='none'">
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            @if($related->category)
                                                <span class="text-[11px] font-bold uppercase tracking-wide text-[#3B82F6]">{{ $related->category->name }}</span>
                                            @endif
                                            <h3 class="mt-1 line-clamp-2 text-sm font-bold leading-snug text-[#0B1F4B] transition group-hover:text-[#1D4ED8]">
                                                {{ $related->title }}
                                            </h3>
                                            <time datetime="{{ optional($related->published_at)->toIso8601String() }}" class="mt-1 block text-xs text-slate-500">
                                                {{ optional($related->published_at)->translatedFormat('d F Y') }}
                                            </time>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <a href="{{ route('public.news.index') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-[#1D4ED8] hover:underline">
                                Lihat semua berita <span aria-hidden="true">&#8594;</span>
                            </a>
                        </section>
                    @endif

                    <section class="rounded-2xl bg-[#0B1F4B] p-6 text-white shadow-sm">
                        <p class="text-sm font-bold uppercase tracking-[.18em] text-blue-300">SPMB</p>
                        <h2 class="mt-3 text-xl font-black leading-snug">Tertarik bergabung dengan {{ config('school.name') }}?</h2>
                        <p class="mt-3 text-sm leading-relaxed text-blue-100">
                            Kenali program keahlian yang tersedia atau langsung isi formulir pendaftaran siswa baru.
                        </p>
                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('ppdb.register') }}" class="rounded-xl bg-[#3B82F6] px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-blue-500">
                                Daftar SPMB
                            </a>
                            <a href="{{ route('info.contact') }}" class="rounded-xl border border-white/30 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-white/10">
                                Hubungi Sekolah
                            </a>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</article>

@if($galleryImages->count() > 0)
    <!-- Lightbox galeri -->
    <div id="news-lightbox" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/90 p-4" role="dialog" aria-modal="true" aria-label="Pratinjau foto">
        <button type="button" data-lightbox-close class="absolute right-4 top-4 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-white/20" aria-label="Tutup">&times;</button>

        @if($galleryImages->count() > 1)
            <button type="button" data-lightbox-prev class="absolute left-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-white/20" aria-label="Foto sebelumnya">&#8592;</button>
            <button type="button" data-lightbox-next class="absolute right-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-2xl text-white transition hover:bg-white/20" aria-label="Foto berikutnya">&#8594;</button>
        @endif

        <figure class="flex max-h-full w-full max-w-5xl flex-col items-center">
            <img data-lightbox-image src="" alt="" class="max-h-[78vh] w-auto max-w-full rounded-xl object-contain shadow-2xl">
            <figcaption class="mt-4 text-center text-sm text-slate-200">
                <span data-lightbox-caption></span>
                <span class="ml-2 text-slate-400" data-lightbox-counter></span>
            </figcaption>
        </figure>
    </div>
@endif
@endsection

@push('styles')
<style>
    /* ------------------------------------------------------------------
       Tipografi isi artikel
       ------------------------------------------------------------------ */
    .article-content-html {
        font-size: 1.0625rem;
        line-height: 1.85;
        color: #334155;
        max-width: 68ch;
    }

    .article-content-html > * + * {
        margin-top: 1.35rem;
    }

    .article-content-html p {
        margin-bottom: 0;
    }

    .article-content-html h1,
    .article-content-html h2,
    .article-content-html h3,
    .article-content-html h4,
    .article-content-html h5,
    .article-content-html h6 {
        color: #0B1F4B;
        font-weight: 800;
        line-height: 1.3;
        margin-top: 2.25rem;
        margin-bottom: .75rem;
    }

    .article-content-html h1 { font-size: 1.875rem; }
    .article-content-html h2 { font-size: 1.5rem; }
    .article-content-html h3 { font-size: 1.25rem; }
    .article-content-html h4 { font-size: 1.125rem; }

    .article-content-html strong { color: #0B1F4B; font-weight: 700; }

    .article-content-html ul,
    .article-content-html ol {
        padding-left: 1.5rem;
    }

    .article-content-html ul { list-style: disc; }
    .article-content-html ol { list-style: decimal; }
    .article-content-html li { margin-bottom: .5rem; }
    .article-content-html li::marker { color: #3B82F6; }

    .article-content-html a {
        color: #1D4ED8;
        font-weight: 600;
        text-decoration: underline;
        text-underline-offset: 3px;
        word-break: break-word;
    }

    .article-content-html a:hover { color: #1E40AF; }

    .article-content-html blockquote {
        border-left: 4px solid #3B82F6;
        background: #F8FAFC;
        padding: 1rem 1.25rem;
        border-radius: 0 .75rem .75rem 0;
        color: #475569;
        font-style: italic;
    }

    .article-content-html blockquote p { margin: 0; }

    .article-content-html code {
        background: #F1F5F9;
        padding: .15rem .4rem;
        border-radius: .25rem;
        font-size: .9em;
    }

    .article-content-html pre {
        background: #0F172A;
        color: #E2E8F0;
        padding: 1rem 1.25rem;
        border-radius: .75rem;
        overflow-x: auto;
    }

    .article-content-html pre code { background: transparent; padding: 0; color: inherit; }

    /* Tabel dari editor tetap terbaca di layar kecil */
    .article-content-html table {
        width: 100%;
        border-collapse: collapse;
        font-size: .95rem;
    }

    .article-content-html th,
    .article-content-html td {
        border: 1px solid #E2E8F0;
        padding: .6rem .75rem;
        text-align: left;
    }

    .article-content-html th { background: #F8FAFC; font-weight: 700; color: #0B1F4B; }

    .article-content-html .table-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* ------------------------------------------------------------------
       Gambar di dalam isi artikel (hasil unggahan editor)
       ------------------------------------------------------------------ */
    .article-content-html img {
        max-width: 100%;
        height: auto;
        border-radius: .75rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .article-content-html figure {
        margin: 2rem auto;
        text-align: center;
    }

    .article-content-html figure img {
        box-shadow: 0 10px 25px -12px rgba(15, 23, 42, .35);
    }

    .article-content-html figure figcaption {
        margin-top: .65rem;
        font-size: .875rem;
        color: #64748B;
    }

    /* Perataan gambar dari CKEditor */
    .article-content-html figure.image-style-align-center { margin-left: auto; margin-right: auto; }

    .article-content-html figure.image-style-side,
    .article-content-html figure.image-style-align-right {
        float: right;
        max-width: 45%;
        margin: .5rem 0 1rem 1.5rem;
    }

    .article-content-html figure.image-style-align-left {
        float: left;
        max-width: 45%;
        margin: .5rem 1.5rem 1rem 0;
    }

    .article-content-html::after { content: ""; display: table; clear: both; }

    @media (max-width: 768px) {
        .article-content-html { font-size: 1rem; }

        .article-content-html figure.image-style-side,
        .article-content-html figure.image-style-align-left,
        .article-content-html figure.image-style-align-right {
            float: none;
            max-width: 100%;
            margin: 1.5rem auto;
        }
    }

    /* ------------------------------------------------------------------
       Galeri
       ------------------------------------------------------------------ */
    [data-gallery-thumbs]::-webkit-scrollbar { height: 6px; }
    [data-gallery-thumbs]::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }

    [data-gallery-thumb].is-active {
        border-color: #3B82F6;
        opacity: 1;
    }

    #news-lightbox.is-open { display: flex; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bungkus tabel panjang agar bisa digeser di layar kecil
    document.querySelectorAll('.article-content-html table').forEach(function (table) {
        if (table.parentElement && table.parentElement.classList.contains('table-scroll')) {
            return;
        }
        var wrapper = document.createElement('div');
        wrapper.className = 'table-scroll';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });

    // Sembunyikan gambar artikel yang gagal dimuat, jangan tampilkan ikon rusak
    document.querySelectorAll('.article-content-html img').forEach(function (image) {
        image.removeAttribute('width');
        image.removeAttribute('height');
        image.addEventListener('error', function () {
            var holder = this.closest('figure') || this;
            holder.style.display = 'none';
        });
    });

    // Tombol salin tautan
    var copyButton = document.querySelector('[data-copy-link]');
    if (copyButton) {
        copyButton.addEventListener('click', function () {
            var link = this.getAttribute('data-copy-link');
            var original = this.textContent;
            var self = this;

            var done = function () {
                self.textContent = 'Tautan disalin';
                setTimeout(function () { self.textContent = original; }, 2000);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(link).then(done).catch(function () { window.prompt('Salin tautan berikut:', link); });
            } else {
                window.prompt('Salin tautan berikut:', link);
            }
        });
    }

    // ------------------------------------------------------------------
    // Galeri foto
    // ------------------------------------------------------------------
    var galleryRoot = document.querySelector('[data-gallery]');
    if (!galleryRoot) {
        return;
    }

    var captions = @json($galleryImages->map(fn ($image) => (string) ($image->caption ?? ''))->values());
    var sources = @json($galleryImages->map(fn ($image) => asset('storage/' . $image->image_path))->values());
    var fallbackCaption = @json('Dokumentasi ' . $news->title);
    var total = sources.length;

    var captionBox = galleryRoot.querySelector('[data-gallery-caption]');
    var counterBox = galleryRoot.querySelector('[data-gallery-current]');
    var thumbStrip = galleryRoot.querySelector('[data-gallery-thumbs]');
    var thumbs = Array.prototype.slice.call(galleryRoot.querySelectorAll('[data-gallery-thumb]'));

    var captionFor = function (index) {
        return (captions[index] && captions[index].trim() !== '') ? captions[index] : fallbackCaption;
    };

    // followThumb sengaja dimatikan saat inisialisasi: menggeser strip thumbnail
    // hanya boleh menggerakkan strip itu sendiri, jangan sampai halaman ikut
    // melompat ke galeri begitu artikel dibuka.
    var syncTo = function (index, followThumb) {
        if (captionBox) { captionBox.textContent = captionFor(index); }
        if (counterBox) { counterBox.textContent = index + 1; }

        thumbs.forEach(function (thumb, position) {
            var active = position === index;
            thumb.classList.toggle('is-active', active);
            thumb.classList.toggle('opacity-60', !active);

            if (active && followThumb && thumbStrip) {
                var target = thumb.offsetLeft - (thumbStrip.clientWidth - thumb.clientWidth) / 2;
                thumbStrip.scrollTo({ left: Math.max(0, target), behavior: 'smooth' });
            }
        });
    };

    var swiper = null;
    var galleryEl = galleryRoot.querySelector('.gallery-swiper');

    if (galleryEl && typeof Swiper !== 'undefined') {
        swiper = new Swiper(galleryEl, {
            loop: total > 1,
            speed: 450,
            spaceBetween: 0,
            slidesPerView: 1,
            grabCursor: total > 1,
            keyboard: { enabled: true, onlyInViewport: true },
            a11y: { enabled: true },
            navigation: { nextEl: '.gallery-next', prevEl: '.gallery-prev' },
            on: {
                slideChange: function () {
                    syncTo(this.realIndex, true);
                }
            }
        });

        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                var target = parseInt(this.getAttribute('data-gallery-thumb'), 10) || 0;
                if (swiper.params.loop) {
                    swiper.slideToLoop(target);
                } else {
                    swiper.slideTo(target);
                }
            });
        });
    }

    syncTo(0, false);

    // ------------------------------------------------------------------
    // Lightbox
    // ------------------------------------------------------------------
    var lightbox = document.getElementById('news-lightbox');
    if (!lightbox) {
        return;
    }

    var lightboxImage = lightbox.querySelector('[data-lightbox-image]');
    var lightboxCaption = lightbox.querySelector('[data-lightbox-caption]');
    var lightboxCounter = lightbox.querySelector('[data-lightbox-counter]');
    var activeIndex = 0;

    var render = function (index) {
        activeIndex = (index + total) % total;
        lightboxImage.src = sources[activeIndex];
        lightboxImage.alt = captionFor(activeIndex);
        lightboxCaption.textContent = captionFor(activeIndex);
        lightboxCounter.textContent = (activeIndex + 1) + ' / ' + total;
    };

    var open = function (index) {
        render(index);
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    };

    var close = function () {
        lightbox.classList.remove('is-open');
        document.body.style.overflow = '';
        if (swiper) {
            if (swiper.params.loop) {
                swiper.slideToLoop(activeIndex, 0);
            } else {
                swiper.slideTo(activeIndex, 0);
            }
        }
    };

    galleryRoot.querySelectorAll('[data-lightbox-open]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            open(parseInt(this.getAttribute('data-lightbox-open'), 10) || 0);
        });
    });

    lightbox.querySelector('[data-lightbox-close]').addEventListener('click', close);

    var prevButton = lightbox.querySelector('[data-lightbox-prev]');
    var nextButton = lightbox.querySelector('[data-lightbox-next]');
    if (prevButton) { prevButton.addEventListener('click', function () { render(activeIndex - 1); }); }
    if (nextButton) { nextButton.addEventListener('click', function () { render(activeIndex + 1); }); }

    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            close();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!lightbox.classList.contains('is-open')) {
            return;
        }
        if (event.key === 'Escape') { close(); }
        if (event.key === 'ArrowLeft') { render(activeIndex - 1); }
        if (event.key === 'ArrowRight') { render(activeIndex + 1); }
    });
});
</script>
@endpush
