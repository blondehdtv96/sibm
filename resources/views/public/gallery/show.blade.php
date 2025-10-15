@extends('layouts.public')

@section('title', $galleryAlbum->name . ' - Gallery')

@section('content')
<div class="album-header">
    <div class="container">
        <a href="{{ route('public.gallery.index') }}" class="back-link">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Galeri
        </a>
        <h1 class="album-title">{{ $galleryAlbum->name }}</h1>
        @if($galleryAlbum->description)
            <p class="album-description">{{ $galleryAlbum->description }}</p>
        @endif
        <div class="album-meta">
            <span class="meta-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 16L8.586 11.414C9.367 10.633 10.633 10.633 11.414 11.414L16 16M14 14L15.586 12.414C16.367 11.633 17.633 11.633 18.414 12.414L20 14M14 8H14.01M6 20H18C19.105 20 20 19.105 20 18V6C20 4.895 19.105 4 18 4H6C4.895 4 4 4.895 4 6V18C4 19.105 4.895 20 6 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ $galleryAlbum->items->count() }} {{ $galleryAlbum->items->count() == 1 ? 'foto' : 'foto' }}
            </span>
        </div>
    </div>
</div>

<div class="container">
    @if($galleryAlbum->items->count() > 0)
        <div class="gallery-grid" id="galleryGrid">
            @foreach($galleryAlbum->items as $index => $item)
                <div class="gallery-item" data-index="{{ $index }}" onclick="openLightbox({{ $index }})">
                    <img src="{{ $item->thumbnail_url ?? $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                    @if($item->title)
                        <div class="item-overlay">
                            <p class="item-title">{{ $item->title }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 16L8.586 11.414C9.367 10.633 10.633 10.633 11.414 11.414L16 16M14 14L15.586 12.414C16.367 11.633 17.633 11.633 18.414 12.414L20 14M14 8H14.01M6 20H18C19.105 20 20 19.105 20 18V6C20 4.895 19.105 4 18 4H6C4.895 4 4 4.895 4 6V18C4 19.105 4.895 20 6 20Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h2>Belum ada foto</h2>
            <p>Album ini masih kosong</p>
        </div>
    @endif
</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" style="display: none;">
    <div class="lightbox-backdrop" onclick="closeLightbox()"></div>
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        
        <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        
        <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        
        <div class="lightbox-image-container">
            <img id="lightboxImage" src="" alt="">
            <div id="lightboxTitle" class="lightbox-title"></div>
        </div>
        
        <div class="lightbox-counter">
            <span id="lightboxCounter"></span>
        </div>
    </div>
</div>

@push('styles')
<style>
.album-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 0 60px;
    margin-bottom: 40px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 24px;
    transition: all 0.3s ease;
}

.back-link:hover {
    color: white;
    transform: translateX(-4px);
}

.album-title {
    color: white;
    font-size: 42px;
    font-weight: 700;
    margin: 0 0 12px 0;
}

.album-description {
    color: rgba(255, 255, 255, 0.9);
    font-size: 18px;
    line-height: 1.6;
    margin: 0 0 20px 0;
    max-width: 800px;
}

.album-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    font-weight: 500;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 60px;
}

.gallery-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    background: #f5f5f7;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-item:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.item-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    padding: 40px 16px 16px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .item-overlay {
    opacity: 1;
}

.item-title {
    color: white;
    font-size: 14px;
    font-weight: 500;
    margin: 0;
}

/* Lightbox Styles */
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.lightbox-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(20px);
}

.lightbox-content {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    width: 48px;
    height: 48px;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.lightbox-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    width: 56px;
    height: 56px;
    border-radius: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.lightbox-nav:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-50%) scale(1.1);
}

.lightbox-prev {
    left: 20px;
}

.lightbox-next {
    right: 20px;
}

.lightbox-image-container {
    max-width: 90%;
    max-height: 90%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

#lightboxImage {
    max-width: 100%;
    max-height: calc(90vh - 100px);
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.lightbox-title {
    color: white;
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    max-width: 600px;
}

.lightbox-counter {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state svg {
    color: #d1d1d6;
    margin-bottom: 24px;
}

.empty-state h2 {
    font-size: 28px;
    font-weight: 600;
    color: #1d1d1f;
    margin: 0 0 12px 0;
}

.empty-state p {
    font-size: 17px;
    color: #86868b;
    margin: 0;
}

@media (max-width: 768px) {
    .album-title {
        font-size: 32px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
    }
    
    .lightbox-nav {
        width: 44px;
        height: 44px;
    }
    
    .lightbox-prev {
        left: 10px;
    }
    
    .lightbox-next {
        right: 10px;
    }
}
</style>
@endpush

@push('scripts')
<script>
const galleryItems = @json($galleryAlbum->items->map(function($item) {
    return [
        'url' => $item->image_url,
        'title' => $item->title,
    ];
}));

let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightbox();
    document.getElementById('lightbox').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}

function navigateLightbox(direction) {
    currentIndex += direction;
    if (currentIndex < 0) currentIndex = galleryItems.length - 1;
    if (currentIndex >= galleryItems.length) currentIndex = 0;
    updateLightbox();
}

function updateLightbox() {
    const item = galleryItems[currentIndex];
    document.getElementById('lightboxImage').src = item.url;
    document.getElementById('lightboxTitle').textContent = item.title || '';
    document.getElementById('lightboxCounter').textContent = `${currentIndex + 1} / ${galleryItems.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (lightbox.style.display === 'block') {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});

// Touch swipe support
let touchStartX = 0;
let touchEndX = 0;

document.getElementById('lightbox').addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

document.getElementById('lightbox').addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    if (touchEndX < touchStartX - 50) navigateLightbox(1);
    if (touchEndX > touchStartX + 50) navigateLightbox(-1);
}
</script>
@endpush
@endsection
