<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Force HTTPS for all requests -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>@yield('title', 'SMK Bina Mandiri Kota Bekasi - Sekolah Menengah Kejuruan Terbaik di Bekasi')</title>
    <meta name="description" content="@yield('description', 'SMK Bina Mandiri Kota Bekasi adalah sekolah menengah kejuruan terbaik di Bekasi dengan program keahlian unggulan, fasilitas modern, dan tingkat kelulusan 95%. Daftar PPDB sekarang!')">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="@yield('keywords', 'SMK Bina Mandiri, SMK Bekasi, sekolah kejuruan bekasi, PPDB SMK Bekasi, program keahlian, teknik komputer jaringan, teknik kendaraan ringan, teknik sepeda motor, SMK terbaik bekasi, pendaftaran siswa baru')">
    <meta name="author" content="SMK Bina Mandiri Kota Bekasi">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="geo.region" content="ID-JB">
    <meta name="geo.placename" content="Bekasi, Jawa Barat, Indonesia">
    <meta name="geo.position" content="-6.2383,106.9756">
    <meta name="ICBM" content="-6.2383,106.9756">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'SMK Bina Mandiri Kota Bekasi - Sekolah Menengah Kejuruan Terbaik di Bekasi')">
    <meta property="og:description" content="@yield('og_description', 'SMK Bina Mandiri Kota Bekasi adalah sekolah menengah kejuruan terbaik di Bekasi dengan program keahlian unggulan, fasilitas modern, dan tingkat kelulusan 95%. Daftar PPDB sekarang!')">
    <meta property="og:image" content="@yield('og_image', asset('storage/' . setting('site_logo', 'images/logo-default.png')))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="SMK Bina Mandiri Kota Bekasi">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('twitter_title', 'SMK Bina Mandiri Kota Bekasi - Sekolah Menengah Kejuruan Terbaik di Bekasi')">
    <meta name="twitter:description" content="@yield('twitter_description', 'SMK Bina Mandiri Kota Bekasi adalah sekolah menengah kejuruan terbaik di Bekasi dengan program keahlian unggulan, fasilitas modern, dan tingkat kelulusan 95%.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('storage/' . setting('site_logo', 'images/logo-default.png')))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . setting('site_favicon', 'favicon.ico')) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('site_logo', 'images/logo-default.png')) }}">
    
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "SMK Bina Mandiri Kota Bekasi",
        "alternateName": "SMK Bina Mandiri Bekasi",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('storage/' . setting('site_logo', 'images/logo-default.png')) }}",
        "description": "Sekolah Menengah Kejuruan terbaik di Bekasi dengan program keahlian unggulan dan fasilitas modern",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ setting('contact_address', 'Jl. Raya Bekasi') }}",
            "addressLocality": "Bekasi",
            "addressRegion": "Jawa Barat",
            "postalCode": "17000",
            "addressCountry": "ID"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ setting('contact_phone', '+62-21-12345678') }}",
            "contactType": "customer service",
            "email": "{{ setting('contact_email', 'info@smkbinamandiri.sch.id') }}"
        },
        "sameAs": [
            "{{ setting('social_facebook', '#') }}",
            "{{ setting('social_instagram', '#') }}",
            "{{ setting('social_youtube', '#') }}"
        ],
        "foundingDate": "2000",
        "numberOfStudents": "1000",
        "educationalCredentialAwarded": "Diploma SMK"
    }
    </script>
    
    <!-- SEO Components -->
    @include('components.seo-head')
    
    <!-- Fonts - Inter for modern iOS look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    
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
    <!-- Navbar with Glassmorphism - Responsive -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = window.pageYOffset > 20"
         :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-lg' : 'bg-black/20 backdrop-blur-sm'"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <div class="flex items-center justify-between h-16 lg:h-18">
                <!-- Logo - Compact & Responsive -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    @php
                        $siteLogo = setting('site_logo');
                        $siteName = setting('site_name', 'SMK Bina Mandiri Bekasi');
                        $siteTagline = setting('site_tagline', 'Ikhlas Berkarya Pelayanan Prima');
                        $logoUrl = $siteLogo ? asset('storage/' . $siteLogo) : null;
                    @endphp
                    
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-10 w-auto object-contain bg-white rounded-lg p-0.5 shadow-sm" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center" style="display: none;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <div class="hidden md:block min-w-0">
                        <div class="text-sm lg:text-base font-bold truncate" :class="scrolled ? 'text-gray-900' : 'text-white'">
                            {{ $siteName }}
                        </div>
                        <div class="text-xs truncate" :class="scrolled ? 'text-gray-500' : 'text-white/70'">
                            {{ $siteTagline }}
                        </div>
                    </div>
                </a>
                
                <!-- Desktop Navigation - Responsive & Compact -->
                <div class="hidden xl:flex items-center gap-1">
                    <!-- Dynamic Menu Items from Database -->
                    @if(isset($navigationMenus) && $navigationMenus->count() > 0)
                        @foreach($navigationMenus as $menu)
                            @if($menu->children->count() > 0)
                                <!-- Dropdown Menu -->
                                <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                                    <button 
                                        :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                                        class="px-3 py-2 text-sm font-medium transition-colors flex items-center gap-1 rounded-lg hover:bg-white/10">
                                        {{ $menu->title }}
                                        <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown Items -->
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="absolute left-0 mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->full_url }}" 
                                               @if($child->target) target="{{ $child->target }}" @endif
                                               class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Single Menu Item -->
                                <a href="{{ $menu->full_url }}" 
                                   @if($menu->target) target="{{ $menu->target }}" @endif
                                   :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                                   class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10 {{ $menu->route_name === 'home' && request()->routeIs('home') ? 'bg-white/20' : '' }}">
                                    {{ $menu->title }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback static menu if no database menus -->
                        <a href="{{ route('home') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10 {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ route('info.about') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                            Tentang
                        </a>
                        <a href="{{ route('public.competencies.index') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                            Jurusan
                        </a>
                        <a href="{{ route('public.news.index') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                            Berita
                        </a>
                        <a href="{{ route('public.gallery.index') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                            Galeri
                        </a>
                        <a href="{{ route('info.contact') }}" 
                           :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                           class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                            Kontak
                        </a>
                    @endif
                    
                    <!-- CTA Button - Integrated -->
                    <a href="{{ route('ppdb.register') }}" 
                       class="ml-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm rounded-lg font-semibold hover:shadow-lg transition-all whitespace-nowrap">
                        Daftar PPDB
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" 
                       :class="scrolled ? 'text-gray-700 hover:text-blue-600' : 'text-white hover:text-white/80'"
                       class="px-3 py-2 text-sm font-medium transition-colors rounded-lg hover:bg-white/10">
                        Dashboard
                    </a>
                    @endauth
                </div>
                
                <!-- Mobile/Tablet Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        :class="scrolled ? 'text-gray-900' : 'text-white'"
                        class="xl:hidden p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile/Tablet Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click.away="mobileMenuOpen = false"
                 class="xl:hidden absolute left-4 right-4 top-full mt-2 py-4 bg-white rounded-2xl shadow-2xl border border-gray-100">
                <div class="flex flex-col gap-1 px-3 max-h-[70vh] overflow-y-auto">
                    <!-- Dynamic Menu Items from Database -->
                    @if(isset($navigationMenus) && $navigationMenus->count() > 0)
                        @foreach($navigationMenus as $menu)
                            @if($menu->children->count() > 0)
                                <!-- Parent with Children -->
                                <div x-data="{ open: false }" class="space-y-1">
                                    <button @click="open = !open" class="w-full px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 flex items-center justify-between text-left">
                                        <span>{{ $menu->title }}</span>
                                        <svg class="w-4 h-4 transition-transform flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="pl-4 space-y-1 bg-gray-50 rounded-lg py-2 mt-1">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->full_url }}" 
                                               @if($child->target) target="{{ $child->target }}" @endif
                                               class="block px-4 py-2.5 rounded-lg hover:bg-white text-gray-600 text-sm transition-colors">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <!-- Single Menu Item -->
                                <a href="{{ $menu->full_url }}" 
                                   @if($menu->target) target="{{ $menu->target }}" @endif
                                   class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium transition-colors {{ $menu->route_name === 'home' && request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                                    {{ $menu->title }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback static menu if no database menus -->
                        <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                            Beranda
                        </a>
                        <a href="{{ route('info.about') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                            Tentang Kami
                        </a>
                        <a href="{{ route('public.competencies.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                            Program Keahlian
                        </a>
                        <a href="{{ route('public.news.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                            Berita
                        </a>
                        <a href="{{ route('public.gallery.index') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                            Galeri
                        </a>
                        <a href="{{ route('info.contact') }}" class="px-4 py-3 rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                            Kontak
                        </a>
                    @endif
                    
                    <!-- Mobile CTA -->
                    <div class="border-t border-gray-100 my-3 mx-2"></div>
                    <a href="{{ route('ppdb.register') }}" class="mx-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold text-center shadow-lg hover:shadow-xl transition-shadow">
                        Daftar PPDB Online
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-3 text-center rounded-xl hover:bg-gray-50 font-medium text-gray-700 transition-colors">
                        Dashboard
                    </a>
                    @endauth
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
        @php
            $contactAddress = setting('contact_address');
            $contactPhone = setting('contact_phone');
            $contactEmail = setting('contact_email');
            $socialFacebook = setting('social_facebook');
            $socialInstagram = setting('social_instagram');
            $socialYoutube = setting('social_youtube');
            $socialTwitter = setting('social_twitter');
            $socialTiktok = setting('social_tiktok');
            $socialLinkedin = setting('social_linkedin');
        @endphp
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- School Info -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="w-12 h-12 object-contain bg-white border-2 border-white rounded-lg p-1 shadow-md">
                        @else
                            <div class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold">{{ $siteName ?: 'SMK Bina Mandiri Kota Bekasi' }}</h3>
                            @if($siteTagline)
                                <p class="text-sm text-white/70">{{ $siteTagline }}</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-white/70 leading-relaxed">
                        Unggul dalam Prestasi, Berkarakter dalam Budi Pekerti
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
                        @if($contactAddress)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-white/70 leading-relaxed">{{ $contactAddress }}</span>
                            </li>
                        @endif
                        @if($contactPhone)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <a href="tel:{{ $contactPhone }}" class="text-white/70 hover:text-white transition-colors">{{ $contactPhone }}</a>
                            </li>
                        @endif
                        @if($contactEmail)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <a href="mailto:{{ $contactEmail }}" class="text-white/70 hover:text-white transition-colors">{{ $contactEmail }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Ikuti Kami</h4>
                    <div class="flex flex-wrap gap-3">
                        @if($socialFacebook)
                            <a href="{{ $socialFacebook }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        @endif
                        @if($socialInstagram)
                            <a href="{{ $socialInstagram }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif
                        @if($socialYoutube)
                            <a href="{{ $socialYoutube }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        @endif
                        @if($socialTwitter)
                            <a href="{{ $socialTwitter }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        @endif
                        @if($socialTiktok)
                            <a href="{{ $socialTiktok }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="TikTok">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        @endif
                        @if($socialLinkedin)
                            <a href="{{ $socialLinkedin }}" target="_blank" rel="noopener" class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center hover:bg-white/20 transition-all transform hover:-translate-y-1" title="LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="border-t border-white/10 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-white/60 text-sm">
                        &copy; {{ date('Y') }} {{ $siteName ?: 'SMK Bina Mandiri Kota Bekasi' }}. All rights reserved.
                    </p>
                    <div class="flex gap-6 text-sm">
                        <a href="#" class="text-white/60 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-white/60 hover:text-white transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Force HTTPS Script -->
    <script>
        // Force all requests to use HTTPS
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            location.replace('https:' + window.location.href.substring(window.location.protocol.length));
        }
        
        // Override fetch to force HTTPS
        const originalFetch = window.fetch;
        window.fetch = function(url, options) {
            if (typeof url === 'string' && url.startsWith('http://')) {
                url = url.replace('http://', 'https://');
            }
            return originalFetch(url, options);
        };
    </script>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
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
