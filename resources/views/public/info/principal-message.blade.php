@extends('layouts.public-tailwind')

@php
    $schoolName = config('school.name');
    $photoUrl = $principalPhoto ? asset('storage/' . $principalPhoto) : null;

    // Pesan disimpan sebagai teks biasa dari textarea admin: pecah per baris
    // kosong menjadi paragraf agar enak dibaca, bukan satu blok panjang.
    $messageParagraphs = collect(preg_split('/\R{2,}/', trim((string) $principalMessage)))
        ->map(fn ($paragraph) => trim($paragraph))
        ->filter()
        ->values();

    $visionText = trim((string) setting('about_vision', ''));
    $missionText = trim((string) setting('about_mission', ''));
@endphp

@section('title', 'Sambutan Kepala Sekolah - ' . $schoolName)
@section('description', 'Sambutan ' . $principalName . ', Kepala Sekolah ' . $schoolName . '.')
@section('og_title', 'Sambutan Kepala Sekolah - ' . $schoolName)
@section('og_description', 'Pesan dan harapan dari Kepala Sekolah ' . $schoolName . '.')
@if($photoUrl)
    @section('og_image', $photoUrl)
@endif

@push('styles')
    @if($photoUrl)
        {{-- Unduh foto kepala sekolah paling awal, sebelum CSS & JS lain selesai diproses. --}}
        <link rel="preload" as="image" href="{{ $photoUrl }}" fetchpriority="high">
    @endif
@endpush

@section('content')
<!-- Header Halaman -->
<section class="bg-[#0B1F4B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-24 sm:pb-16 sm:pt-32">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-blue-200" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('info.about') }}" class="transition hover:text-white">Tentang</a>
            <span aria-hidden="true">/</span>
            <span class="font-semibold text-white">Sambutan Kepala Sekolah</span>
        </nav>

        <div class="mt-6 max-w-3xl">
            <p class="text-sm font-bold uppercase tracking-[.2em] text-[#60A5FA]">Profil Sekolah</p>
            <h1 class="mt-3 text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">Sambutan Kepala Sekolah</h1>
            <p class="mt-4 text-base leading-relaxed text-blue-100 sm:text-lg">
                Pesan dan harapan dari pimpinan {{ $schoolName }}.
            </p>
        </div>
    </div>
</section>

<!-- Profil & Sambutan -->
<section class="bg-slate-50 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            <!-- Kartu foto kepala sekolah -->
            <div class="lg:col-span-5">
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg lg:sticky lg:top-28">
                    <div class="relative aspect-[3/4] w-full overflow-hidden bg-slate-100"
                         @if($principalPhotoPreview)
                             style="background-image:url('{{ $principalPhotoPreview }}');background-size:cover;background-position:center;"
                         @endif>
                        @if($principalPhotoPreview)
                            {{-- Lapisan buram dari pratinjau: menutup kekasaran piksel sebelum foto asli muncul --}}
                            <div class="absolute inset-0 backdrop-blur-xl"></div>
                        @endif

                        @if($photoUrl)
                            <img src="{{ $photoUrl }}"
                                 alt="{{ $principalName }}, Kepala Sekolah {{ $schoolName }}"
                                 class="relative h-full w-full object-cover object-top"
                                 loading="eager"
                                 decoding="sync"
                                 fetchpriority="high"
                                 @if($principalPhotoSize)
                                     width="{{ $principalPhotoSize['width'] }}"
                                     height="{{ $principalPhotoSize['height'] }}"
                                 @endif
                                 onerror="this.style.display='none'; this.nextElementSibling?.classList.remove('hidden');">

                            <div class="absolute inset-0 hidden items-center justify-center bg-gradient-to-br from-blue-100 to-slate-100">
                                <svg class="h-24 w-24 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-slate-100">
                                <svg class="h-24 w-24 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 sm:p-7">
                        <p class="text-xs font-bold uppercase tracking-[.2em] text-[#3B82F6]">Kepala Sekolah</p>
                        <h2 class="mt-2 text-xl font-black leading-snug text-[#0B1F4B] sm:text-2xl">{{ $principalName }}</h2>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $schoolName }}</p>

                        <div class="mt-6 space-y-2 border-t border-slate-200 pt-5">
                            <a href="{{ route('info.about') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#1D4ED8]">
                                Profil Sekolah <span aria-hidden="true">&#8594;</span>
                            </a>
                            <a href="{{ route('info.overview') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#1D4ED8]">
                                Selayang Pandang <span aria-hidden="true">&#8594;</span>
                            </a>
                            <a href="{{ route('public.staff-profiles.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#1D4ED8]">
                                Guru &amp; Karyawan <span aria-hidden="true">&#8594;</span>
                            </a>
                            <a href="{{ route('info.contact') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-[#1D4ED8]">
                                Hubungi Sekolah <span aria-hidden="true">&#8594;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu sambutan -->
            <div class="lg:col-span-7">
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg sm:p-10 lg:p-12">
                    <svg class="h-10 w-10 text-blue-200" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>

                    @if($messageParagraphs->isNotEmpty())
                        <div class="principal-message mt-6">
                            @foreach($messageParagraphs as $paragraph)
                                <p>{!! nl2br(e($paragraph)) !!}</p>
                            @endforeach
                        </div>

                        <footer class="mt-10 border-t border-slate-200 pt-6">
                            <p class="text-sm text-slate-500">Hormat kami,</p>
                            <p class="mt-1 text-lg font-black text-[#0B1F4B]">{{ $principalName }}</p>
                            <p class="text-sm font-semibold text-[#3B82F6]">Kepala Sekolah {{ $schoolName }}</p>
                        </footer>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">
                            <p class="text-sm leading-relaxed text-slate-600">
                                Sambutan kepala sekolah belum tersedia. Isi melalui menu <strong>Pengaturan &rarr; Konten Sekolah</strong> di panel admin.
                            </p>
                        </div>
                    @endif
                </article>

                @if($visionText !== '' || $missionText !== '')
                    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                        @if($visionText !== '')
                            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-[#1E3A8A]">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-5 text-lg font-black text-[#0B1F4B]">Visi Sekolah</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ Str::limit(strip_tags($visionText), 320) }}</p>
                            </div>
                        @endif

                        @if($missionText !== '')
                            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-[#1E3A8A]">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-5 text-lg font-black text-[#0B1F4B]">Misi Sekolah</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ Str::limit(strip_tags($missionText), 320) }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                        <h3 class="text-lg font-black text-[#0B1F4B]">Visi &amp; Misi Sekolah</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            Visi dan misi lengkap {{ $schoolName }} dapat dibaca pada halaman profil sekolah.
                        </p>
                        <a href="{{ route('info.about') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#1D4ED8] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#1E40AF]">
                            Buka Profil Sekolah <span aria-hidden="true">&#8594;</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Ajakan -->
<section class="bg-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start gap-6 rounded-2xl border border-slate-200 bg-slate-50 p-8 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-xl font-black text-[#0B1F4B] sm:text-2xl">Ingin mengenal sekolah kami lebih dekat?</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">
                    Pelajari program keahlian yang tersedia, atau hubungi kami untuk informasi pendaftaran dan kunjungan sekolah.
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
    .principal-message {
        font-size: 1.0625rem;
        line-height: 1.9;
        color: #334155;
        max-width: 70ch;
    }

    .principal-message p + p {
        margin-top: 1.35rem;
    }

    /* Kalimat pembuka sedikit ditebalkan sebagai pengantar sambutan */
    .principal-message p:first-of-type {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0B1F4B;
    }

    @media (max-width: 640px) {
        .principal-message {
            font-size: 1rem;
            line-height: 1.85;
        }

        .principal-message p:first-of-type {
            font-size: 1.0625rem;
        }
    }
</style>
@endpush
