@extends('layouts.app')

@section('title', 'Interactive Components Demo')

@section('content')
<div class="ios-container ios-p-lg">
    <h1 class="ios-large-title ios-mb-lg">Interactive Components Demo</h1>
    
    <!-- Alpine.js Components Section -->
    <div class="ios-card ios-mb-lg">
        <h2 class="ios-title-2 ios-mb-md">Alpine.js Components</h2>
        
        <!-- Image Gallery -->
        <div class="ios-mb-lg" x-data="imageGallery([
            { url: 'https://via.placeholder.com/800x600/007AFF/FFFFFF?text=Image+1', title: 'Image 1' },
            { url: 'https://via.placeholder.com/800x600/5856D6/FFFFFF?text=Image+2', title: 'Image 2' },
            { url: 'https://via.placeholder.com/800x600/34C759/FFFFFF?text=Image+3', title: 'Image 3' }
        ])">
            <h3 class="ios-headline ios-mb-sm">Image Gallery with Swipe</h3>
            <div class="ios-gallery-swipe" data-swipe>
                <img :src="currentImage.url" :alt="currentImage.title" class="w-full rounded-lg">
                <div class="ios-flex ios-justify-between ios-mt-md">
                    <button @click="previous" class="ios-button ios-button-secondary">Previous</button>
                    <span class="ios-body" x-text="`${currentIndex + 1} / ${images.length}`"></span>
                    <button @click="next" class="ios-button ios-button-secondary">Next</button>
                </div>
            </div>
        </div>
        
        <!-- Search Component -->
        <div class="ios-mb-lg" x-data="searchComponent('/api/search', 2)">
            <h3 class="ios-headline ios-mb-sm">Live Search</h3>
            <div class="relative">
                <input 
                    type="search" 
                    x-model="query" 
                    placeholder="Search..." 
                    class="ios-input w-full"
                >
                <div x-show="loading" class="absolute right-3 top-3">
                    <div class="loader-spinner" style="width: 20px; height: 20px;"></div>
                </div>
                <div x-show="showResults && results.length > 0" class="ios-card ios-mt-sm">
                    <template x-for="result in results" :key="result.id">
                        <div @click="selectResult(result)" class="dropdown-item" x-text="result.title"></div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- File Upload -->
        <div class="ios-mb-lg" x-data="fileUpload({ maxFiles: 3, maxSize: 5242880, acceptedTypes: ['image/*'] })">
            <h3 class="ios-headline ios-mb-sm">File Upload with Drag & Drop</h3>
            <div 
                class="border-2 border-dashed rounded-lg p-8 text-center transition-colors"
                :class="dragOver ? 'border-blue-500 bg-blue-50' : 'border-gray-300'"
            >
                <input 
                    type="file" 
                    @change="addFiles($event.target.files)" 
                    multiple 
                    accept="image/*" 
                    class="hidden" 
                    id="file-input"
                >
                <label for="file-input" class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Drag files here or click to browse</p>
                    <p class="text-xs text-gray-500" x-text="`Max ${maxFiles} files, ${formatFileSize(maxSize)} each`"></p>
                </label>
            </div>
            
            <div x-show="files.length > 0" class="ios-mt-md">
                <template x-for="file in files" :key="file.id">
                    <div class="ios-flex ios-items-center ios-justify-between ios-p-sm ios-mb-sm ios-bg-secondary rounded">
                        <div class="ios-flex ios-items-center ios-gap-sm">
                            <img x-show="file.preview" :src="file.preview" class="w-12 h-12 object-cover rounded">
                            <div>
                                <p class="ios-body" x-text="file.name"></p>
                                <p class="ios-caption-1 ios-text-secondary" x-text="formatFileSize(file.size)"></p>
                            </div>
                        </div>
                        <button @click="removeFile(file.id)" class="ios-button-ghost ios-button-sm text-red-600">
                            Remove
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    <!-- Touch Interactions Section -->
    <div class="ios-card ios-mb-lg">
        <h2 class="ios-title-2 ios-mb-md">Touch Interactions</h2>
        
        <!-- Touch Feedback -->
        <div class="ios-mb-lg">
            <h3 class="ios-headline ios-mb-sm">Touch Feedback</h3>
            <div class="ios-flex ios-gap-sm ios-flex-wrap">
                <button class="ios-button ios-button-primary">Tap Me</button>
                <button class="ios-button ios-button-secondary">Touch Feedback</button>
                <button class="ios-button ios-button-ghost">Ghost Button</button>
            </div>
        </div>
        
        <!-- Long Press -->
        <div class="ios-mb-lg" x-data="{ longPressed: false }">
            <h3 class="ios-headline ios-mb-sm">Long Press</h3>
            <button 
                data-long-press 
                @long-press="longPressed = true; setTimeout(() => longPressed = false, 2000)"
                class="ios-button ios-button-primary"
            >
                Long Press Me
            </button>
            <p x-show="longPressed" class="ios-caption-1 ios-text-secondary ios-mt-sm">Long press detected!</p>
        </div>
        
        <!-- Swipe Gestures -->
        <div class="ios-mb-lg" x-data="{ swipeDirection: '' }">
            <h3 class="ios-headline ios-mb-sm">Swipe Gestures</h3>
            <div 
                class="ios-card ios-p-xl text-center ios-bg-blue"
                data-swipe
                @swipe-left="swipeDirection = 'Left'"
                @swipe-right="swipeDirection = 'Right'"
                @swipe-up="swipeDirection = 'Up'"
                @swipe-down="swipeDirection = 'Down'"
            >
                <p class="text-white">Swipe in any direction</p>
                <p x-show="swipeDirection" class="text-white ios-mt-sm" x-text="`Swiped: ${swipeDirection}`"></p>
            </div>
        </div>
    </div>
    
    <!-- Loading States Section -->
    <div class="ios-card ios-mb-lg">
        <h2 class="ios-title-2 ios-mb-md">Loading States</h2>
        
        <!-- Button Loading -->
        <div class="ios-mb-lg" x-data="{ loading: false }">
            <h3 class="ios-headline ios-mb-sm">Button Loading</h3>
            <button 
                @click="loading = true; setTimeout(() => loading = false, 2000)"
                :class="{ 'loading': loading }"
                class="ios-button ios-button-primary"
                :disabled="loading"
            >
                <span x-show="!loading">Click to Load</span>
                <span x-show="loading" class="button-spinner"></span>
                <span x-show="loading" class="button-text">Loading...</span>
            </button>
        </div>
        
        <!-- Progress Bar -->
        <div class="ios-mb-lg" x-data="{ progress: 0 }">
            <h3 class="ios-headline ios-mb-sm">Progress Bar</h3>
            <div class="ios-progress">
                <div class="ios-progress-bar" :style="`width: ${progress}%`"></div>
            </div>
            <div class="ios-flex ios-gap-sm ios-mt-sm">
                <button @click="progress = Math.min(progress + 25, 100)" class="ios-button ios-button-sm">+25%</button>
                <button @click="progress = 0" class="ios-button ios-button-sm ios-button-secondary">Reset</button>
            </div>
        </div>
        
        <!-- Skeleton Loading -->
        <div class="ios-mb-lg">
            <h3 class="ios-headline ios-mb-sm">Skeleton Loading</h3>
            <div class="ios-card">
                <div class="ios-flex ios-gap-md ios-mb-md">
                    <div class="skeleton skeleton-avatar"></div>
                    <div class="flex-1">
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
                </div>
                <div class="skeleton skeleton-card"></div>
            </div>
        </div>
    </div>
    
    <!-- Page Transitions Section -->
    <div class="ios-card ios-mb-lg">
        <h2 class="ios-title-2 ios-mb-md">Page Transitions</h2>
        
        <div class="ios-mb-lg">
            <h3 class="ios-headline ios-mb-sm">Smooth Navigation</h3>
            <p class="ios-body ios-mb-sm">Click any navigation link to see smooth page transitions</p>
            <div class="ios-flex ios-gap-sm">
                <a href="{{ route('dashboard') }}" class="ios-button ios-button-secondary">Dashboard</a>
                <a href="#" data-no-transition class="ios-button ios-button-ghost">No Transition</a>
            </div>
        </div>
        
        <!-- Toast Notifications -->
        <div class="ios-mb-lg">
            <h3 class="ios-headline ios-mb-sm">Toast Notifications</h3>
            <div class="ios-flex ios-gap-sm ios-flex-wrap">
                <button onclick="iOS16Utils.showToast('Success message!', 'success')" class="ios-button ios-button-sm">Success</button>
                <button onclick="iOS16Utils.showToast('Error message!', 'error')" class="ios-button ios-button-sm">Error</button>
                <button onclick="iOS16Utils.showToast('Warning message!', 'warning')" class="ios-button ios-button-sm">Warning</button>
                <button onclick="iOS16Utils.showToast('Info message!', 'info')" class="ios-button ios-button-sm">Info</button>
            </div>
        </div>
    </div>
    
    <!-- Scroll Animations Section -->
    <div class="ios-card ios-mb-lg">
        <h2 class="ios-title-2 ios-mb-md">Scroll Animations</h2>
        
        <div class="ios-stagger-container">
            <div class="ios-card ios-mb-md ios-fade-in-scroll">
                <h3 class="ios-headline">Fade In on Scroll</h3>
                <p class="ios-body">This card fades in when scrolled into view</p>
            </div>
            <div class="ios-card ios-mb-md ios-slide-in-scroll">
                <h3 class="ios-headline">Slide In on Scroll</h3>
                <p class="ios-body">This card slides in when scrolled into view</p>
            </div>
            <div class="ios-card ios-mb-md ios-scale-in-scroll">
                <h3 class="ios-headline">Scale In on Scroll</h3>
                <p class="ios-body">This card scales in when scrolled into view</p>
            </div>
        </div>
    </div>
    
    <!-- Notifications Component -->
    <div class="ios-card ios-mb-lg" x-data="notifications()">
        <h2 class="ios-title-2 ios-mb-md">Notification System</h2>
        
        <div class="ios-flex ios-gap-sm ios-mb-md">
            <button @click="add('This is a success notification', 'success')" class="ios-button ios-button-sm">Add Success</button>
            <button @click="add('This is an error notification', 'error')" class="ios-button ios-button-sm">Add Error</button>
            <button @click="clear()" class="ios-button ios-button-sm ios-button-secondary">Clear All</button>
        </div>
        
        <div class="fixed top-20 right-4 z-50 space-y-2">
            <template x-for="notification in notifications" :key="notification.id">
                <div 
                    x-show="notification.visible"
                    x-transition
                    class="ios-card max-w-sm"
                    :class="{
                        'border-l-4 border-green-500': notification.type === 'success',
                        'border-l-4 border-red-500': notification.type === 'error',
                        'border-l-4 border-yellow-500': notification.type === 'warning',
                        'border-l-4 border-blue-500': notification.type === 'info'
                    }"
                >
                    <div class="ios-flex ios-justify-between ios-items-start">
                        <p class="ios-body" x-text="notification.message"></p>
                        <button @click="remove(notification.id)" class="ios-button-ghost ios-button-sm">×</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<style>
    .w-full { width: 100%; }
    .w-12 { width: 3rem; }
    .h-12 { height: 3rem; }
    .h-full { height: 100%; }
    .object-cover { object-fit: cover; }
    .rounded { border-radius: 0.375rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .fixed { position: fixed; }
    .right-3 { right: 0.75rem; }
    .right-4 { right: 1rem; }
    .top-3 { top: 0.75rem; }
    .top-20 { top: 5rem; }
    .z-50 { z-index: 50; }
    .space-y-2 > * + * { margin-top: 0.5rem; }
    .max-w-sm { max-width: 24rem; }
    .border-2 { border-width: 2px; }
    .border-dashed { border-style: dashed; }
    .border-gray-300 { border-color: #d1d5db; }
    .border-blue-500 { border-color: #3b82f6; }
    .border-l-4 { border-left-width: 4px; }
    .border-green-500 { border-color: #10b981; }
    .border-red-500 { border-color: #ef4444; }
    .border-yellow-500 { border-color: #f59e0b; }
    .bg-blue-50 { background-color: #eff6ff; }
    .text-gray-400 { color: #9ca3af; }
    .text-gray-500 { color: #6b7280; }
    .text-gray-600 { color: #4b5563; }
    .text-white { color: white; }
    .text-red-600 { color: #dc2626; }
    .text-sm { font-size: 0.875rem; }
    .text-xs { font-size: 0.75rem; }
    .text-center { text-align: center; }
    .cursor-pointer { cursor: pointer; }
    .hidden { display: none; }
    .flex-1 { flex: 1; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .mt-2 { margin-top: 0.5rem; }
    .p-8 { padding: 2rem; }
    .transition-colors { transition-property: color, background-color, border-color; }
</style>
@endsection
