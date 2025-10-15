<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('school.name', 'School Management System'))</title>
    <meta name="description" content="@yield('description', config('school.description', 'Modern school management system'))">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', config('school.name', 'School Management System'))">
    <meta property="og:description" content="@yield('description', config('school.description', 'Modern school management system'))">
    <meta property="og:image" content="@yield('og_image', asset('images/school-logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- iOS 16 Design System -->
    <link href="{{ asset('css/ios16.css') }}" rel="stylesheet">
    
    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="ios-bg-secondary public-layout">
    <!-- Top Navigation -->
    <nav class="public-navbar" x-data="{ mobileMenuOpen: false }">
        <div class="ios-container">
            <div class="ios-flex ios-items-center ios-justify-between">
                <!-- Logo/Brand -->
                <div class="navbar-brand">
                    <a href="{{ route('home') }}" class="ios-flex ios-items-center ios-gap-sm">
                        <div class="school-logo">
                            <svg width="40" height="40" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="32" height="32" rx="8" fill="var(--ios-blue)"/>
                                <path d="M8 12L16 8L24 12V20C24 22.2091 22.2091 24 20 24H12C9.79086 24 8 22.2091 8 20V12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 16H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 20H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="brand-text">
                            <div class="school-name">{{ config('school.name', 'School Name') }}</div>
                            <div class="school-tagline">{{ config('school.tagline', 'Excellence in Education') }}</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="navbar-nav ios-hidden-mobile">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('info.about') }}" class="nav-link {{ request()->routeIs('info.about') ? 'active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('public.competencies.index') }}" class="nav-link {{ request()->routeIs('public.competencies.*') ? 'active' : '' }}">
                        Programs
                    </a>
                    <a href="{{ route('public.news.index') }}" class="nav-link {{ request()->routeIs('public.news.*') ? 'active' : '' }}">
                        News
                    </a>
                    <a href="{{ route('public.gallery.index') }}" class="nav-link {{ request()->routeIs('public.gallery.*') ? 'active' : '' }}">
                        Gallery
                    </a>
                    <a href="{{ route('info.contact') }}" class="nav-link {{ request()->routeIs('info.contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </div>

                <!-- Action Buttons -->
                <div class="navbar-actions ios-flex ios-items-center ios-gap-sm">
                    <a href="{{ route('search') }}" class="ios-button-ghost ios-button-sm" title="Search">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('ppdb.register') }}" class="ios-button-primary ios-button-sm ios-hidden-mobile">
                        Register Now
                    </a>
                    
                    @guest
                    <a href="{{ route('login') }}" class="ios-button-outline ios-button-sm ios-hidden-mobile">
                        Login
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="ios-button-ghost ios-button-sm ios-hidden-mobile">
                        Dashboard
                    </a>
                    @endguest

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="ios-visible-mobile ios-button-ghost ios-button-sm">
                        <svg x-show="!mobileMenuOpen" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition class="mobile-menu ios-visible-mobile">
                <div class="mobile-nav-links">
                    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('info.about') }}" class="mobile-nav-link {{ request()->routeIs('info.about') ? 'active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('public.competencies.index') }}" class="mobile-nav-link {{ request()->routeIs('public.competencies.*') ? 'active' : '' }}">
                        Programs
                    </a>
                    <a href="{{ route('public.news.index') }}" class="mobile-nav-link {{ request()->routeIs('public.news.*') ? 'active' : '' }}">
                        News
                    </a>
                    <a href="{{ route('public.gallery.index') }}" class="mobile-nav-link {{ request()->routeIs('public.gallery.*') ? 'active' : '' }}">
                        Gallery
                    </a>
                    <a href="{{ route('info.contact') }}" class="mobile-nav-link {{ request()->routeIs('info.contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </div>
                
                <div class="mobile-nav-actions">
                    <a href="{{ route('ppdb.register') }}" class="ios-button-primary ios-w-full">
                        Register Now
                    </a>
                    
                    @guest
                    <a href="{{ route('login') }}" class="ios-button-outline ios-w-full">
                        Login
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="ios-button-ghost ios-w-full">
                        Dashboard
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section (if provided) -->
        @if(isset($hero))
        <section class="hero-section">
            {!! $hero !!}
        </section>
        @endif

        <!-- Breadcrumbs -->
        @if(isset($breadcrumbs) && !request()->routeIs('home'))
        <div class="ios-container">
            <nav class="breadcrumbs ios-p-md">
                <ol class="ios-flex ios-items-center ios-gap-sm">
                    @foreach($breadcrumbs as $breadcrumb)
                        <li class="ios-flex ios-items-center ios-gap-sm">
                            @if(!$loop->last)
                                <a href="{{ $breadcrumb['url'] }}" class="ios-text-secondary hover:ios-color-blue">{{ $breadcrumb['title'] }}</a>
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="ios-text-tertiary">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <span class="ios-text-primary">{{ $breadcrumb['title'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        @endif

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="ios-container">
            <div class="footer-content">
                <!-- School Info -->
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="school-logo">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="32" height="32" rx="8" fill="var(--ios-blue)"/>
                                <path d="M8 12L16 8L24 12V20C24 22.2091 22.2091 24 20 24H12C9.79086 24 8 22.2091 8 20V12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 16H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 20H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="ios-headline">{{ config('school.name', 'School Name') }}</h3>
                            <p class="ios-text-secondary">{{ config('school.tagline', 'Excellence in Education') }}</p>
                        </div>
                    </div>
                    <p class="ios-text-secondary">
                        {{ config('school.description', 'Providing quality education and nurturing future leaders with modern facilities and experienced educators.') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('info.about') }}">About Us</a></li>
                        <li><a href="{{ route('public.competencies.index') }}">Programs</a></li>
                        <li><a href="{{ route('public.news.index') }}">News & Events</a></li>
                        <li><a href="{{ route('public.gallery.index') }}">Gallery</a></li>
                        <li><a href="{{ route('info.contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h4 class="footer-title">Contact Info</h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ config('school.address', 'School Address') }}</span>
                        </div>
                        <div class="contact-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span>{{ config('school.phone', '+62 123 456 789') }}</span>
                        </div>
                        <div class="contact-item">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>{{ config('school.email', 'info@school.edu') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="footer-section">
                    <h4 class="footer-title">Follow Us</h4>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="ios-flex ios-items-center ios-justify-between">
                    <p class="ios-text-tertiary">
                        &copy; {{ date('Y') }} {{ config('school.name', 'School Name') }}. All rights reserved.
                    </p>
                    <div class="footer-links-bottom">
                        <a href="{{ route('public.pages.show', 'privacy') }}" class="ios-text-tertiary">Privacy Policy</a>
                        <a href="{{ route('public.pages.show', 'terms') }}" class="ios-text-tertiary">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/ios16.js') }}" defer></script>
    <script src="{{ asset('js/alpine-components.js') }}" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')

    <style>
        /* Public Layout Styles */
        .public-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .public-navbar {
            background: var(--ios-blur-light);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--ios-border-secondary);
            padding: var(--ios-spacing-md) 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand .school-name {
            font-size: var(--ios-font-size-headline);
            font-weight: 700;
            color: var(--ios-text-primary);
        }

        .navbar-brand .school-tagline {
            font-size: var(--ios-font-size-caption-1);
            color: var(--ios-text-secondary);
        }

        .navbar-nav {
            display: flex;
            gap: var(--ios-spacing-lg);
        }

        .nav-link {
            color: var(--ios-text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: var(--ios-spacing-sm) 0;
            border-bottom: 2px solid transparent;
            transition: all var(--ios-transition-fast);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--ios-blue);
            border-bottom-color: var(--ios-blue);
        }

        .mobile-menu {
            background: var(--ios-background);
            border-top: 1px solid var(--ios-border-secondary);
            margin-top: var(--ios-spacing-md);
            padding: var(--ios-spacing-md) 0;
            border-radius: var(--ios-radius-md);
        }

        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            gap: var(--ios-spacing-sm);
            margin-bottom: var(--ios-spacing-md);
        }

        .mobile-nav-link {
            color: var(--ios-text-primary);
            text-decoration: none;
            padding: var(--ios-spacing-sm);
            border-radius: var(--ios-radius-sm);
            font-weight: 500;
            transition: all var(--ios-transition-fast);
        }

        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: var(--ios-blue);
            color: white;
        }

        .mobile-nav-actions {
            display: flex;
            flex-direction: column;
            gap: var(--ios-spacing-sm);
        }

        .main-content {
            flex: 1;
        }

        .hero-section {
            margin-bottom: var(--ios-spacing-2xl);
        }

        .breadcrumbs {
            font-size: var(--ios-font-size-subhead);
        }

        .page-content {
            padding: var(--ios-spacing-lg) 0;
        }

        /* Footer Styles */
        .public-footer {
            background: var(--ios-background);
            border-top: 1px solid var(--ios-border-secondary);
            padding: var(--ios-spacing-2xl) 0 var(--ios-spacing-lg);
            margin-top: auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--ios-spacing-xl);
            margin-bottom: var(--ios-spacing-xl);
        }

        .footer-section h4.footer-title {
            font-size: var(--ios-font-size-headline);
            font-weight: 600;
            color: var(--ios-text-primary);
            margin-bottom: var(--ios-spacing-md);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: var(--ios-spacing-sm);
            margin-bottom: var(--ios-spacing-md);
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: var(--ios-spacing-sm);
        }

        .footer-links a {
            color: var(--ios-text-secondary);
            text-decoration: none;
            transition: color var(--ios-transition-fast);
        }

        .footer-links a:hover {
            color: var(--ios-blue);
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: var(--ios-spacing-sm);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: var(--ios-spacing-sm);
            color: var(--ios-text-secondary);
        }

        .social-links {
            display: flex;
            gap: var(--ios-spacing-sm);
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--ios-gray-6);
            color: var(--ios-text-secondary);
            border-radius: var(--ios-radius-sm);
            text-decoration: none;
            transition: all var(--ios-transition-fast);
        }

        .social-link:hover {
            background: var(--ios-blue);
            color: white;
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid var(--ios-border-secondary);
            padding-top: var(--ios-spacing-md);
        }

        .footer-links-bottom {
            display: flex;
            gap: var(--ios-spacing-md);
        }

        .footer-links-bottom a {
            text-decoration: none;
            transition: color var(--ios-transition-fast);
        }

        .footer-links-bottom a:hover {
            color: var(--ios-blue);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: var(--ios-spacing-lg);
            }

            .footer-bottom {
                flex-direction: column;
                gap: var(--ios-spacing-sm);
                text-align: center;
            }

            .footer-links-bottom {
                justify-content: center;
            }
        }
    </style>
</body>
</html>