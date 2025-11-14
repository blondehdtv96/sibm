@extends('layouts.public-tailwind')

@section('title', $competency->name . ' - Program Keahlian')
@section('description', Str::limit(strip_tags($competency->description), 160))

@if($competency->image)
@section('og_image', asset('storage/' . $competency->image))
@endif

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    @if($competency->image)
    <div class="absolute inset-0">
        <img 
            src="{{ asset('storage/' . $competency->image) }}" 
            alt="{{ $competency->name }}"
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-gradient-to-br from-green-900/80 via-blue-900/80 to-purple-900/80"></div>
    </div>
    @else
    <!-- Gradient Background with Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-blue-600 to-purple-700"></div>
    
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="competency-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#competency-grid)" />
        </svg>
    </div>
    @endif
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Program Icon -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white/30 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 leading-tight tracking-tight">
            {{ $competency->name }}
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl text-white/95 mb-4 max-w-4xl mx-auto leading-relaxed font-light">
            Program Keahlian Unggulan
        </p>
        <p class="text-lg text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
            {{ Str::limit(strip_tags($competency->description), 200) }}
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('ppdb.register') }}" 
               class="group px-10 py-4 bg-white text-green-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            <a href="{{ route('public.competencies.index') }}" 
               class="px-10 py-4 bg-white/10 backdrop-blur-lg text-white rounded-2xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Lihat Program Lain</span>
            </a>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Image Slider Section -->
@if($competency->activeImages->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Galeri {{ $competency->name }}</h2>
            <p class="text-lg text-gray-600">Lihat fasilitas dan kegiatan program keahlian kami</p>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper competency-slider">
            <div class="swiper-wrapper">
                @foreach($competency->activeImages as $image)
                    <div class="swiper-slide">
                        <div class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ $image->image_url }}" alt="{{ $image->title ?? $competency->name }}" class="w-full h-full object-cover">
                            @if($image->title || $image->description)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                                    @if($image->title)
                                        <h3 class="text-white text-xl font-bold mb-2">{{ $image->title }}</h3>
                                    @endif
                                    @if($image->description)
                                        <p class="text-white/90 text-sm">{{ $image->description }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

<!-- Content Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <article class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-8 md:p-12">
                        <!-- Breadcrumb -->
                        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('public.competencies.index') }}" class="hover:text-blue-600 transition-colors">Program Keahlian</a>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ Str::limit($competency->name, 30) }}</span>
                        </nav>

                        <!-- Content -->
                        <div class="prose prose-lg max-w-none">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Program</h2>
                            <div class="text-gray-700 leading-relaxed">
                                {!! $competency->description !!}
                            </div>
                        </div>

                        <!-- Head of Program Section -->
                        @if($competency->head_of_program_name || $competency->head_of_program_message)
                        <div class="mt-12 pt-12 border-t border-gray-200">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Sambutan Kepala Program</h2>
                            
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 md:p-10">
                                <div class="flex flex-col md:flex-row gap-8 items-start">
                                    @if($competency->head_of_program_photo)
                                    <div class="flex-shrink-0">
                                        <img src="{{ $competency->head_of_program_photo_url }}" 
                                             alt="{{ $competency->head_of_program_name }}"
                                             class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-xl">
                                    </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        @if($competency->head_of_program_name)
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $competency->head_of_program_name }}</h3>
                                        <p class="text-blue-600 font-semibold mb-6">Kepala Program {{ $competency->name }}</p>
                                        @endif
                                        
                                        @if($competency->head_of_program_message)
                                        <div class="relative">
                                            <svg class="absolute -top-2 -left-2 w-8 h-8 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                            </svg>
                                            <p class="text-gray-700 leading-relaxed text-lg pl-6">
                                                {!! nl2br(e($competency->head_of_program_message)) !!}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <footer class="bg-gray-50 px-8 md:px-12 py-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <!-- Back Button -->
                            <a href="{{ route('public.competencies.index') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-xl font-semibold hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Program
                            </a>

                            <!-- Register Button -->
                            <a href="{{ route('ppdb.register') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Daftar Program Ini
                            </a>
                        </div>
                    </footer>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <!-- Other Programs -->
                @if($otherCompetencies->count() > 0)
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Program Lainnya</h3>
                    <div class="space-y-4">
                        @foreach($otherCompetencies as $other)
                            <a href="{{ route('public.competencies.show', $other) }}" 
                               class="group flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                @if($other->image)
                                    <img src="{{ asset('storage/' . $other->image) }}" 
                                         alt="{{ $other->name }}"
                                         class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                        {{ $other->name }}
                                    </h4>
                                    <p class="text-sm text-gray-600 line-clamp-2 mt-1">
                                        {{ Str::limit(strip_tags($other->description), 80) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('public.competencies.index') }}" 
                       class="inline-flex items-center gap-2 w-full justify-center px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors mt-6">
                        <span>Lihat Semua Program</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                @endif

                <!-- CTA Card -->
                <div class="bg-gradient-to-br from-green-600 to-blue-600 rounded-3xl p-8 text-white">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Tertarik dengan Program Ini?</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">
                            Bergabunglah dengan sekolah kami dan jelajahi program keahlian ini. Daftar sekarang untuk memulai perjalanan pendidikan Anda.
                        </p>
                        <a href="{{ route('ppdb.register') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-600 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Butuh Informasi Lebih?</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Ada pertanyaan tentang program ini? Hubungi tim penerimaan kami untuk informasi lebih lanjut.
                        </p>
                        <a href="{{ route('info.contact') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    /* Custom Animations */
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        25% {
            transform: translate(20px, -50px) scale(1.1);
        }
        50% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        75% {
            transform: translate(50px, 50px) scale(1.05);
        }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Line Clamp Utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Enhanced Glassmorphism Effect */
    .backdrop-blur-lg {
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }
    
    /* Enhanced Shadow Effects */
    .shadow-3xl {
        box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* Prose Styling */
    .prose {
        max-width: none;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #1f2937;
        font-weight: 600;
    }

    .prose p {
        color: #374151;
        line-height: 1.7;
    }

    .prose a {
        color: #2563eb;
        text-decoration: none;
    }

    .prose a:hover {
        text-decoration: underline;
    }

    /* Swiper Custom Styles */
    .competency-slider {
        padding: 20px 0 60px;
    }

    .competency-slider .swiper-button-next,
    .competency-slider .swiper-button-prev {
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        backdrop-filter: blur(10px);
    }

    .competency-slider .swiper-button-next:after,
    .competency-slider .swiper-button-prev:after {
        font-size: 20px;
    }

    .competency-slider .swiper-button-next:hover,
    .competency-slider .swiper-button-prev:hover {
        background: rgba(0, 0, 0, 0.7);
    }

    .competency-slider .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: #3b82f6;
        opacity: 0.5;
    }

    .competency-slider .swiper-pagination-bullet-active {
        opacity: 1;
        background: #2563eb;
    }
</style>
@endpush

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    const swiper = new Swiper('.competency-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
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
        breakpoints: {
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: 1,
            },
        },
    });
});
</script>
@endpush
