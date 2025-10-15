<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- iOS 16 Design System -->
    @vite(['resources/css/ios16.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="ios-bg-secondary">
    <!-- Top Navigation -->
    <nav class="ios-nav fixed-top">
        <div class="ios-container">
            <div class="ios-flex ios-items-center ios-justify-between">
                <!-- Logo/Brand -->
                <div class="ios-flex ios-items-center ios-gap-md">
                    <a href="{{ route('dashboard') }}" class="ios-flex ios-items-center ios-gap-sm">
                        <div class="school-logo">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="32" height="32" rx="8" fill="var(--ios-blue)"/>
                                <path d="M8 12L16 8L24 12V20C24 22.2091 22.2091 24 20 24H12C9.79086 24 8 22.2091 8 20V12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 16H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 20H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span class="ios-headline">{{ config('school.name', 'School Management') }}</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="ios-hidden-mobile">
                    <div class="ios-flex ios-items-center ios-gap-sm">
                        <a href="{{ route('dashboard') }}" class="ios-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        @can('admin')
                        <a href="{{ route('admin.pages.index') }}" class="ios-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            Pages
                        </a>
                        
                        <a href="{{ route('admin.news.index') }}" class="ios-nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                            </svg>
                            News
                        </a>
                        @endcan
                    </div>
                </div>

                <!-- User Menu -->
                <div class="ios-flex ios-items-center ios-gap-sm">
                    <!-- Notifications -->
                    <button class="ios-button-ghost ios-button-sm notification-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </button>

                    <!-- User Dropdown -->
                    <div class="user-dropdown" x-data="{ open: false }">
                        <button @click="open = !open" class="ios-flex ios-items-center ios-gap-sm ios-button-ghost ios-button-sm">
                            <div class="user-avatar">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full">
                                @else
                                    <div class="w-8 h-8 rounded-full ios-bg-primary ios-flex ios-items-center ios-justify-center">
                                        <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <span class="ios-hidden-mobile">{{ auth()->user()->name }}</span>
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="ios-hidden-mobile">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="user-dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                Profile
                            </a>
                            <a href="{{ route('settings') }}" class="dropdown-item">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-red-600">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="ios-visible-mobile ios-button-ghost ios-button-sm mobile-menu-toggle" x-data @click="$dispatch('toggle-mobile-menu')">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav ios-visible-mobile">
        <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
            </svg>
            <span>Home</span>
        </a>
        
        @can('admin')
        <a href="{{ route('admin.pages.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
            </svg>
            <span>Pages</span>
        </a>
        
        <a href="{{ route('admin.news.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
            </svg>
            <span>News</span>
        </a>
        @endcan
        
        <a href="{{ route('profile.edit') }}" class="mobile-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
            <span>Profile</span>
        </a>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="ios-container">
            <!-- Breadcrumbs -->
            @if(isset($breadcrumbs))
            <nav class="breadcrumbs ios-m-md">
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
            @endif

            <!-- Page Header -->
            @if(isset($pageTitle) || isset($pageActions))
            <div class="page-header ios-flex ios-items-center ios-justify-between ios-m-md">
                @if(isset($pageTitle))
                <h1 class="ios-large-title">{{ $pageTitle }}</h1>
                @endif
                
                @if(isset($pageActions))
                <div class="ios-flex ios-items-center ios-gap-sm">
                    {!! $pageActions !!}
                </div>
                @endif
            </div>
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="ios-alert ios-alert-success ios-fade-in">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="ios-alert ios-alert-danger ios-fade-in">
                {{ session('error') }}
            </div>
            @endif

            @if(session('warning'))
            <div class="ios-alert ios-alert-warning ios-fade-in">
                {{ session('warning') }}
            </div>
            @endif

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Additional Scripts -->
    @stack('scripts')

    <style>
        /* Layout Specific Styles */
        .fixed-top {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .main-content {
            margin-top: 80px;
            margin-bottom: 80px;
            min-height: calc(100vh - 160px);
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--ios-background);
            border: 1px solid var(--ios-border-secondary);
            border-radius: var(--ios-radius-md);
            box-shadow: 0 8px 32px var(--ios-shadow);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            min-width: 200px;
            z-index: 1001;
            margin-top: var(--ios-spacing-xs);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: var(--ios-spacing-sm);
            padding: var(--ios-spacing-sm) var(--ios-spacing-md);
            color: var(--ios-text-primary);
            text-decoration: none;
            font-size: var(--ios-font-size-subhead);
            transition: all var(--ios-transition-fast);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: var(--ios-gray-6);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--ios-border-secondary);
            margin: var(--ios-spacing-xs) 0;
        }

        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--ios-blur-light);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid var(--ios-border-secondary);
            display: flex;
            justify-content: space-around;
            padding: var(--ios-spacing-sm) 0;
            z-index: 1000;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            color: var(--ios-text-secondary);
            text-decoration: none;
            font-size: var(--ios-font-size-caption-1);
            font-weight: 500;
            transition: all var(--ios-transition-fast);
            padding: var(--ios-spacing-xs);
            border-radius: var(--ios-radius-sm);
            min-width: 60px;
        }

        .mobile-nav-item.active {
            color: var(--ios-blue);
        }

        .mobile-nav-item:hover {
            color: var(--ios-blue);
            background: rgba(0, 122, 255, 0.1);
        }

        .breadcrumbs {
            font-size: var(--ios-font-size-subhead);
        }

        .page-header {
            border-bottom: 1px solid var(--ios-border-secondary);
            padding-bottom: var(--ios-spacing-md);
            margin-bottom: var(--ios-spacing-lg);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-bottom: 100px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--ios-spacing-md);
            }
        }
    </style>
</body>
</html>