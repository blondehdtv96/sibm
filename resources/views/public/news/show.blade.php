@extends('layouts.public-tailwind')

@section('title', $news->title . ' - ' . config('school.name'))

@section('content')
<!-- Article Header -->
<article class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-600 transition-colors">Beranda</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('public.news.index') }}" class="text-gray-500 hover:text-orange-600 transition-colors">Berita</a>
            @if($news->category)
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" class="text-gray-500 hover:text-orange-600 transition-colors">
                    {{ $news->category->name }}
                </a>
            @endif
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">{{ Str::limit($news->title, 40) }}</span>
        </nav>

        <!-- Article Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <!-- Featured Image -->
                    @if($news->featured_image)
                        <div class="relative h-96 overflow-hidden">
                            <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="p-8 md:p-12">
                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                            @if($news->category)
                                <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" 
                                   class="px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold hover:bg-orange-200 transition-colors">
                                    {{ $news->category->name }}
                                </a>
                            @endif
                            <span class="flex items-center gap-2 text-gray-600 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $news->published_at->format('d F Y') }}
                            </span>
                            @if($news->author)
                                <span class="flex items-center gap-2 text-gray-600 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $news->author->name }}
                                </span>
                            @endif
                        </div>

                        <!-- Article Title -->
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8 leading-tight">
                            {{ $news->title }}
                        </h1>

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed article-content-html">
                            {!! $news->content !!}
                        </div>

                        <!-- Gallery Section -->
                        @if($news->images && $news->images->count() > 0)
                            <div class="mt-12">
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Galeri Foto</h2>
                                <div class="swiper gallery-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($news->images as $image)
                                        <div class="swiper-slide">
                                            <a href="{{ asset('storage/' . $image->image_path) }}" 
                                               class="group relative overflow-hidden rounded-2xl bg-gray-100 h-64 md:h-96 flex items-center justify-center block"
                                               data-lightbox="gallery"
                                               data-title="{{ $image->caption }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     alt="{{ $image->caption }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                
                                                <!-- Overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                
                                                <!-- Info -->
                                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white translate-y-8 group-hover:translate-y-0 transition-transform duration-300">
                                                    @if($image->caption)
                                                        <p class="text-sm font-semibold">{{ $image->caption }}</p>
                                                    @else
                                                        <p class="text-sm font-semibold">Klik untuk melihat lebih besar</p>
                                                    @endif
                                                </div>
                                                
                                                <!-- Icon -->
                                                <svg class="absolute top-4 right-4 w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 13H7"/>
                                                </svg>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($news->images->count() > 1)
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Article Footer -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <a href="{{ route('public.news.index') }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-6">
                @if($relatedNews->count() > 0)
                    <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            Artikel Terkait
                        </h3>
                        <div class="space-y-4">
                            @foreach($relatedNews as $related)
                                <a href="{{ route('public.news.show', $related) }}" 
                                   class="group flex gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                             alt="{{ $related->title }}"
                                             class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                            {{ $related->title }}
                                        </h4>
                                        <span class="text-xs text-gray-500">
                                            {{ $related->published_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($news->category)
                    <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Kategori
                        </h3>
                        <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" 
                           class="group flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl hover:from-orange-100 hover:to-red-100 transition-all">
                            <span class="font-semibold text-orange-700">{{ $news->category->name }}</span>
                            <svg class="w-5 h-5 text-orange-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if($news->category->description)
                            <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                                {{ $news->category->description }}
                            </p>
                        @endif
                    </div>
                @endif
            </aside>
        </div>
    </div>
</article>

@push('styles')
<style>
    /* Article Content HTML Styling */
    .article-content-html {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #374151;
    }

    .article-content-html p {
        margin-bottom: 1.5rem;
    }

    .article-content-html h1,
    .article-content-html h2,
    .article-content-html h3,
    .article-content-html h4,
    .article-content-html h5,
    .article-content-html h6 {
        font-weight: 700;
        color: #1f2937;
        margin-top: 2rem;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .article-content-html h1 { font-size: 2.25rem; }
    .article-content-html h2 { font-size: 1.875rem; }
    .article-content-html h3 { font-size: 1.5rem; }
    .article-content-html h4 { font-size: 1.25rem; }

    .article-content-html ul,
    .article-content-html ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .article-content-html li {
        margin-bottom: 0.5rem;
    }

    .article-content-html a {
        color: #ea580c;
        text-decoration: underline;
        transition: color 0.2s;
    }

    .article-content-html a:hover {
        color: #dc2626;
    }

    .article-content-html blockquote {
        border-left: 4px solid #ea580c;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6b7280;
    }

    .article-content-html code {
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
        font-family: 'Courier New', monospace;
    }

    .article-content-html pre {
        background: #1f2937;
        color: #f3f4f6;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin-bottom: 1.5rem;
    }

    .article-content-html pre code {
        background: transparent;
        padding: 0;
        color: inherit;
    }

    /* CKEditor Image Styling */
    .article-content-html figure.image {
        margin: 2rem 0;
        text-align: center;
    }

    .article-content-html figure.image img {
        max-width: 100% !important;
        width: auto !important;
        height: auto !important;
        display: block;
        margin: 0 auto;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Override any inline styles from CKEditor */
    .article-content-html img {
        max-width: 100% !important;
        height: auto !important;
        width: auto !important;
    }

    .article-content-html figure.image img:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.15), 0 10px 15px -6px rgba(0, 0, 0, 0.1);
    }

    .article-content-html figure.image figcaption {
        margin-top: 0.75rem;
        font-size: 0.875rem;
        color: #6b7280;
        font-style: italic;
    }

    /* Image alignment classes from CKEditor */
    .article-content-html figure.image.image-style-side {
        float: right;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
        max-width: 50%;
    }

    .article-content-html figure.image.image-style-align-left {
        float: left;
        margin-right: 1.5rem;
        margin-bottom: 1rem;
        max-width: 50%;
    }

    .article-content-html figure.image.image-style-align-center {
        margin-left: auto;
        margin-right: auto;
    }

    .article-content-html figure.image.image-style-align-right {
        float: right;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
        max-width: 50%;
    }

    /* Clear floats */
    .article-content-html::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive images */
    @media (max-width: 768px) {
        .article-content-html figure.image.image-style-side,
        .article-content-html figure.image.image-style-align-left,
        .article-content-html figure.image.image-style-align-right {
            float: none;
            margin-left: 0;
            margin-right: 0;
            max-width: 100%;
        }
    }

    /* Table Styling */
    .article-content-html table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        overflow-x: auto;
        display: block;
    }

    .article-content-html table thead {
        background: #f3f4f6;
    }

    .article-content-html table th,
    .article-content-html table td {
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        text-align: left;
    }

    .article-content-html table th {
        font-weight: 600;
        color: #1f2937;
    }

    .article-content-html table tbody tr:hover {
        background: #f9fafb;
    }

    .article-container {
        padding: 2rem 0 4rem;
    }

    .article-wrapper {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
    }

    @media (max-width: 1024px) {
        .article-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .article-date,
    .article-author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .article-date .icon,
    .article-author .icon {
        width: 1rem;
        height: 1rem;
    }

    .article-title {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 2rem;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .article-title {
            font-size: 2rem;
        }
    }

    .article-image {
        margin-bottom: 2rem;
        border-radius: 12px;
        overflow: hidden;
    }

    .article-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .article-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
        margin-bottom: 2rem;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-footer {
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .related-news-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .related-news-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .related-news-item:hover {
        background: rgba(0, 0, 0, 0.05);
    }

    .related-news-image,
    .related-news-image-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .related-news-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.05);
        color: var(--text-secondary);
    }

    .related-news-image-placeholder svg {
        width: 2rem;
        height: 2rem;
    }

    .related-news-content {
        flex: 1;
        min-width: 0;
    }

    .related-news-title {
        font-size: 0.875rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-news-date {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: rgba(0, 122, 255, 0.1);
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
    }

    .category-link:hover {
        background: rgba(0, 122, 255, 0.2);
        transform: translateX(4px);
    }

    .category-name {
        font-weight: 600;
        color: var(--primary-color);
    }

    .category-icon {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--primary-color);
    }

    .category-description {
        font-size: 0.875rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }

    /* Gallery Slider Styles */
    .gallery-slider {
        width: 100% !important;
        overflow: hidden !important;
        border-radius: 1rem;
    }

    .gallery-slider .swiper-wrapper {
        width: 100% !important;
    }

    .gallery-slider .swiper-slide {
        width: 100% !important;
        height: auto !important;
    }

    .gallery-slider .swiper-button-next,
    .gallery-slider .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.4);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .gallery-slider .swiper-button-next:hover,
    .gallery-slider .swiper-button-prev:hover {
        background: rgba(0, 0, 0, 0.7);
        transform: scale(1.1);
    }

    .gallery-slider .swiper-button-next::after,
    .gallery-slider .swiper-button-prev::after {
        font-size: 20px;
    }

    .gallery-slider .swiper-pagination-bullet {
        background: white;
        opacity: 0.5;
    }

    .gallery-slider .swiper-pagination-bullet-active {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fix images in article content
    const articleContent = document.querySelector('.article-content-html');
    if (articleContent) {
        const images = articleContent.querySelectorAll('img');
        images.forEach(img => {
            // Remove inline width/height attributes that might cause issues
            img.removeAttribute('width');
            img.removeAttribute('height');
            
            // Handle image load errors
            img.addEventListener('error', function() {
                console.error('Failed to load image:', this.src);
                this.style.display = 'none';
                
                // Show error message
                const errorMsg = document.createElement('div');
                errorMsg.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4';
                errorMsg.innerHTML = '<strong>Error:</strong> Gambar gagal dimuat.';
                this.parentElement.appendChild(errorMsg);
            });
            
            // Log successful loads for debugging
            img.addEventListener('load', function() {
                console.log('Image loaded successfully:', this.src);
            });
        });
    }
    
    // Gallery Slider
    if (document.querySelector('.gallery-slider')) {
        new Swiper('.gallery-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.gallery-slider .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.gallery-slider .swiper-button-next',
                prevEl: '.gallery-slider .swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true,
            },
            speed: 1000,
            slidesPerView: 1,
            grabCursor: true,
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            }
        });
    }
});
</script>
@endpush
@endsection
