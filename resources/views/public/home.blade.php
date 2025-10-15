@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">{{ config('school.name', 'School Management System') }}</h1>
        <p class="hero-subtitle">{{ config('school.tagline', 'Keunggulan dalam Pendidikan') }}</p>
        
        @if($announcement)
        <div class="announcement-card">
            <div class="announcement-header">
                <span class="announcement-icon">📢</span>
                <strong>Latest Announcement</strong>
            </div>
            <h3 class="announcement-title">{{ $announcement->title }}</h3>
            <p class="announcement-text">{{ Str::limit(strip_tags($announcement->excerpt ?? $announcement->content), 150) }}</p>
            <a href="{{ route('public.news.show', $announcement->slug) }}" class="announcement-btn">
                Baca Selengkapnya →
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Quick Links Section -->
<div class="container">
    <div class="quick-links">
        <a href="{{ route('public.news.index') }}" class="quick-link-card">
            <div class="quick-link-icon">📰</div>
            <h3 class="quick-link-title">News & Events</h3>
            <p class="quick-link-desc">Stay updated with latest news</p>
        </a>
        
        <a href="{{ route('public.competencies.index') }}" class="quick-link-card">
            <div class="quick-link-icon">🎓</div>
            <h3 class="quick-link-title">Competency Programs</h3>
            <p class="quick-link-desc">Jelajahi program kami</p>
        </a>
        
        <a href="{{ route('public.gallery.index') }}" class="quick-link-card">
            <div class="quick-link-icon">📸</div>
            <h3 class="quick-link-title">Gallery</h3>
            <p class="quick-link-desc">View school activities</p>
        </a>
        
        <a href="{{ route('ppdb.register') }}" class="quick-link-card quick-link-featured">
            <div class="quick-link-icon">📝</div>
            <h3 class="quick-link-title">PPDB Registration</h3>
            <p class="quick-link-desc">Register as new student</p>
        </a>
    </div>

    <!-- Latest News Section -->
    @if($latestNews->count() > 0)
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Berita Terbaru</h2>
            <a href="{{ route('public.news.index') }}" class="section-link">Lihat Semua →</a>
        </div>
        
        <div class="news-grid">
            @foreach($latestNews as $news)
            <a href="{{ route('public.news.show', $news->slug) }}" class="news-card">
                @if($news->featured_image)
                <div class="news-image">
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}">
                </div>
                @endif
                
                <div class="news-content">
                    @if($news->category)
                    <span class="news-category">{{ $news->category->name }}</span>
                    @endif
                    
                    <h3 class="news-title">{{ Str::limit($news->title, 60) }}</h3>
                    <p class="news-excerpt">{{ Str::limit(strip_tags($news->excerpt ?? $news->content), 100) }}</p>
                    
                    <div class="news-meta">
                        <span>{{ $news->published_at->format('M d, Y') }}</span>
                        @if($news->author)
                        <span>By {{ $news->author->name }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Featured Competencies Section -->
    @if($featuredCompetencies->count() > 0)
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Program Kami</h2>
            <a href="{{ route('public.competencies.index') }}" class="section-link">Lihat Semua →</a>
        </div>
        
        <div class="competency-grid">
            @foreach($featuredCompetencies as $competency)
            <a href="{{ route('public.competencies.show', $competency->slug) }}" class="competency-card">
                @if($competency->image)
                <div class="competency-image">
                    <img src="{{ Storage::url($competency->image) }}" alt="{{ $competency->name }}">
                </div>
                @endif
                
                <div class="competency-content">
                    <h3 class="competency-title">{{ $competency->name }}</h3>
                    <p class="competency-desc">{{ Str::limit(strip_tags($competency->description), 120) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Latest Gallery Section -->
    @if($latestGalleryAlbums->count() > 0)
    <section class="content-section">
        <div class="section-header">
            <h2 class="section-title">Galeri</h2>
            <a href="{{ route('public.gallery.index') }}" class="section-link">Lihat Semua →</a>
        </div>
        
        <div class="gallery-grid">
            @foreach($latestGalleryAlbums as $album)
            <a href="{{ route('public.gallery.show', $album->slug) }}" class="gallery-card">
                @if($album->cover_image)
                <div class="gallery-image">
                    <img src="{{ Storage::url($album->cover_image) }}" alt="{{ $album->name }}">
                </div>
                @elseif($album->items->first())
                <div class="gallery-image">
                    <img src="{{ Storage::url($album->items->first()->image_path) }}" alt="{{ $album->name }}">
                </div>
                @endif
                
                <div class="gallery-content">
                    <h3 class="gallery-title">{{ $album->name }}</h3>
                    @if($album->description)
                    <p class="gallery-desc">{{ Str::limit($album->description, 80) }}</p>
                    @endif
                    <p class="gallery-count">{{ $album->items->count() }} {{ Str::plural('photo', $album->items->count()) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
    padding: 60px 20px;
    text-align: center;
    color: white;
    border-radius: 0 0 32px 32px;
    margin-bottom: 30px;
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.hero-title {
    font-size: clamp(1.75rem, 5vw, 2.5rem);
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: clamp(1rem, 3vw, 1.2rem);
    opacity: 0.9;
    margin-bottom: 2rem;
}

/* Announcement Card */
.announcement-card {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    padding: 20px;
    text-align: left;
    margin-top: 30px;
    border-radius: 16px;
}

.announcement-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.announcement-icon {
    font-size: 1.5rem;
}

.announcement-title {
    margin: 10px 0;
    font-size: clamp(1.1rem, 3vw, 1.3rem);
}

.announcement-text {
    opacity: 0.9;
    margin: 10px 0;
    line-height: 1.6;
}

.announcement-btn {
    display: inline-block;
    margin-top: 10px;
    background: white;
    color: #007AFF;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.announcement-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Quick Links */
.quick-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 50px;
}

.quick-link-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.quick-link-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.quick-link-featured {
    background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
    color: white;
}

.quick-link-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.quick-link-title {
    font-size: 1.3rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.quick-link-desc {
    color: #666;
    font-size: 0.95rem;
}

.quick-link-featured .quick-link-desc {
    color: rgba(255, 255, 255, 0.9);
}

/* Content Sections */
.content-section {
    margin-bottom: 50px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 10px;
}

.section-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
}

.section-link {
    color: #007AFF;
    text-decoration: none;
    font-weight: 600;
    transition: opacity 0.2s ease;
}

.section-link:hover {
    opacity: 0.7;
}

/* News Grid */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.news-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.news-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.news-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}

.news-content {
    padding: 20px;
}

.news-category {
    display: inline-block;
    background: #007AFF;
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.news-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
    line-height: 1.4;
    font-weight: 600;
}

.news-excerpt {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
    line-height: 1.6;
}

.news-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #999;
    flex-wrap: wrap;
    gap: 10px;
}

/* Competency Grid */
.competency-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.competency-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.competency-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.competency-image {
    width: 100%;
    height: 180px;
    overflow: hidden;
}

.competency-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.competency-card:hover .competency-image img {
    transform: scale(1.05);
}

.competency-content {
    padding: 20px;
}

.competency-title {
    font-size: 1.3rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.competency-desc {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.gallery-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.gallery-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.gallery-image {
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.05);
}

.gallery-content {
    padding: 20px;
}

.gallery-title {
    font-size: 1.2rem;
    margin-bottom: 8px;
    font-weight: 600;
}

.gallery-desc {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
    line-height: 1.6;
}

.gallery-count {
    color: #007AFF;
    font-size: 0.9rem;
    font-weight: 600;
}

/* Tablet Responsive */
@media (max-width: 768px) {
    .hero-section {
        padding: 40px 16px;
        border-radius: 0 0 24px 24px;
    }
    
    .quick-links {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .quick-link-card {
        padding: 20px 16px;
    }
    
    .quick-link-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }
    
    .quick-link-title {
        font-size: 1.1rem;
    }
    
    .quick-link-desc {
        font-size: 0.85rem;
    }
    
    .news-grid,
    .competency-grid,
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }
    
    .container {
        padding: 0 16px;
    }
}

/* Mobile Responsive */
@media (max-width: 480px) {
    .hero-section {
        padding: 30px 12px;
        margin-bottom: 20px;
    }
    
    .announcement-card {
        padding: 16px;
    }
    
    .quick-links {
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 30px;
    }
    
    .quick-link-card {
        padding: 24px 16px;
    }
    
    .content-section {
        margin-bottom: 30px;
    }
    
    .section-header {
        margin-bottom: 16px;
    }
    
    .news-grid,
    .competency-grid,
    .gallery-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .news-image,
    .competency-image,
    .gallery-image {
        height: 180px;
    }
    
    .container {
        padding: 0 12px;
    }
}

/* Touch Device Optimizations */
@media (hover: none) and (pointer: coarse) {
    .quick-link-card:active,
    .news-card:active,
    .competency-card:active,
    .gallery-card:active {
        transform: scale(0.98);
    }
    
    .announcement-btn:active {
        transform: scale(0.95);
    }
}

/* Dark Mode Support (Optional) */
@media (prefers-color-scheme: dark) {
    .quick-link-card,
    .news-card,
    .competency-card,
    .gallery-card {
        background: #1c1c1e;
        color: #ffffff;
    }
    
    .news-excerpt,
    .competency-desc,
    .gallery-desc {
        color: #a0a0a0;
    }
    
    .news-meta {
        color: #8e8e93;
    }
}
</style>
@endsection
