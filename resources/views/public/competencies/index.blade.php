@extends('layouts.public-tailwind')

@section('title', 'Program Keahlian - ' . config('school.name'))

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Gradient Background with Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-blue-600 to-purple-700"></div>
    
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="competencies-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#competencies-grid)" />
        </svg>
    </div>
    
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
            Program Keahlian
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl text-white/95 mb-4 max-w-4xl mx-auto leading-relaxed font-light">
            Jelajahi Beragam Jalur Pendidikan dan Program Kompetensi Kami
        </p>
        <p class="text-lg text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
            Temukan program keahlian yang sesuai dengan minat dan bakat Anda untuk mempersiapkan karir masa depan yang cemerlang
        </p>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">15+</div>
                <div class="text-white/80 text-sm md:text-base">Program Keahlian</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">100%</div>
                <div class="text-white/80 text-sm md:text-base">Terakreditasi</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">95%</div>
                <div class="text-white/80 text-sm md:text-base">Tingkat Kelulusan</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">85%</div>
                <div class="text-white/80 text-sm md:text-base">Langsung Kerja</div>
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

<!-- Search Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cari Program Keahlian</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-blue-600 mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Temukan program keahlian yang sesuai dengan minat dan passion Anda
            </p>
        </div>
        
        <!-- Search Form -->
        <div class="max-w-2xl mx-auto">
            <form method="GET" action="{{ route('public.competencies.index') }}" class="relative">
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
                        placeholder="Cari program keahlian..." 
                        class="w-full pl-12 pr-32 py-4 text-lg border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center gap-2 pr-2">
                        @if(request('search'))
                            <a href="{{ route('public.competencies.index') }}" 
                               class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors rounded-lg">
                                Hapus
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
    </div>
</section>

<!-- Competencies Grid Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($competencies->count() > 0)
            <!-- Results Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    @if(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @else
                        Semua Program Keahlian
                    @endif
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-blue-600 mx-auto rounded-full mb-6"></div>
                <p class="text-lg text-gray-600">
                    Ditemukan {{ $competencies->count() }} program keahlian
                </p>
            </div>
            
            <!-- Competencies Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($competencies as $competency)
                    <article class="group bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 relative">
                        <!-- Image Section -->
                        @if($competency->image)
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ asset('storage/' . $competency->image) }}" 
                                     alt="{{ $competency->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="h-64 bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Content Section -->
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('public.competencies.show', $competency) }}">
                                    {{ $competency->name }}
                                </a>
                            </h3>

                            <p class="text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($competency->description), 150) }}
                            </p>

                            <a href="{{ route('public.competencies.show', $competency) }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 group/btn">
                                <span>Pelajari Lebih Lanjut</span>
                                <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        @if(request('search'))
                            Tidak Ada Program yang Ditemukan
                        @else
                            Belum Ada Program Keahlian
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        @if(request('search'))
                            Tidak ada program yang sesuai dengan pencarian "{{ request('search') }}". Coba kata kunci lain atau lihat semua program.
                        @else
                            Program keahlian akan segera tersedia. Silakan kembali lagi nanti!
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('public.competencies.index') }}" 
                           class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span>Lihat Semua Program</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-gradient-to-br from-green-600 via-blue-600 to-purple-700 relative overflow-hidden">
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
            Siap Memulai Karir Impian Anda?
        </h2>
        <p class="text-xl text-white/90 mb-12 leading-relaxed max-w-2xl mx-auto">
            Bergabunglah dengan program keahlian terbaik dan wujudkan masa depan yang cemerlang bersama kami
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Konsultasi Gratis</span>
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
        
        // Counter animation for statistics
        const counters = document.querySelectorAll('.counter');
        const counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    const increment = target / 100;
                    let current = 0;
                    
                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.ceil(current);
                            setTimeout(updateCounter, 20);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    
                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => {
            counterObserver.observe(counter);
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
    });
</script>
@endpush
