<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'School Management') }} - Admin - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
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
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <style>
        /* Admin Layout Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f7;
            color: #1d1d1f;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Topbar */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 0 24px;
        }
        
        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 260px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 999;
        }
        
        /* Main Content */
        .admin-main {
            margin-left: 260px;
            margin-top: 64px;
            flex: 1;
            padding: 24px;
            min-height: calc(100vh - 64px);
        }
        
        /* Utility Classes */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .p-4 { padding: 1rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        
        /* iOS-style Utility Classes */
        .ios-flex { display: flex; }
        .ios-items-center { align-items: center; }
        .ios-justify-between { justify-content: space-between; }
        .ios-gap-sm { gap: 0.5rem; }
        .ios-gap-md { gap: 1rem; }
        .ios-gap-lg { gap: 1.5rem; }
        .ios-p-md { padding: 1rem; }
        .ios-h-full { height: 100%; }
        .ios-text-primary { color: #1d1d1f; }
        .ios-text-secondary { color: #86868b; }
        .ios-text-tertiary { color: #d1d1d6; }
        .ios-bg-primary { background: #007AFF; }
        .ios-bg-secondary { background: #f5f5f7; }
        .ios-color-blue { color: #007AFF; }
        
        /* Button Styles */
        .ios-button-ghost {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .ios-button-ghost:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        .ios-button-sm {
            font-size: 0.875rem;
        }
        
        /* User Avatar */
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Notification Badge */
        .notification-btn {
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: #FF3B30;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
        }
        
        /* Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            padding: 8px;
            z-index: 1000;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #1d1d1f;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: background 0.2s;
        }
        
        .dropdown-item:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        /* Sidebar */
        .sidebar-nav {
            padding: 16px;
        }
        
        .nav-section {
            margin-bottom: 24px;
        }
        
        .nav-section-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #86868b;
            padding: 0 12px;
            margin-bottom: 8px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #1d1d1f;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        
        .nav-link:hover {
            background: rgba(0, 122, 255, 0.1);
            color: #007AFF;
        }
        
        .nav-link.active {
            background: #007AFF;
            color: white;
        }
        
        /* Visibility Classes */
        .ios-hidden-mobile {
            display: block;
        }
        
        .ios-visible-mobile {
            display: none;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .ios-hidden-mobile {
                display: none !important;
            }
            
            .ios-visible-mobile {
                display: block;
            }
        }
    </style>
</head>

<body class="ios-bg-secondary admin-layout" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
    <!-- Top Navigation Bar -->
    <nav class="admin-topbar">
        <div class="ios-flex ios-items-center ios-justify-between ios-h-full ios-p-md">
            <!-- Left Side -->
            <div class="ios-flex ios-items-center ios-gap-md">
                <!-- Sidebar Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="ios-button-ghost ios-button-sm sidebar-toggle ios-visible-mobile">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <!-- Collapse Toggle (Desktop) -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="ios-button-ghost ios-button-sm sidebar-collapse ios-hidden-mobile">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                <nav class="breadcrumbs ios-hidden-mobile">
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
            </div>

            <!-- Right Side -->
            <div class="ios-flex ios-items-center ios-gap-sm">
                <!-- Quick Actions -->
                <div class="ios-flex ios-items-center ios-gap-sm ios-hidden-mobile">
                    <a href="{{ route('admin.pages.create') }}" class="ios-button-ghost ios-button-sm" title="New Page">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('admin.news.create') }}" class="ios-button-ghost ios-button-sm" title="New Article">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <!-- Notifications -->
                <button class="ios-button-ghost ios-button-sm notification-btn" title="Notifications">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    <span class="notification-badge">3</span>
                </button>

                <!-- User Menu -->
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
                        {{-- Profile and Settings routes will be added later --}}
                        {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
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
                        </a> --}}
                        <a href="{{ url('/') }}" class="dropdown-item" target="_blank">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                            </svg>
                            View Site
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
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="admin-sidebar" :class="{ 'open': sidebarOpen, 'collapsed': sidebarCollapsed }">
        <!-- Logo -->
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="var(--ios-blue)"/>
                        <path d="M8 12L16 8L24 12V20C24 22.2091 22.2091 24 20 24H12C9.79086 24 8 22.2091 8 20V12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 16H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 20H20" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="logo-text" x-show="!sidebarCollapsed">Admin Panel</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <div class="nav-section">
                <h3 class="nav-section-title" x-show="!sidebarCollapsed">Dashboard</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">Overview</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-section-title" x-show="!sidebarCollapsed">Content Management</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.pages.index') }}" class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">Pages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.news.index') }}" class="nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">News & Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.competencies.index') }}" class="nav-item {{ request()->routeIs('admin.competencies.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">Competencies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gallery-albums.index') }}" class="nav-item {{ request()->routeIs('admin.gallery-albums.*') || request()->routeIs('admin.gallery-items.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">Gallery</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-section-title" x-show="!sidebarCollapsed">Registration</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.ppdb-registrations.index') }}" class="nav-item {{ request()->routeIs('admin.ppdb-registrations.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">PPDB Registrations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.ppdb-settings.index') }}" class="nav-item {{ request()->routeIs('admin.ppdb-settings.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">PPDB Settings</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-section">
                <h3 class="nav-section-title" x-show="!sidebarCollapsed">System</h3>
                <ul class="nav-list">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span x-show="!sidebarCollapsed">Users</span>
                        </a>
                    </li>
                    <!-- Settings link will be added later -->
                </ul>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <!-- Page Header -->
        @if(isset($pageTitle) || isset($pageActions))
        <div class="page-header">
            <div class="ios-flex ios-items-center ios-justify-between">
                @if(isset($pageTitle))
                <div>
                    <h1 class="ios-large-title">{{ $pageTitle }}</h1>
                    @if(isset($pageDescription))
                    <p class="ios-text-secondary">{{ $pageDescription }}</p>
                    @endif
                </div>
                @endif
                
                @if(isset($pageActions))
                <div class="ios-flex ios-items-center ios-gap-sm">
                    {!! $pageActions !!}
                </div>
                @endif
            </div>
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
    </main>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="sidebar-overlay ios-visible-mobile" x-transition></div>

    <!-- Scripts -->
    <script src="{{ asset('js/ios16.js') }}" defer></script>
    <script src="{{ asset('js/alpine-components.js') }}" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')

    <style>
        /* Admin Layout Styles */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .admin-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: var(--ios-blur-light);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--ios-border-secondary);
            z-index: 1001;
        }

        .admin-sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            width: 280px;
            height: calc(100vh - 64px);
            background: var(--ios-background);
            border-right: 1px solid var(--ios-border-secondary);
            overflow-y: auto;
            transition: all var(--ios-transition-normal);
            z-index: 1000;
        }

        .admin-sidebar.collapsed {
            width: 80px;
        }

        .admin-main {
            flex: 1;
            margin-left: 280px;
            margin-top: 64px;
            padding: var(--ios-spacing-lg);
            transition: all var(--ios-transition-normal);
        }

        .admin-main.sidebar-collapsed {
            margin-left: 80px;
        }

        /* Sidebar Components */
        .sidebar-header {
            padding: var(--ios-spacing-lg) var(--ios-spacing-md);
            border-bottom: 1px solid var(--ios-border-secondary);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: var(--ios-spacing-sm);
            text-decoration: none;
            color: var(--ios-text-primary);
        }

        .logo-text {
            font-size: var(--ios-font-size-headline);
            font-weight: 600;
        }

        .sidebar-nav {
            padding: var(--ios-spacing-md) 0;
        }

        .nav-section {
            margin-bottom: var(--ios-spacing-lg);
        }

        .nav-section-title {
            font-size: var(--ios-font-size-caption-1);
            font-weight: 600;
            color: var(--ios-text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 var(--ios-spacing-md);
            margin-bottom: var(--ios-spacing-sm);
        }

        .nav-list {
            list-style: none;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: var(--ios-spacing-sm);
            padding: var(--ios-spacing-sm) var(--ios-spacing-md);
            color: var(--ios-text-secondary);
            text-decoration: none;
            font-size: var(--ios-font-size-subhead);
            font-weight: 500;
            transition: all var(--ios-transition-fast);
            border-radius: 0;
            margin: 0 var(--ios-spacing-sm);
            border-radius: var(--ios-radius-sm);
        }

        .nav-item:hover {
            background: var(--ios-gray-6);
            color: var(--ios-text-primary);
        }

        .nav-item.active {
            background: var(--ios-blue);
            color: white;
        }

        /* User Dropdown */
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
            z-index: 1002;
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

        /* Notification Badge */
        .notification-btn {
            position: relative;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--ios-red);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Page Header */
        .page-header {
            margin-bottom: var(--ios-spacing-lg);
            padding-bottom: var(--ios-spacing-md);
            border-bottom: 1px solid var(--ios-border-secondary);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                z-index: 1001;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-main.sidebar-collapsed {
                margin-left: 0;
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