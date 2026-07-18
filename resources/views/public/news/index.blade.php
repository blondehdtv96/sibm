@extends('layouts.public-tailwind')

@section('title', 'Berita & Pengumuman - ' . config('school.name'))

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Gradient Background with Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700"></div>
    
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="news-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#news-grid)" />
        </svg>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- News Icon -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white/30 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 leading-tight tracking-tight">
            Berita & Pengumuman
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl text-white/95 mb-4 max-w-4xl mx-auto leading-relaxed font-light">
            Tetap Update dengan Berita dan Acara Terbaru dari Sekolah Kami
        </p>
        <p class="text-lg text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
            Dapatkan informasi terkini tentang kegiatan sekolah, prestasi siswa, dan pengumuman penting lainnya
        </p>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $news->total() }}+</div>
                <div class="text-white/80 text-sm md:text-base">Total Berita</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $categories->count() }}+</div>
                <div class="text-white/80 text-sm md:text-base">Kategori</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">100+</div>
                <div class="text-white/80 text-sm md:text-base">Prestasi</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">50+</div>
                <div class="text-white/80 text-sm md:text-base">Acara per Tahun</div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cari Berita</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Temukan berita dan informasi yang Anda cari dengan mudah
            </p>
        </div>
        
        <!-- Search Form -->
        <div class="max-w-2xl mx-auto mb-12">
            <form method="GET" action="{{ route('public.news.index') }}" class="relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari berita..." 
                        class="w-full pl-12 pr-32 py-4 text-lg border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center gap-2 pr-2">
                        @if(request()->hasAny(['search', 'category']))
                            <a href="{{ route('public.news.index') }}" 
                               class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors rounded-lg">
                                Clear
                            </a>
                        @endif
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <a href="{{ route('public.news.index') }}" 
               class="px-6 py-3 rounded-full font-semibold transition-all duration-300 {{ !request('category') ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-blue-50 border border-gray-200' }}">
                Semua Berita
            </a>
            @foreach($categories as $category)
                @if($category->published_news_count > 0)
                    <a href="{{ route('public.news.index', ['category' => $category->slug]) }}" 
                       class="px-6 py-3 rounded-full font-semibold transition-all duration-300 flex items-center gap-2 {{ request('category') === $category->slug ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-blue-50 border border-gray-200' }}">
                        {{ $category->name }}
                        <span class="px-2 py-1 text-xs rounded-full {{ request('category') === $category->slug ? 'bg-white/20' : 'bg-gray-100' }}">
                            {{ $category->published_news_count }}
                        </span>
                    </a>
                @endif
            @endforeach
        </div>

        @if($selectedCategory)
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $selectedCategory->name }}</h3>
                @if($selectedCategory->description)
                    <p class="text-gray-600 max-w-2xl mx-auto">{{ $selectedCategory->description }}</p>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- News Grid Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($news->count() > 0)
            <!-- Results Header -->
            <div class="text-center mb-10">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    @if(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @elseif($selectedCategory)
                        {{ $selectedCategory->name }}
                    @else
                        Semua Berita Terbaru
                    @endif
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mx-auto rounded-full mb-6"></div>
                <p class="text-base sm:text-lg text-gray-600">
                    Menampilkan {{ $news->count() }} dari {{ $news->total() }} total berita
                </p>
            </div>
            
            <!-- News Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
                @foreach($news as $article)
                    <article class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 h-full flex flex-col">
                        <!-- Image Section with Overlay -->
                        <div class="relative h-36 sm:h-44 overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-600 to-indigo-700 flex-shrink-0">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                                <!-- Overlay for better text contrast -->
                                <div class="absolute inset-0 bg-gradient-to-b from-black/0 via-black/0 to-black/40 group-hover:from-black/20 group-hover:to-black/60 transition-all duration-300"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-500 to-blue-600 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Category Badge - Floating -->
                            @if($article->category)
                                <div class="absolute top-2.5 left-2.5 z-10">
                                    <span class="px-2.5 py-1 bg-white/95 backdrop-blur-md text-indigo-600 text-[10px] sm:text-xs font-bold rounded-full shadow-md">
                                        {{ $article->category->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content Section -->
                        <div class="p-3.5 sm:p-4 flex flex-col flex-grow">
                            <!-- Date -->
                            <div class="flex items-center gap-1 text-[11px] sm:text-xs text-gray-400 mb-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $article->published_at->format('d M Y') }}
                            </div>

                            <!-- Title -->
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors duration-300 leading-snug">
                                {{ $article->title }}
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-500 text-xs sm:text-sm leading-relaxed line-clamp-2 mb-3 flex-grow">
                                {{ Str::limit(strip_tags($article->excerpt ?? $article->content), 90) }}
                            </p>

                            <!-- Read More -->
                            <a href="{{ route('public.news.show', $article->slug) }}" 
                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-700 font-semibold text-xs sm:text-sm mt-auto pt-2 border-t border-gray-100 group/link">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="mt-16 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg p-4">
                        {{ $news->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        @if(request('search'))
                            Tidak Ada Berita yang Ditemukan
                        @elseif(request('category'))
                            Belum Ada Berita di Kategori Ini
                        @else
                            Belum Ada Berita
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        @if(request('search'))
                            Tidak ada berita yang sesuai dengan pencarian "{{ request('search') }}". Coba kata kunci lain atau lihat semua berita.
                        @elseif(request('category'))
                            Belum ada artikel di kategori {{ $selectedCategory->name }}. Silakan cek kategori lain.
                        @else
                            Berita akan segera tersedia. Silakan kembali lagi nanti!
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('public.news.index') }}" 
                           class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span>Lihat Semua Berita</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-grid)" />
        </svg>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-white/10 rounded-full animate-pulse animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/10 rounded-full animate-pulse animation-delay-4000"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
            Jangan Lewatkan Berita Terbaru!
        </h2>
        <p class="text-xl text-white/90 mb-12 leading-relaxed max-w-2xl mx-auto">
            Ikuti terus perkembangan sekolah dan dapatkan informasi terkini langsung dari sumbernya
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('ppdb.register') }}" 
               class="group px-10 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            
            <a href="{{ route('info.contact') }}" 
               class="px-10 py-4 bg-white/10 backdrop-blur-lg text-white rounded-2xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
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
    
    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
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
    
    /* Intersection Observer Animation Classes */
    .fade-in-section {
        opacity: 0;
        transform: translateY(20vh);
        visibility: hidden;
        transition: opacity 0.8s ease-out, transform 1.2s ease-out;
        will-change: opacity, visibility;
    }
    
    .fade-in-section.is-visible {
        opacity: 1;
        transform: none;
        visibility: visible;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced Scroll Animation Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    
                    // Add staggered animation to child elements
                    const children = entry.target.querySelectorAll('.animate-on-scroll');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add('animate-fade-in-up');
                        }, index * 100);
                    });
                }
            });
        }, observerOptions);
        
        // Observe all sections with fade-in-section class
        document.querySelectorAll('section').forEach(section => {
            section.classList.add('fade-in-section');
            observer.observe(section);
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Search form enhancement
        const searchForm = document.querySelector('form[method="GET"]');
        const searchInput = searchForm?.querySelector('input[name="search"]');
        
        if (searchInput) {
            // Auto-focus search input when page loads (if no search term)
            if (!searchInput.value) {
                setTimeout(() => {
                    searchInput.focus();
                }, 1000);
            }
            
            // Clear search on Escape key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && this.value) {
                    this.value = '';
                    searchForm.submit();
                }
            });
        }
        
        // Category filter enhancement
        const categoryLinks = document.querySelectorAll('a[href*="category="]');
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add loading state
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
            });
        });
    });
</script>
@endpush
