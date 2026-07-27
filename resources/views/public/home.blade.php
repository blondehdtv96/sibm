@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section with Stats -->
<div class="hero-wrapper">
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">{{ config('school.name', 'SMK Bina Mandiri Bekasi') }}</h1>
            <p class="hero-subtitle">{{ config('school.tagline', 'Mencetak Generasi Unggul dan Berdaya Saing') }}</p>
            
            @if($announcement)
            <div class="announcement-card">
                <div class="announcement-icon">📢</div>
                <div class="announcement-content">
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ Str::limit(strip_tags($announcement->excerpt ?? $announcement->content), 120) }}</p>
                    <a href="{{ route('public.news.show', $announcement->slug) }}">Selengkapnya →</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Alumni Sukses</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Program Keahlian</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Guru Profesional</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Tingkat Kelulusan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container main-content">
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('ppdb.register') }}" class="action-card primary">
            <span class="action-icon">📝</span>
            <span class="action-text">Daftar PPDB</span>
        </a>
        <a href="{{ route('public.competencies.index') }}" class="action-card">
            <span class="action-icon">🎓</span>
            <span class="action-text">Program Keahlian</span>
        </a>
        <a href="{{ route('public.news.index') }}" class="action-card">
            <span class="action-icon">📰</span>
            <span class="action-text">Berita</span>
        </a>
        <a href="{{ route('public.gallery.index') }}" class="action-card">
            <span class="action-icon">📸</span>
            <span class="action-text">Galeri</span>
        </a>
    </div>

    <!-- Latest News -->
    @if($latestNews && $latestNews->count() > 0)
    <section class="section">
        <div class="section-header">
            <h2>Berita Terbaru</h2>
            <a href="{{ route('public.news.index') }}" class="view-all">Lihat Semua →</a>
        </div>
        <div class="card-grid">
            @foreach($latestNews as $news)
            <a href="{{ route('public.news.show', $news->slug) }}" class="card">
                @if($news->featured_image)
                <div class="card-image">
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" loading="lazy">
                    @if($news->category)
                    <span class="card-badge">{{ $news->category->name }}</span>
                    @endif
                </div>
                @endif
                <div class="card-body">
                    <h3>{{ Str::limit($news->title, 60) }}</h3>
                    <p>{{ Str::limit(strip_tags($news->excerpt ?? $news->content), 80) }}</p>
                    <div class="card-meta">
                        <span>{{ $news->published_at->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Featured Programs -->
    @if($featuredCompetencies && $featuredCompetencies->count() > 0)
    <section class="section">
        <div class="section-header">
            <h2>Program Keahlian</h2>
            <a href="{{ route('public.competencies.index') }}" class="view-all">Lihat Semua →</a>
        </div>
        <div class="card-grid">
            @foreach($featuredCompetencies->take(3) as $competency)
            <a href="{{ route('public.competencies.show', $competency->slug) }}" class="card">
                @if($competency->image)
                <div class="card-image">
                    <img src="{{ Storage::url($competency->image) }}" alt="{{ $competency->name }}" loading="lazy">
                </div>
                @endif
                <div class="card-body">
                    <h3>{{ $competency->name }}</h3>
                    <p>{{ Str::limit(strip_tags($competency->description), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Latest Gallery -->
    @if($latestGalleryAlbums && $latestGalleryAlbums->count() > 0)
    <section class="section">
        <div class="section-header">
            <h2>Galeri Kegiatan</h2>
            <a href="{{ route('public.gallery.index') }}" class="view-all">Lihat Semua →</a>
        </div>
        <div class="gallery-grid">
            @foreach($latestGalleryAlbums->take(4) as $album)
            <a href="{{ route('public.gallery.show', $album->slug) }}" class="gallery-item">
                @if($album->cover_image)
                <img src="{{ Storage::url($album->cover_image) }}" alt="{{ $album->name }}" loading="lazy">
                @elseif($album->items->first())
                <img src="{{ Storage::url($album->items->first()->image_path) }}" alt="{{ $album->name }}" loading="lazy">
                @endif
                <div class="gallery-overlay">
                    <h4>{{ $album->name }}</h4>
                    <span>{{ $album->items->count() }} Foto</span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>

<style>
* { box-sizing: border-box; }

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero & Stats */
.hero-wrapper {
    background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
    color: white;
}

.hero-section {
    padding: 50px 0 30px;
    text-align: center;
}

.hero-title {
    font-size: clamp(1.8rem, 5vw, 2.8rem);
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: clamp(1rem, 3vw, 1.2rem);
    opacity: 0.95;
    margin-bottom: 30px;
}

.announcement-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    gap: 16px;
    text-align: left;
    max-width: 700px;
    margin: 0 auto;
}

.announcement-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.announcement-content h3 {
    font-size: 1.1rem;
    margin-bottom: 8px;
}

.announcement-content p {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 10px;
    line-height: 1.5;
}

.announcement-content a {
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    transition: background 0.2s;
}

.announcement-content a:hover {
    background: rgba(255, 255, 255, 0.3);
}

.stats-section {
    padding: 30px 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: clamp(2.5rem, 6vw, 3.5rem);
    font-weight: 800;
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: clamp(0.85rem, 2vw, 1rem);
    opacity: 0.9;
}

/* Main Content */
.main-content {
    padding: 40px 20px;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
    margin-bottom: 50px;
}

.action-card {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: all 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.action-card:hover {
    transform: translateY(-2px);
    border-color: #007AFF;
    box-shadow: 0 4px 12px rgba(0, 122, 255, 0.15);
}

.action-card.primary {
    background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
    color: white;
    border-color: transparent;
}

.action-icon {
    font-size: 2rem;
}

.action-text {
    font-weight: 600;
    font-size: 0.95rem;
}

/* Sections */
.section {
    margin-bottom: 50px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.section-header h2 {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    color: #1a1a1a;
}

.view-all {
    color: #007AFF;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: opacity 0.2s;
}

.view-all:hover {
    opacity: 0.7;
}

/* Card Grid */
.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.card-image {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f5f5f5;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.card:hover .card-image img {
    transform: scale(1.05);
}

.card-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #007AFF;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.card-body {
    padding: 20px;
}

.card-body h3 {
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 10px;
    line-height: 1.4;
    color: #1a1a1a;
}

.card-body p {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 12px;
}

.card-meta {
    font-size: 0.85rem;
    color: #999;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
}

.gallery-item {
    position: relative;
    height: 200px;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
}

.gallery-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    padding: 20px 16px 16px;
    color: white;
}

.gallery-overlay h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px;
}

.gallery-overlay span {
    font-size: 0.85rem;
    opacity: 0.9;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section {
        padding: 40px 0 20px;
    }
    
    .stats-section {
        padding: 20px 0;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .main-content {
        padding: 30px 16px;
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
        margin-bottom: 40px;
    }
    
    .section {
        margin-bottom: 40px;
    }
    
    .card-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .gallery-item {
        height: 150px;
    }
}

@media (max-width: 480px) {
    .announcement-card {
        flex-direction: column;
        text-align: center;
        padding: 16px;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
