@extends('layouts.public')

@section('title', $news->title)

@section('content')
<!-- Article Header -->
<article class="article-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-6">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('public.news.index') }}">Berita</a>
            @if($news->category)
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}">
                    {{ $news->category->name }}
                </a>
            @endif
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ Str::limit($news->title, 30) }}</span>
        </nav>

        <!-- Article Content -->
        <div class="article-wrapper">
            <div class="article-main">
                <div class="ios-card">
                    <!-- Article Meta -->
                    <div class="article-meta">
                        @if($news->category)
                            <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" 
                               class="badge badge-primary">
                                {{ $news->category->name }}
                            </a>
                        @endif
                        <span class="article-date">
                            <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $news->published_at->format('F d, Y') }}
                        </span>
                        @if($news->author)
                            <span class="article-author">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $news->author->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Article Title -->
                    <h1 class="article-title">{{ $news->title }}</h1>

                    <!-- Featured Image -->
                    @if($news->featured_image)
                        <div class="article-image">
                            <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                 alt="{{ $news->title }}">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <!-- Article Footer -->
                    <div class="article-footer">
                        <a href="{{ route('public.news.index') }}" class="btn btn-secondary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Berita
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="article-sidebar">
                @if($relatedNews->count() > 0)
                    <div class="ios-card">
                        <h3 class="sidebar-title">Artikel Terkait</h3>
                        <div class="related-news-list">
                            @foreach($relatedNews as $related)
                                <a href="{{ route('public.news.show', $related) }}" class="related-news-item">
                                    @if($related->featured_image)
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" 
                                             alt="{{ $related->title }}"
                                             class="related-news-image">
                                    @else
                                        <div class="related-news-image-placeholder">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="related-news-content">
                                        <h4 class="related-news-title">{{ $related->title }}</h4>
                                        <span class="related-news-date">{{ $related->published_at->format('M d, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($news->category)
                    <div class="ios-card mt-6">
                        <h3 class="sidebar-title">Kategori</h3>
                        <a href="{{ route('public.news.index', ['category' => $news->category->slug]) }}" 
                           class="category-link">
                            <span class="category-name">{{ $news->category->name }}</span>
                            <svg class="category-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @if($news->category->description)
                            <p class="category-description">{{ $news->category->description }}</p>
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
