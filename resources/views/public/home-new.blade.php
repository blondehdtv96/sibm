@extends('layouts.public-tailwind')

@section('title', 'SMK Bina Mandiri Kota Bekasi - Sekolah Menengah Kejuruan Terbaik di Bekasi')
@section('description', 'SMK Bina Mandiri Kota Bekasi adalah sekolah menengah kejuruan terbaik di Bekasi dengan program keahlian unggulan. Fasilitas modern, guru berpengalaman, tingkat kelulusan 100%. Daftar PPDB 2025 sekarang!')

@section('content')
<!-- Hero Section with Slider -->
@if($sliders && $sliders->count() > 0)
<section class="relative bg-black w-full overflow-hidden">
    <div class="swiper home-hero-slider">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide">
                <div class="relative h-[450px] md:h-[550px] overflow-hidden w-full">
                    @if($slider->image_url)
                    <img src="{{ $slider->image_url }}" 
                         alt="{{ $slider->title }}" 
                         class="absolute inset-0 w-full h-full object-cover animate-ken-burns"
                         loading="lazy">
                    @endif
                    
                    <div class="relative h-full flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            <div class="max-w-3xl text-white">
                                @if($slider->title)
                                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 leading-tight">
                                    {{ $slider->title }}
                                </h1>
                                @endif
                                @if($slider->subtitle)
                                <p class="text-lg sm:text-xl md:text-2xl mb-6 opacity-95">
                                    {{ $slider->subtitle }}
                                </p>
                                @endif
                                @if($slider->button_text && $slider->button_link)
                                <a href="{{ $slider->button_link }}" 
                                   class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                    <span>{{ $slider->button_text }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($sliders->count() > 1)
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        @endif
    </div>
</section>
@else
<!-- Fallback Hero -->
<section class="relative bg-gradient-to-br from-blue-600 to-indigo-600 py-20 md:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black mb-6">
            {{ config('school.name', 'SMK Bina Mandiri Bekasi') }}
        </h1>
        <p class="text-xl sm:text-2xl mb-8 opacity-95">
            {{ config('school.tagline', 'Mencetak Generasi Unggul dan Berdaya Saing') }}
        </p>
        <a href="{{ route('ppdb.register') }}" 
           class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
            <span>Daftar Sekarang</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>
@endif

<!-- Statistics Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-purple-50 to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Prestasi Kami
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-indigo-600 mx-auto mb-4"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Komitmen kami dalam memberikan pendidikan berkualitas tercermin dalam angka-angka prestasi kami
            </p>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($statistics as $stat)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 p-8 text-center group border border-gray-100">
                <!-- Icon Container -->
                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>

                <!-- Number -->
                <div class="mb-2">
                    <span class="text-5xl md:text-6xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        {{ $stat->value }}
                    </span>
                    <span class="text-3xl font-bold text-blue-600">{{ $stat->suffix }}</span>
                </div>

                <!-- Label -->
                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">
                    {{ $stat->label }}
                </h3>

                <!-- Bottom Border Accent -->
                <div class="mt-6 h-1 w-12 bg-gradient-to-r from-blue-500 to-indigo-600 mx-auto rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            @endforeach
        </div>

        <!-- CTA Section -->
        <div class="mt-16 text-center">
            <p class="text-gray-600 text-lg mb-8">
                Bergabunglah dengan ribuan siswa yang telah merasakan pendidikan berkualitas bersama kami
            </p>
            <a href="{{ route('ppdb.register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- PPDB Brochure Section -->
@if(setting('ppdb_brochure'))
<section class="py-16 bg-gradient-to-br from-orange-50 via-red-50 to-orange-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                📄 {{ setting('ppdb_brochure_title', 'Brosur PPDB') }}
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                {{ setting('ppdb_brochure_description', 'Download brosur PPDB untuk informasi lengkap tentang pendaftaran siswa baru') }}
            </p>
        </div>

        <!-- Brochure Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <!-- Brochure Image -->
            <div class="lg:col-span-1 flex justify-center">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <img src="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                         alt="{{ setting('ppdb_brochure_title', 'Brosur PPDB') }}"
                         class="relative w-full max-w-sm rounded-2xl shadow-2xl group-hover:shadow-3xl group-hover:-translate-y-2 transition-all duration-300 border-4 border-white">
                </div>
            </div>

            <!-- Brochure Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 border border-orange-200">
                    <!-- Badge -->
                    <div class="inline-block mb-4">
                        <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            ℹ️ Info PPDB
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        Dapatkan Informasi Lengkap PPDB
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-600 mb-6 text-base leading-relaxed">
                        Brosur PPDB berisi informasi lengkap tentang pendaftaran siswa baru, program keahlian yang tersedia, fasilitas sekolah, biaya pendaftaran, dan persyaratan penerimaan. Download sekarang untuk mempersiapkan pendaftaran Anda.
                    </p>

                    <!-- Features List -->
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Informasi lengkap tentang program keahlian</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Persyaratan dan tata cara pendaftaran</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Fasilitas dan prestasi sekolah</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-orange-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">Biaya pendaftaran dan beasiswa</span>
                        </li>
                    </ul>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                           target="_blank"
                           class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Brosur
                        </a>
                        <a href="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                           download
                           class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-white border-2 border-orange-500 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </a>
                    </div>

                    <!-- Quick Enrollment Link -->
                    <div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <p class="text-sm text-gray-600 mb-3">Siap untuk mendaftar?</p>
                        <a href="{{ route('ppdb.register') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Daftar Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Quick Actions -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('ppdb.register') }}" 
               class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-2xl p-6 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="text-4xl mb-3">📝</div>
                <div class="font-bold text-lg">Daftar PPDB</div>
            </a>
            <a href="{{ route('public.competencies.index') }}" 
               class="bg-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="text-4xl mb-3">🎓</div>
                <div class="font-bold text-lg text-gray-800">Program Keahlian</div>
            </a>
            <a href="{{ route('public.news.index') }}" 
               class="bg-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="text-4xl mb-3">📰</div>
                <div class="font-bold text-lg text-gray-800">Berita</div>
            </a>
            <a href="{{ route('public.gallery.index') }}" 
               class="bg-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="text-4xl mb-3">📸</div>
                <div class="font-bold text-lg text-gray-800">Galeri</div>
            </a>
        </div>
    </div>
</section>

<!-- Latest News -->
@if($latestNews && $latestNews->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Berita Terbaru</h2>
            <a href="{{ route('public.news.index') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestNews->take(3) as $news)
            <a href="{{ route('public.news.show', $news->slug) }}" 
               class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                @if($news->featured_image)
                <div class="relative h-48 bg-gray-200">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                    @if($news->category)
                    <span class="absolute top-3 left-3 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $news->category->name }}
                    </span>
                    @endif
                </div>
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-lg mb-2 text-gray-900 line-clamp-2">
                        {{ $news->title }}
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit(strip_tags($news->excerpt ?? $news->content), 100) }}
                    </p>
                    <div class="text-sm text-gray-500">
                        {{ $news->published_at->format('d M Y') }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Programs -->
@if($featuredCompetencies && $featuredCompetencies->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex justify-between items-end mb-16">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Program Keahlian</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full"></div>
            </div>
            <a href="{{ route('public.competencies.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 text-lg inline-flex items-center gap-2 group">
                Lihat Semua
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
        
        <!-- Programs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredCompetencies->take(3) as $competency)
            <a href="{{ route('public.competencies.show', $competency->slug) }}" 
               class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col h-full">
                
                <!-- Image Container -->
                @if($competency->image)
                <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    <img src="{{ Storage::url($competency->image) }}" 
                         alt="{{ $competency->name }}" 
                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300 p-4"
                         loading="lazy">
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                @else
                <div class="h-56 bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif

                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <!-- Badge -->
                    <div class="inline-flex mb-4">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                            Program Keahlian
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="font-bold text-xl mb-3 text-gray-900 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                        {{ $competency->name }}
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 flex-grow mb-4">
                        {{ Str::limit(strip_tags($competency->description), 150) }}
                    </p>

                    <!-- CTA Link -->
                    <div class="flex items-center gap-2 text-blue-600 font-semibold text-sm group-hover:gap-3 transition-all duration-300">
                        <span>Pelajari Lebih Lanjut</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Bottom Border Accent -->
                <div class="h-1 w-0 group-hover:w-full bg-gradient-to-r from-blue-600 to-indigo-600 transition-all duration-300"></div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Gallery -->
@if($latestGalleryAlbums && $latestGalleryAlbums->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Galeri Kegiatan</h2>
            <a href="{{ route('public.gallery.index') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($latestGalleryAlbums->take(4) as $album)
            <a href="{{ route('public.gallery.show', $album->slug) }}" 
               class="relative h-56 rounded-2xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                @if($album->cover_image)
                <img src="{{ Storage::url($album->cover_image) }}" 
                     alt="{{ $album->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                     loading="lazy">
                @elseif($album->items->first())
                <img src="{{ Storage::url($album->items->first()->image_path) }}" 
                     alt="{{ $album->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                     loading="lazy">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-4">
                    <div class="text-white">
                        <h4 class="font-bold text-sm mb-1">{{ $album->name }}</h4>
                        <span class="text-xs opacity-90">{{ $album->items->count() }} Foto</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
@if($sliders && $sliders->count() > 1)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = new Swiper('.home-hero-slider', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },
        speed: 1000,
        spaceBetween: 0,
        slidesPerView: 1,
        slidesPerGroup: 1,
        centeredSlides: false,
        grabCursor: true,
        touchRatio: 1,
        touchAngle: 45,
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        on: {
            slideChange: function() {
                // Reset animation on slide change
                const images = document.querySelectorAll('.home-hero-slider .swiper-slide img');
                images.forEach(img => {
                    img.style.animation = 'none';
                    setTimeout(() => {
                        img.style.animation = '';
                    }, 10);
                });
            }
        }
    });
});
</script>
@endif
@endpush

@push('styles')
<style>
/* Swiper Base Styles */
.home-hero-slider {
    width: 100% !important;
    overflow: hidden !important;
    display: block !important;
}

.home-hero-slider .swiper-wrapper {
    width: 100% !important;
    display: flex !important;
    flex-wrap: nowrap !important;
    box-sizing: border-box !important;
}

.home-hero-slider .swiper-slide {
    width: 100% !important;
    height: auto !important;
    flex-shrink: 0 !important;
    box-sizing: border-box !important;
    transition: opacity 0.5s ease-in-out !important;
}

/* Smooth transition between slides */
.home-hero-slider .swiper-slide:not(.swiper-slide-active) {
    pointer-events: none;
    opacity: 0;
}

.home-hero-slider .swiper-slide-active {
    opacity: 1;
    z-index: 10;
}

/* Ken Burns Animation - Zoom and Pan Effect */
@keyframes ken-burns {
    0% {
        transform: scale(1) translate(0, 0);
    }
    50% {
        transform: scale(1.05) translate(5px, -5px);
    }
    100% {
        transform: scale(1.1) translate(10px, -10px);
    }
}

.animate-ken-burns {
    animation: ken-burns 8s ease-in-out forwards;
    transform-origin: center center;
}

/* Alternative smooth pan effect */
@keyframes slide-zoom {
    0% {
        transform: scale(1) translateX(0);
        opacity: 1;
    }
    100% {
        transform: scale(1.08) translateX(20px);
        opacity: 1;
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.swiper-button-next,
.swiper-button-prev {
    color: white;
    background: rgba(0, 0, 0, 0.4);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: rgba(0, 0, 0, 0.7);
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

.swiper-button-next:active,
.swiper-button-prev:active {
    transform: scale(0.95);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 24px;
    font-weight: bold;
}

.swiper-button-prev::after {
    content: '❮';
}

.swiper-button-next::after {
    content: '❯';
}

.swiper-pagination-bullet {
    background: white;
    opacity: 0.5;
    transition: opacity 0.3s ease;
}

.swiper-pagination-bullet-active {
    opacity: 1;
}

/* Smooth fade transition */
.swiper-slide img {
    transition: all 0.5s ease-in-out;
}

.swiper-slide-active img {
    filter: brightness(1);
}

.swiper-slide:not(.swiper-slide-active) img {
    filter: brightness(0.95);
}
</style>
@endpush
@endsection
