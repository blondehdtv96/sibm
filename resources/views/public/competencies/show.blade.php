@extends('layouts.public-tailwind')

@section('title', $competency->name . ' - Program Keahlian')
@section('description', Str::limit(strip_tags($competency->description), 160))

@if($competency->image)
@section('og_image', asset('storage/' . $competency->image))
@endif

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-white transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('public.competencies.index') }}" class="ml-2 text-white/80 hover:text-white transition">Program Keahlian</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2 text-white font-medium">{{ $competency->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $competency->name }}</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Program Keahlian Unggulan
            </p>
        </div>
    </div>
</section>



<!-- Content Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar with Image -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 sticky top-24">
                    @if($competency->image)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $competency->image) }}" 
                                 alt="{{ $competency->name }}" 
                                 class="w-full h-48 rounded-xl object-contain bg-white p-4 border-4 border-white shadow-lg">
                        </div>
                    @else
                        <div class="mb-6">
                            <div class="w-full h-48 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center border-4 border-white shadow-lg">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $competency->name }}</h3>
                        <p class="text-blue-600 font-medium">Program Keahlian</p>
                    </div>
                    
                    <div class="border-t border-indigo-200 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Program Lainnya</h4>
                        <div class="space-y-2">
                            @if($otherCompetencies->count() > 0)
                                @foreach($otherCompetencies->take(5) as $other)
                                    <a href="{{ route('public.competencies.show', $other) }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        {{ Str::limit($other->name, 30) }}
                                    </a>
                                @endforeach
                            @endif
                            <a href="{{ route('public.competencies.index') }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Lihat Semua Program
                            </a>
                            <a href="{{ route('info.contact') }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Head of Program Section -->
                @if($competency->head_of_program_name || $competency->head_of_program_message)
                <div class="bg-white rounded-xl p-6 border-2 border-indigo-100 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Sambutan Kepala Program</h3>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        @if($competency->head_of_program_photo)
                        <div class="flex-shrink-0">
                            <img src="{{ $competency->head_of_program_photo_url }}" 
                                 alt="{{ $competency->head_of_program_name }}"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                        </div>
                        @endif
                        
                        <div class="flex-1">
                            @if($competency->head_of_program_name)
                            <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $competency->head_of_program_name }}</h4>
                            <p class="text-blue-600 font-medium mb-4">Kepala Program {{ $competency->name }}</p>
                            @endif
                            
                            @if($competency->head_of_program_message)
                            <p class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($competency->head_of_program_message)) !!}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Description Section -->
                <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-8 mb-8 border-l-4 border-indigo-500">
                    <svg class="w-10 h-10 text-indigo-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <div class="prose prose-lg max-w-none">
                        {!! $competency->description !!}
                    </div>
                </div>

                <!-- Gallery Section -->
                @if($competency->activeImages->count() > 0)
                <div class="bg-white rounded-xl p-6 border-2 border-blue-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Galeri Program</h3>
                    <div class="swiper competency-slider">
                        <div class="swiper-wrapper">
                            @foreach($competency->activeImages as $image)
                                <div class="swiper-slide">
                                    <div class="relative aspect-video rounded-xl overflow-hidden">
                                        <img src="{{ $image->image_url }}" alt="{{ $image->title ?? $competency->name }}" class="w-full h-full object-cover">
                                        @if($image->title || $image->description)
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                                @if($image->title)
                                                    <h4 class="text-white font-bold mb-1">{{ $image->title }}</h4>
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
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Bergabunglah Bersama Kami</h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Mari bersama-sama mewujudkan pendidikan berkualitas untuk masa depan yang lebih baik
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('ppdb.register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-indigo-50 transition shadow-lg hover:shadow-xl">
                Daftar PPDB
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
            <a href="{{ route('info.contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-800 transition border-2 border-white/20">
                Hubungi Kami
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
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
