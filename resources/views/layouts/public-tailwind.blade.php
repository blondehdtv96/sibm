<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('school.name', 'School Management System'))</title>
    <meta name="description" content="@yield('description', config('school.description', 'Modern school management system'))">
    
    <!-- Fonts - Inter for modern iOS look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN (for quick setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    @stack('styles')
</head>

<body class="font-sans antialiased bg-white text-gray-900">
    <!-- Navbar with Glassmorphism -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = window.pageYOffset > 20"
         :class="scrolled ? 'bg-white/80 backdrop-blur-lg shadow-lg' : 'bg-transparent'"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @php
                        try {
                            $siteLogo = App\Models\Setting::get('site_logo');
                            $siteName = App\Models\Setting::get('site_name', 'SMK Bina Mandiri Bekasi');
                            $siteTagline = App\Models\Setting::get('site_tagline', 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan');
                        } catch (\Exception $e) {
                            $siteLogo = null;
                            $siteName = 'SMK Bina Mandiri Bekasi';
                            $siteTagline = 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan';
                        }
                    @endphp
                    
                    @if($siteLogo)
                        <img src="{{ App\Models\Setting::getLogo('site_logo') }}" alt="{{ $siteName }}" class="h-12 w-auto">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <div class="hidden sm:block">
                        <div class="text-lg font-bold" :class="scrolled ? 'text-gray-900' : 'text-white'">
                            {{ $siteName }}
                        </div>
                        <div class="text-xs" :class="scrolled ? 'text-gray-600' : 'text-white/80'">
                            {{ $siteTagline }}
                        </div>
                    </div>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('home') ? 'border-b-2 border-current' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('info.about') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('info.about') ? 'border-b-2 border-current' : '' }}">
                        Tentang
                    </a>
                    <a href="{{ route('public.competencies.index') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('public.competencies.*') ? 'border-b-2 border-current' : '' }}">
                        Program
                    </a>
                    <a href="{{ route('public.news.index') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('public.news.*') ? 'border-b-2 border-current' : '' }}">
                        Berita
                    </a>
                    <a href="{{ route('public.gallery.index') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('public.gallery.*') ? 'border-b-2 border-current' : '' }}">
                        Galeri
                    </a>
                    <a href="{{ route('info.contact') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors {{ request()->routeIs('info.contact') ? 'border-b-2 border-current' : '' }}">
                        Kontak
                    </a>
                </div>
                
                <!-- CTA Buttons -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('ppdb.register') }}" 
                       class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all">
                        Daftar PPDB
                    </a>
                    @guest
                    <a href="{{ route('login') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors">
                        Login
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="font-medium transition-colors">
                        Dashboard
                    </a>
                    @endguest
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        :class="scrolled ? 'text-gray-900' : 'text-white'"
                        class="lg:hidden p-2">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="lg:hidden py-4 bg-white rounded-2xl shadow-xl mt-2">
                <div class="flex flex-col gap-2 px-4">
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Beranda
                    </a>
                    <a href="{{ route('info.about') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('info.about') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Tentang
                    </a>
                    <a href="{{ route('public.competencies.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('public.competencies.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Program
                    </a>
                    <a href="{{ route('public.news.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('public.news.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Berita
                    </a>
                    <a href="{{ route('public.gallery.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('public.gallery.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Galeri
                    </a>
                    <a href="{{ route('info.contact') }}" class="px-4 py-3 rounded-xl hover:bg-gray-100 font-medium {{ request()->routeIs('info.contact') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                        Kontak
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="{{ route('ppdb.register') }}" class="px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold text-center">
                        Daftar PPDB
                    </a>
                    @guest
                    <a href="{{ route('login') }}" class="px-4 py-3 text-center rounded-xl hover:bg-gray-100 font-medium text-gray-700">
                        Login
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="px-4 py-3 text-center rounded-xl hover:bg-gray-100 font-medium text-gray-700">
                        Dashboard
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    
    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- School Info -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">{{ config('school.name', 'SMK Bina Mandiri') }}</h3>
                            <p class="text-sm text-white/70">{{ config('school.tagline', 'Excellence in Education') }}</p>
                        </div>
                    </div>
                    <p class="text-white/70 leading-relaxed">
                        {{ config('school.description', 'Membangun generasi unggul dengan pendidikan berkualitas dan fasilitas modern.') }}
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Navigasi Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-white/70 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('info.about') }}" class="text-white/70 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('public.competencies.index') }}" class="text-white/70 hover:text-white transition-colors">Program Keahlian</a></li>
                        <li><a href="{{ route('public.news.index') }}" class="text-white/70 hover:text-white transition-colors">Berita & Acara</a></li>
                        <li><a href="{{ route('public.gallery.index') }}" class="text-white/70 hover:text-white transition-colors">Galeri</a></li>
                        <li><a href="{{ route('info.contact') }}" class="text-white/70 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-white/70 leading-relaxed">{{ config('school.address', 'Jl. Pendidikan No. 123, Bekasi') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span class="text-white/70">{{ config('school.phone', '+62 21 1234 5678') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span class="text-white/70">{{ config('school.email', 'info@smkbinamandiri.sch.id') }}</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="border-t border-white/10 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-white/60 text-sm">
                        &copy; {{ date('Y') }} {{ config('school.name', 'SMK Bina Mandiri Bekasi') }}. All rights reserved.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-white/60 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-white/60 hover:text-white transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
    
    <!-- Loading Components -->
    @include('components.page-loader')
    @include('components.ajax-loader')
    @include('components.button-loading')
    
    <!-- Chatbot Widget -->
    @include('components.chatbot')
    
    <!-- WhatsApp Float Button (Left side) -->
    <x-whatsapp-float 
        phone="6281292760717" 
        message="Halo, saya ingin bertanya tentang SMK Bina Mandiri Bekasi"
        position="left"
    />
</body>
</html>
