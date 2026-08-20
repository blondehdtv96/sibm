@extends('layouts.public-tailwind')

@section('title', $galleryAlbum->name . ' - Galeri - ' . config('school.name'))

@section('content')
<!-- Album Header -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 pt-32 pb-16">
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="album-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#album-grid)" />
        </svg>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('public.gallery.index') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white transition-colors mb-6 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Galeri
        </a>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4 leading-tight tracking-tight">
            {{ $galleryAlbum->name }}
        </h1>

        @if($galleryAlbum->description)
            <p class="text-lg md:text-xl text-white/90 max-w-3xl leading-relaxed mb-6">
                {{ $galleryAlbum->description }}
            </p>
        @endif

        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-lg text-white text-sm font-semibold rounded-full border border-white/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $galleryAlbum->items->count() }} {{ Str::plural('foto', $galleryAlbum->items->count()) }}
        </div>
    </div>
</section>

<!-- Album Content -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white min-h-[40vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($galleryAlbum->items->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6" id="galleryGrid">
                @foreach($galleryAlbum->items as $index => $item)
                    <div class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 shadow-md hover:shadow-xl cursor-pointer transition-all duration-300"
                         onclick="openLightbox({{ $index }})">
                        <img src="{{ $item->thumbnail_url }}"
                             alt="{{ $item->title ?? $galleryAlbum->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <a href="{{ $item->image_url }}"
                           download="{{ $item->title ? Str::slug($item->title) : 'foto-' . $galleryAlbum->slug . '-' . ($index + 1) }}.jpg"
                           onclick="event.stopPropagation()"
                           title="Unduh foto"
                           class="absolute top-2 right-2 md:top-3 md:right-3 w-9 h-9 flex items-center justify-center bg-white/20 backdrop-blur-lg border border-white/30 rounded-full text-white opacity-0 group-hover:opacity-100 hover:bg-white/30 transition-all duration-300 z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>

                        @if($item->title)
                            <div class="absolute bottom-0 left-0 right-0 p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-sm font-medium line-clamp-2">{{ $item->title }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Foto</h3>
                    <p class="text-gray-600 leading-relaxed">Album ini masih kosong. Silakan kembali lagi nanti.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Preview Modal (contained, not full-screen) -->
<div id="lightbox" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70" onclick="closeLightbox()"></div>

    <div class="relative w-full h-full flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl max-h-[85vh] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col">
            <!-- Image -->
            <div class="relative bg-gray-900 flex items-center justify-center">
                <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[55vh] w-auto mx-auto object-contain" loading="lazy">

                <button onclick="closeLightbox()" class="absolute top-3 right-3 w-9 h-9 flex items-center justify-center bg-black/40 hover:bg-black/60 rounded-full text-white transition-all" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <button onclick="navigateLightbox(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center bg-black/40 hover:bg-black/60 rounded-full text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18L9 12L15 6"/>
                    </svg>
                </button>

                <button onclick="navigateLightbox(1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center bg-black/40 hover:bg-black/60 rounded-full text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18L15 12L9 6"/>
                    </svg>
                </button>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between gap-4 p-4 border-t border-gray-100">
                <div class="min-w-0">
                    <p id="lightboxTitle" class="text-gray-900 font-medium truncate"></p>
                    <p id="lightboxCounter" class="text-gray-500 text-sm"></p>
                </div>
                <a id="lightboxDownload" href="" download class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl font-semibold text-sm hover:shadow-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh
                </a>
            </div>
        </div>
    </div>
</div>

@php
    $galleryItemsForJs = $galleryAlbum->items->values()->map(function ($item, $index) use ($galleryAlbum) {
        $filename = $item->title ? Str::slug($item->title) : 'foto-' . $galleryAlbum->slug . '-' . ($index + 1);

        return [
            'url' => $item->image_url,
            'title' => $item->title,
            'filename' => $filename . '.jpg',
        ];
    });
@endphp

@push('scripts')
<script>
const galleryItems = @json($galleryItemsForJs);

let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightbox();
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
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

    const downloadLink = document.getElementById('lightboxDownload');
    downloadLink.href = item.url;
    downloadLink.setAttribute('download', item.filename);
}

document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('hidden')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});

let touchStartX = 0;
let touchEndX = 0;

document.getElementById('lightbox').addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

document.getElementById('lightbox').addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    if (touchEndX < touchStartX - 50) navigateLightbox(1);
    if (touchEndX > touchStartX + 50) navigateLightbox(-1);
});
</script>
@endpush
@endsection
