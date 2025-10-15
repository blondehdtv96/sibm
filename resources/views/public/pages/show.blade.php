@extends('layouts.public-tailwind')

@section('title', $page->title . ' - ' . config('school.name', 'SMK Negeri 4 Bogor'))
@section('description', $page->meta_description ?? Str::limit(strip_tags($page->content), 160))

@if($page->banner_image)
@section('og_image', asset('storage/' . $page->banner_image))
@endif

@section('content')
<!-- Hero Section -->
@if($page->banner_image)
<section class="relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img 
            src="{{ asset('storage/' . $page->banner_image) }}" 
            alt="{{ $page->title }}"
            class="w-full h-full object-cover opacity-30"
        >
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-blue-800/80 to-indigo-900/80"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 pt-32 pb-20">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                {{ $page->title }}
            </h1>
            @if($page->meta_description)
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                {{ $page->meta_description }}
            </p>
            @endif
        </div>
    </div>
</section>
@else
<!-- Simple Header -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
            {{ $page->title }}
        </h1>
        @if($page->meta_description)
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            {{ $page->meta_description }}
        </p>
        @endif
    </div>
</section>
@endif

<!-- Page Content -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Content -->
            <article class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="prose prose-lg max-w-none">
                        {!! $page->content !!}
                    </div>
                </div>

                <!-- Page Footer -->
                <footer class="bg-gray-50 px-8 md:px-12 py-6 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <!-- Meta Info -->
                        <div class="flex items-center gap-2 text-gray-500 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}</span>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-3" x-data="shareButtons()">
                            <span class="text-gray-500 text-sm font-medium">Bagikan:</span>
                            <button @click="share('facebook')" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" title="Bagikan di Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button @click="share('twitter')" class="p-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors" title="Bagikan di Twitter">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </button>
                            <button @click="share('linkedin')" class="p-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors" title="Bagikan di LinkedIn">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </button>
                            <button @click="copyLink()" class="p-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors" title="Salin Tautan">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="copied" x-transition class="absolute top-full mt-2 right-0 bg-green-600 text-white px-3 py-1 rounded-lg text-sm whitespace-nowrap">
                                Tautan disalin!
                            </div>
                        </div>
                    </div>
                </footer>
            </article>
        </div>
    </div>
</section>

@push('styles')
<style>
.prose {
    max-width: none;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #1f2937;
    font-weight: 600;
}

.prose p {
    color: #374151;
    line-height: 1.7;
}

.prose a {
    color: #2563eb;
    text-decoration: none;
}

.prose a:hover {
    text-decoration: underline;
}

.prose img {
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.prose blockquote {
    border-left: 4px solid #3b82f6;
    background: #f8fafc;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    font-style: italic;
}

.prose code {
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.875em;
}

.prose pre {
    background: #1e293b;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.75rem;
    overflow-x: auto;
}

.prose pre code {
    background: none;
    color: inherit;
    padding: 0;
}

.prose table {
    border-collapse: collapse;
    width: 100%;
}

.prose th, .prose td {
    border: 1px solid #e5e7eb;
    padding: 0.75rem;
    text-align: left;
}

.prose th {
    background: #f9fafb;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// Share Buttons
function shareButtons() {
    return {
        copied: false,
        
        share(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            let shareUrl = '';
            
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        },
        
        async copyLink() {
            try {
                await navigator.clipboard.writeText(window.location.href);
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (err) {
                console.error('Failed to copy link:', err);
            }
        }
    };
}
</script>
@endpush
@endsection
