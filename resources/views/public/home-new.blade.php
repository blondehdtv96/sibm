@extends('layouts.public-tailwind')

@section('title', 'SMK Bina Mandiri Kota Bekasi - Sekolah Menengah Kejuruan Terbaik di Bekasi')
@section('description', 'SMK Bina Mandiri Kota Bekasi adalah sekolah menengah kejuruan terbaik di Bekasi dengan program keahlian unggulan. Fasilitas modern, guru berpengalaman, tingkat kelulusan 100%. Daftar PPDB 2025 sekarang!')

@section('content')
<!-- Hero Slider Section -->
@if($sliders && $sliders->count() > 0)
<section class="hero-slider-section relative overflow-hidden bg-gray-900">

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $index => $slider)
            <div class="swiper-slide hero-slide">
                {{-- Full-size image (follows natural dimensions) --}}
                @if($slider->image_path)
                <div class="slide-image-wrap">
                    <img src="{{ asset('storage/' . $slider->image_path) }}"
                         alt="{{ $slider->title ?? 'Slider ' . ($index+1) }}"
                         class="slide-img"
                         onerror="this.closest('.slide-image-wrap').style.display='none'">
                </div>
                @endif

                {{-- Overlay text (only shown when title/subtitle/button present) --}}
                @if($slider->title || $slider->subtitle || $slider->button_text)
                <div class="slide-overlay">
                    <div class="slide-content">
                        @if($slider->title)
                        <h2 class="slide-title">{{ $slider->title }}</h2>
                        @endif
                        @if($slider->subtitle)
                        <p class="slide-subtitle">{{ $slider->subtitle }}</p>
                        @endif
                        @if($slider->button_text && $slider->button_link)
                        <div class="slide-btn-wrap">
                            <a href="{{ $slider->button_link }}" class="slide-btn">
                                {{ $slider->button_text }}
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @if($sliders->count() > 1)
        {{-- Navigation Arrows --}}
        <button class="hero-nav hero-nav-prev" id="heroPrev" aria-label="Sebelumnya">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="hero-nav hero-nav-next" id="heroNext" aria-label="Berikutnya">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Pagination + Counter --}}
        <div class="hero-footer">
            <div class="swiper-pagination hero-pagination"></div>
            <div class="hero-counter">
                <span id="heroCurrentSlide">1</span> / <span id="heroTotalSlides">{{ $sliders->count() }}</span>
            </div>
        </div>
        @endif
    </div>
</section>
@else
<section class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 py-28 md:py-40">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight drop-shadow-lg">
            {{ config('school.name', 'SMK Bina Mandiri Bekasi') }}
        </h1>
        <p class="text-xl md:text-2xl mb-10 text-blue-100 max-w-3xl mx-auto leading-relaxed">
            {{ config('school.tagline', 'Mencetak Generasi Unggul dan Berdaya Saing') }}
        </p>
        <a href="{{ route('ppdb.register') }}"
           class="inline-flex items-center gap-3 px-10 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg hover:bg-blue-50 transition-all shadow-2xl hover:shadow-blue-500/30 hover:-translate-y-1">
            Daftar Sekarang
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>
@endif

<!-- Stats Section -->
@if($statistics && $statistics->count() > 0)
<section class="relative -mt-8 sm:-mt-12 z-20 pb-4">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl border border-gray-100 p-5 sm:p-8 lg:p-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 divide-y divide-gray-100 md:divide-y-0 md:divide-x">
                @foreach($statistics->take(4) as $stat)
                <div class="text-center px-2 pt-4 md:pt-0 first:pt-0">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold bg-gradient-to-br from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-1 sm:mb-2">
                        {{ $stat->value }}{{ $stat->suffix }}
                    </div>
                    <div class="text-xs sm:text-sm lg:text-base text-gray-500 font-medium leading-tight">{{ $stat->label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Announcements Section -->
@if(isset($announcements) && $announcements->count() > 0)
<section class="py-14 sm:py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14">
            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-semibold mb-4 tracking-wide uppercase">
                Informasi Penting
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                Pengumuman
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Informasi dan pengumuman terbaru dari SMK Bina Mandiri Bekasi
            </p>
        </div>

        <div class="grid grid-cols-1 {{ $announcements->count() > 1 ? 'sm:grid-cols-2 lg:grid-cols-3' : 'max-w-3xl mx-auto' }} gap-5 sm:gap-6 lg:gap-8">
            @foreach($announcements as $announcementItem)
            <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl border border-gray-100 transition-all duration-300 hover:-translate-y-1">
                @if($announcementItem->link_url)
                <a href="{{ $announcementItem->link_url }}" target="_blank" rel="noopener noreferrer" class="block">
                    <div class="bg-gray-50 max-h-[420px] sm:max-h-[520px] flex items-center justify-center p-2 overflow-hidden">
                        <img src="{{ asset('storage/' . $announcementItem->image) }}"
                             alt="{{ $announcementItem->title }}"
                             class="w-full max-h-[404px] sm:max-h-[504px] h-auto object-contain rounded-xl group-hover:scale-[1.02] transition-transform duration-300"
                             loading="lazy">
                    </div>
                    @if($announcementItem->title)
                    <div class="p-4 sm:p-5">
                        <h3 class="font-bold text-base sm:text-lg text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $announcementItem->title }}</h3>
                    </div>
                    @endif
                </a>
                @else
                <button type="button"
                        onclick="openAnnouncement('{{ asset('storage/' . $announcementItem->image) }}', @js($announcementItem->title))"
                        class="block w-full text-left">
                    <div class="bg-gray-50 max-h-[420px] sm:max-h-[520px] flex items-center justify-center p-2 overflow-hidden">
                        <img src="{{ asset('storage/' . $announcementItem->image) }}"
                             alt="{{ $announcementItem->title }}"
                             class="w-full max-h-[404px] sm:max-h-[504px] h-auto object-contain rounded-xl group-hover:scale-[1.02] transition-transform duration-300"
                             loading="lazy">
                    </div>
                    @if($announcementItem->title)
                    <div class="p-4 sm:p-5">
                        <h3 class="font-bold text-base sm:text-lg text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $announcementItem->title }}</h3>
                    </div>
                    @endif
                </button>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Announcement Lightbox -->
<div id="announcementModal" class="hidden fixed inset-0 bg-black/80 z-[9999] flex items-center justify-center p-4" onclick="closeAnnouncement()">
    <button type="button" onclick="closeAnnouncement()" class="absolute top-4 right-4 text-white hover:bg-white/20 p-2 rounded-full transition-colors">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <div class="max-w-4xl w-full max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
        <img id="announcementModalImg" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
        <p id="announcementModalTitle" class="text-white text-center font-semibold mt-4 text-lg"></p>
    </div>
</div>

@push('scripts')
<script>
function openAnnouncement(src, title) {
    document.getElementById('announcementModalImg').src = src;
    document.getElementById('announcementModalTitle').textContent = title || '';
    document.getElementById('announcementModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeAnnouncement() {
    document.getElementById('announcementModal').classList.add('hidden');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAnnouncement();
});
</script>
@endpush
@endif

<!-- Welcome Section -->
<section class="py-14 sm:py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-10 sm:mb-14">
            <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-semibold mb-4 tracking-wide uppercase">
                Mengapa Memilih Kami
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                Selamat Datang di SMK Bina Mandiri
            </h2>
            <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                Institusi pendidikan kejuruan terkemuka yang berkomitmen mencetak lulusan berkualitas, siap kerja, dan berdaya saing tinggi di era digital.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
            <div class="group bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Fasilitas Modern</h3>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Laboratorium dan workshop dengan peralatan industri terkini untuk mendukung pembelajaran praktik.</p>
            </div>
            
            <div class="group bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Guru Profesional</h3>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Tenaga pengajar bersertifikat dan berpengalaman di bidangnya masing-masing.</p>
            </div>
            
            <div class="group bg-white p-6 sm:p-8 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 hover:-translate-y-1 sm:col-span-2 lg:col-span-1">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-purple-500 to-blue-600 rounded-2xl flex items-center justify-center mb-5 shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Kerjasama Industri</h3>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed">Program magang dan penempatan kerja di perusahaan terkemuka untuk siswa.</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Keahlian -->
@if($featuredCompetencies && $featuredCompetencies->count() > 0)
<section class="py-14 sm:py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs sm:text-sm font-semibold mb-4 tracking-wide uppercase">
                Jurusan Unggulan
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                Program Keahlian
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Pilih program keahlian sesuai minat dan bakat Anda untuk masa depan yang cerah
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
            @foreach($featuredCompetencies->take(3) as $competency)
            <a href="{{ route('public.competencies.show', $competency->slug) }}" 
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                @if($competency->image)
                <div class="h-44 sm:h-48 overflow-hidden bg-gray-50 flex items-center justify-center p-6">
                    <img src="{{ Storage::url($competency->image) }}" 
                         alt="{{ $competency->name }}" 
                         class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500"
                         loading="lazy">
                </div>
                @else
                <div class="h-44 sm:h-48 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                    <svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                @endif
                
                <div class="p-5 sm:p-6 flex flex-col flex-grow">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                        {{ $competency->name }}
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4 line-clamp-2 flex-grow">
                        {{ Str::limit(strip_tags($competency->description), 100) }}
                    </p>
                    <div class="flex items-center text-blue-600 font-semibold text-sm sm:text-base mt-auto">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
        <div class="text-center mt-10 sm:mt-12">
            <a href="{{ route('public.competencies.index') }}" 
               class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 bg-blue-600 text-white rounded-xl font-bold text-sm sm:text-base hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5">
                Lihat Semua Program
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- PPDB Brochure -->
@if(setting('ppdb_brochure'))
<section class="py-14 sm:py-16 lg:py-24 bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 items-center p-6 sm:p-10 lg:p-12">
                <div class="text-white text-center lg:text-left order-2 lg:order-1">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 leading-tight">
                        {{ setting('ppdb_brochure_title', 'Download Brosur') }}
                    </h2>
                    <p class="text-base sm:text-lg mb-6 text-white/90 leading-relaxed">
                        Dapatkan informasi lengkap tentang program keahlian, fasilitas, dan biaya pendidikan.
                    </p>
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 justify-center lg:justify-start">
                        <button onclick="openBrosurModal()" 
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 rounded-xl font-bold hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Brosur
                        </button>
                        <a href="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                           download
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/20 text-white rounded-xl font-bold border-2 border-white hover:bg-white/30 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
                <div class="flex justify-center order-1 lg:order-2">
                    <img src="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                         alt="Brosur"
                         class="max-w-[240px] sm:max-w-sm w-full h-auto rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Video Profile -->
<section class="py-14 sm:py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8 sm:mb-12">
                <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs sm:text-sm font-semibold mb-4 tracking-wide uppercase">
                    Video Profil
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    Profil SMK Bina Mandiri
                </h2>
                <p class="text-base sm:text-lg text-gray-600">
                    Saksikan kegiatan dan prestasi siswa-siswi kami
                </p>
            </div>
            
            <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <iframe 
                        class="absolute inset-0 w-full h-full"
                        src="https://www.youtube.com/embed/s5l8HAA2evI" 
                        title="Video Profil SMK Bina Mandiri" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen
                        loading="lazy"
                    ></iframe>
                </div>
            </div>
            
            <div class="text-center mt-6 sm:mt-8">
                <a href="https://www.youtube.com/@smkbinamandiri268" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-xl font-bold text-sm sm:text-base hover:bg-red-700 transition-colors shadow-lg shadow-red-500/25">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    Kunjungi Channel YouTube
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Latest News -->
@if($latestNews && $latestNews->count() > 0)
<section class="py-14 sm:py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3 mb-8 sm:mb-12">
            <div>
                <span class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-semibold mb-3 tracking-wide uppercase">
                    Informasi Terkini
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                    Berita Terbaru
                </h2>
            </div>
            <a href="{{ route('public.news.index') }}" 
               class="inline-flex items-center gap-1 text-blue-600 font-semibold hover:text-blue-700 text-sm sm:text-base whitespace-nowrap">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-8">
            @foreach($latestNews as $news)
            <a href="{{ route('public.news.show', $news->slug) }}" 
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-100 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                @if($news->featured_image)
                <div class="h-44 sm:h-48 overflow-hidden bg-gray-100">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         loading="lazy">
                </div>
                @else
                <div class="h-44 sm:h-48 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m0 0v9a2 2 0 002 2h-2m0 0a2 2 0 01-2-2V9a2 2 0 012-2h2a2 2 0 012 2v9a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                @endif
                <div class="p-5 sm:p-6 flex flex-col flex-grow">
                    @if($news->category)
                    <span class="inline-block self-start bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                        {{ $news->category->name }}
                    </span>
                    @endif
                    <h3 class="font-bold text-base sm:text-lg mb-2 text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $news->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-grow">
                        {{ Str::limit(strip_tags($news->excerpt ?? $news->content), 100) }}
                    </p>
                    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 mt-auto pt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $news->published_at->format('d M Y') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Industry Partners -->
@if($industryPartners && $industryPartners->count() > 0)
<section class="py-14 sm:py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-14">
            <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-xs sm:text-sm font-semibold mb-4 tracking-wide uppercase">
                Mitra Kami
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                Kerjasama Dunia Industri
            </h2>
            <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Kami menjalin kerjasama dengan berbagai perusahaan dan industri untuk memberikan pengalaman terbaik bagi siswa
            </p>
        </div>
        
        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 lg:gap-5">
            @foreach($industryPartners as $partner)
            <div class="group">
                @if($partner->website)
                <a href="{{ $partner->website }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="block bg-white border border-gray-200 rounded-xl p-3 sm:p-4 hover:shadow-lg transition-all duration-300 hover:border-blue-400 hover:-translate-y-1">
                    <div class="h-16 sm:h-20 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="{{ $partner->name }}"
                             title="{{ $partner->name }}"
                             class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                             loading="lazy">
                    </div>
                </a>
                @else
                <div class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="h-16 sm:h-20 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="{{ $partner->name }}"
                             title="{{ $partner->name }}"
                             class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition-all duration-300"
                             loading="lazy">
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gallery -->
@if($latestGalleryAlbums && $latestGalleryAlbums->count() > 0)
<section class="py-14 sm:py-16 lg:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3 mb-8 sm:mb-12">
            <div>
                <span class="inline-block px-4 py-1.5 bg-purple-100 text-purple-700 rounded-full text-xs sm:text-sm font-semibold mb-3 tracking-wide uppercase">
                    Dokumentasi
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                    Galeri Kegiatan
                </h2>
            </div>
            <a href="{{ route('public.gallery.index') }}" 
               class="inline-flex items-center gap-1 text-blue-600 font-semibold hover:text-blue-700 text-sm sm:text-base whitespace-nowrap">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($latestGalleryAlbums->take(4) as $album)
            <a href="{{ route('public.gallery.show', $album->slug) }}" 
               class="group relative h-44 sm:h-56 lg:h-64 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                @if($album->cover_image)
                <img src="{{ Storage::url($album->cover_image) }}" 
                     alt="{{ $album->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     loading="lazy">
                @elseif($album->items->first())
                <img src="{{ Storage::url($album->items->first()->image_path) }}" 
                     alt="{{ $album->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-3 sm:p-4">
                    <div class="text-white">
                        <h4 class="font-bold text-xs sm:text-sm mb-0.5 line-clamp-2">{{ $album->name }}</h4>
                        <span class="text-[10px] sm:text-xs text-white/80">{{ $album->items->count() }} Foto</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="relative py-16 sm:py-20 lg:py-28 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 leading-tight">
            Siap Bergabung dengan Kami?
        </h2>
        <p class="text-base sm:text-xl text-blue-100 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed">
            Wujudkan impian menjadi lulusan SMK yang siap kerja dan berdaya saing tinggi bersama SMK Bina Mandiri Bekasi
        </p>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center max-w-md sm:max-w-none mx-auto">
            <a href="{{ route('public.competencies.index') }}" 
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 sm:py-4 bg-white text-blue-600 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all shadow-xl hover:-translate-y-0.5">
                Lihat Program Keahlian
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('info.contact') }}" 
               class="inline-flex items-center justify-center gap-2 px-8 py-3.5 sm:py-4 bg-white/15 text-white rounded-xl font-bold text-base sm:text-lg border-2 border-white/60 hover:bg-white/25 transition-all backdrop-blur-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Brosur Modal -->
<div id="brosurModal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex items-center justify-between p-6 border-b bg-gradient-to-r from-blue-600 to-purple-600">
            <h2 class="text-2xl font-bold text-white">{{ setting('ppdb_brochure_title', 'Brosur PPDB') }}</h2>
            <button onclick="closeBrosurModal()" class="text-white hover:bg-white/20 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="flex-1 overflow-auto bg-gray-50 flex items-center justify-center p-6">
            <img src="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                 alt="Brosur PPDB"
                 class="max-w-full h-auto rounded-lg shadow-lg">
        </div>
        
        <div class="flex gap-4 p-6 border-t bg-gray-50">
            <button onclick="downloadBrosur()" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:opacity-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
            </button>
            <button onclick="closeBrosurModal()" 
                   class="flex-1 px-6 py-3 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Professional Hero Slider ──────────────────────────────────────────────
    var heroEl = document.querySelector('.hero-swiper');
    if (heroEl) {
        var heroSwiper = new Swiper('.hero-swiper', {
            loop: true,
            speed: 800,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: {
                el: '.hero-pagination',
                clickable: true,
                dynamicBullets: false,
            },
            navigation: {
                nextEl: '#heroNext',
                prevEl: '#heroPrev',
            },
            keyboard: { enabled: true },
            a11y: { enabled: true },
            on: {
                realIndexChange: function (swiper) {
                    var cur = document.getElementById('heroCurrentSlide');
                    if (cur) cur.textContent = swiper.realIndex + 1;
                },
            },
        });
    }
});

// ── Brosur Modal ──────────────────────────────────────────────────────────────
function openBrosurModal() {
    document.getElementById('brosurModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeBrosurModal() {
    document.getElementById('brosurModal').classList.add('hidden');
    document.body.style.overflow = '';
}
function downloadBrosur() {
    var link = document.createElement('a');
    link.href = "{{ asset('storage/' . setting('ppdb_brochure')) }}";
    link.download = true;
    link.click();
}
document.getElementById('brosurModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeBrosurModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeBrosurModal();
});
</script>
@endpush

@push('styles')
<style>
/* ── Hero Slider ───────────────────────────────────────────────────────────── */

/* Section wrapper – matches image height naturally */
.hero-slider-section { width: 100%; }

/* Swiper container fills the section */
.hero-swiper { width: 100%; position: relative; }

/* Each slide — fixed proportional height, not raw image size */
.hero-slide {
    position: relative;
    overflow: hidden;
    background: #111;
    height: 62vw;        /* scales with viewport: ~597px on 1200px wide */
    min-height: 320px;   /* never too small on narrow screens */
    max-height: 560px;   /* never taller than this on wide screens */
}

/* Mobile: give the hero a comfortable portrait-friendly height */
@media (max-width: 640px) {
    .hero-slide {
        height: 68vw;
        min-height: 260px;
        max-height: 420px;
    }
}

/* Image wrapper fills the entire slide box */
.slide-image-wrap {
    width: 100%;
    height: 100%;
    display: block;
    line-height: 0;
}

/* Image covers the slide — no distortion, just clean crop */
.slide-img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
    transform-origin: center center;
    transition: transform 6s ease;
}

/* Ken-Burns: gentle zoom on active slide */
.swiper-slide-active .slide-img {
    transform: scale(1.05);
}

/* Text overlay – sits at bottom with gradient */
.slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,0.72) 0%,
        rgba(0,0,0,0.28) 45%,
        transparent 100%
    );
    display: flex;
    align-items: flex-end;
    padding: 2.5rem 2rem;
    pointer-events: none;
}

/* Mobile: tighter overlay padding, leave room for footer bar */
@media (max-width: 640px) {
    .slide-overlay { padding: 1.25rem 1.25rem 3.25rem; }
    .slide-title { margin-bottom: .4rem; }
    .slide-subtitle { margin-bottom: .85rem; }
    .slide-btn { padding: .6rem 1.35rem; font-size: .85rem; }
}

.slide-content {
    max-width: 780px;
    pointer-events: auto;
}

.slide-title {
    font-size: clamp(1.4rem, 4vw, 2.6rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.25;
    margin-bottom: .6rem;
    text-shadow: 0 2px 12px rgba(0,0,0,.5);
}

.slide-subtitle {
    font-size: clamp(.95rem, 2.2vw, 1.3rem);
    color: rgba(255,255,255,.92);
    margin-bottom: 1.2rem;
    line-height: 1.55;
    text-shadow: 0 1px 8px rgba(0,0,0,.45);
}

.slide-btn-wrap { }

.slide-btn {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    padding: .75rem 1.75rem;
    background: #fff;
    color: #1d4ed8;
    font-weight: 700;
    font-size: .95rem;
    border-radius: 9999px;
    text-decoration: none;
    box-shadow: 0 8px 28px rgba(0,0,0,.25);
    transition: background .2s, transform .2s, box-shadow .2s;
}
.slide-btn:hover {
    background: #eff6ff;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(0,0,0,.32);
}
.slide-btn svg { width: 18px; height: 18px; }

/* ── Custom Navigation Arrows ──────────────────────────────────────────────── */
.hero-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.18);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,.25);
    transition: background .22s, transform .22s, box-shadow .22s;
}
.hero-nav:hover {
    background: rgba(255,255,255,.35);
    transform: translateY(-50%) scale(1.08);
    box-shadow: 0 6px 28px rgba(0,0,0,.35);
}
.hero-nav:active { transform: translateY(-50%) scale(.96); }
.hero-nav svg { width: 22px; height: 22px; }

.hero-nav-prev { left: 18px; }
.hero-nav-next { right: 18px; }

/* Hide arrows on very small screens */
@media (max-width: 480px) {
    .hero-nav { width: 40px; height: 40px; }
    .hero-nav-prev { left: 10px; }
    .hero-nav-next { right: 10px; }
    .hero-nav svg { width: 18px; height: 18px; }
}

/* ── Footer bar: pagination bullets + counter ──────────────────────────────── */
.hero-footer {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: .8rem 1rem;
    background: linear-gradient(to top, rgba(0,0,0,.45), transparent);
}

/* Pagination bullets */
.hero-pagination { position: static; }
.hero-pagination .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    background: rgba(255,255,255,.55);
    opacity: 1;
    border-radius: 9999px;
    transition: width .35s, background .25s;
    display: inline-block;
    margin: 0 3px;
    cursor: pointer;
}
.hero-pagination .swiper-pagination-bullet-active {
    width: 28px;
    background: #fff;
    border-radius: 9999px;
}

/* Counter */
.hero-counter {
    font-size: .8rem;
    font-weight: 600;
    color: rgba(255,255,255,.85);
    letter-spacing: .04em;
    white-space: nowrap;
}

/* ── Utilities ─────────────────────────────────────────────────────────────── */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection
