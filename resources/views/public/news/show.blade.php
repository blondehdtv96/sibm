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
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($news->content)) !!}
                        </div>

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
</style>
@endpush
@endsection
