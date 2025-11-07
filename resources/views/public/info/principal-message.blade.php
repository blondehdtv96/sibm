@extends('layouts.public-tailwind')

@section('title', 'Sambutan Kepala Sekolah - ' . config('school.name'))

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700"></div>
    
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="principal-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#principal-grid)" />
        </svg>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-cyan-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Icon -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white/30 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 leading-tight tracking-tight">
            Sambutan Kepala Sekolah
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl text-white/95 mb-4 max-w-4xl mx-auto leading-relaxed font-light">
            {{ config('school.name', 'SMK Bina Mandiri Bekasi') }}
        </p>
        <p class="text-lg text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
            Pesan dan harapan dari pimpinan sekolah untuk seluruh keluarga besar sekolah
        </p>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Content Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Content Card -->
            <article class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-900 font-medium">Sambutan Kepala Sekolah</span>
                    </nav>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        @if($principalMessage)
                            <!-- Principal Info -->
                            @if($principalPhoto || $principalName)
                                <div class="flex items-center gap-6 mb-8 not-prose">
                                    @if($principalPhoto)
                                        <img src="{{ asset('storage/' . $principalPhoto) }}" alt="{{ $principalName }}" class="w-32 h-32 rounded-full object-cover border-4 border-emerald-100 shadow-lg">
                                    @endif
                                    @if($principalName)
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $principalName }}</h3>
                                            <p class="text-emerald-600 font-medium">Kepala Sekolah</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Message -->
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($principalMessage)) !!}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-4">Konten Belum Tersedia</h3>
                                <p class="text-gray-600">Sambutan kepala sekolah akan segera tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer -->
                <footer class="bg-gray-50 px-8 md:px-12 py-6 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <a href="{{ route('info.about') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-xl font-semibold hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Profil
                        </a>

                        <a href="{{ route('ppdb.register') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Daftar Sekarang
                        </a>
                    </div>
                </footer>
            </article>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, -50px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(0.9); }
        75% { transform: translate(50px, 50px) scale(1.05); }
    }
    
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    
    .prose { max-width: none; }
    .prose h1, .prose h2, .prose h3 { color: #1f2937; font-weight: 600; }
    .prose p { color: #374151; line-height: 1.7; }
</style>
@endpush
