@extends('layouts.public')

@section('title', $query ? "Hasil Pencarian untuk '{$query}'" : 'Pencarian')

@section('content')
<!-- Breadcrumb -->
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <nav style="margin-bottom: 20px;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 8px; font-size: 0.9rem; color: #666;">
            <li><a href="{{ route('home') }}" style="color: #007AFF; text-decoration: none;">Beranda</a></li>
            <li>/</li>
            <li>Pencarian</li>
        </ol>
    </nav>

    <!-- Search Header -->
    <div class="ios-card" style="padding: 40px; margin-bottom: 30px; text-align: center;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 20px; color: #333;">
            @if($query)
                Hasil Pencarian
            @else
                Cari di Website Kami
            @endif
        </h1>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('search') }}" style="max-width: 600px; margin: 0 auto;">
            <div style="position: relative;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $query }}"
                    placeholder="Cari berita, program, halaman..." 
                    required
                    style="width: 100%; padding: 15px 50px 15px 20px; border: 2px solid #ddd; border-radius: 12px; font-size: 1rem; transition: border-color 0.3s ease;"
                    onfocus="this.style.borderColor='#007AFF'"
                    onblur="this.style.borderColor='#ddd'"
                >
                <button 
                    type="submit" 
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: #007AFF; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: background 0.3s ease;"
                    onmouseover="this.style.background='#0051D5'"
                    onmouseout="this.style.background='#007AFF'"
                >
                    Cari
                </button>
            </div>
        </form>

        @if($query)
        <p style="margin-top: 20px; color: #666; font-size: 1rem;">
            Found <strong>{{ $totalResults }}</strong> {{ Str::plural('result', $totalResults) }} for "<strong>{{ $query }}</strong>"
        </p>
        @endif
    </div>

    @if($query && $totalResults > 0)
        <!-- News Results -->
        @if($news->count() > 0)
        <section style="margin-bottom: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #333;">📰 News & Announcements</h2>
                <a href="{{ route('public.news.index', ['search' => $query]) }}" style="color: #007AFF; text-decoration: none; font-weight: 600;">Lihat Semua →</a>
            </div>
            
            <div style="display: grid; gap: 20px;">
                @foreach($news as $article)
                <a href="{{ route('public.news.show', $article->slug) }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 20px; display: flex; gap: 20px; transition: transform 0.3s ease;">
                    @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 10px; flex-shrink: 0;">
                    @endif
                    
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            @if($article->category)
                            <span style="background: #007AFF; color: white; padding: 4px 10px; border-radius: 8px; font-size: 0.75rem; font-weight: 600;">
                                {{ $article->category->name }}
                            </span>
                            @endif
                            <span style="color: #999; font-size: 0.85rem;">{{ $article->published_at->format('M d, Y') }}</span>
                        </div>
                        
                        <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 8px; color: #333;">{{ $article->title }}</h3>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">{{ Str::limit(strip_tags($article->excerpt ?? $article->content), 150) }}</p>
                        
                        @if($article->author)
                        <p style="color: #999; font-size: 0.85rem; margin-top: 8px;">By {{ $article->author->name }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Competency Results -->
        @if($competencies->count() > 0)
        <section style="margin-bottom: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #333;">🎓 Competency Programs</h2>
                <a href="{{ route('public.competencies.index', ['search' => $query]) }}" style="color: #007AFF; text-decoration: none; font-weight: 600;">Lihat Semua →</a>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($competencies as $competency)
                <a href="{{ route('public.competencies.show', $competency->slug) }}" class="ios-card" style="text-decoration: none; color: inherit; overflow: hidden; transition: transform 0.3s ease;">
                    @if($competency->image)
                    <img src="{{ Storage::url($competency->image) }}" alt="{{ $competency->name }}" style="width: 100%; height: 180px; object-fit: cover; border-radius: 12px 12px 0 0; margin: -20px -20px 15px -20px;">
                    @endif
                    
                    <div style="padding: {{ $competency->image ? '0 20px 20px 20px' : '20px' }};">
                        <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px; color: #333;">{{ $competency->name }}</h3>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">{{ Str::limit(strip_tags($competency->description), 120) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Page Results -->
        @if($pages->count() > 0)
        <section style="margin-bottom: 40px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #333;">📄 Pages</h2>
            </div>
            
            <div style="display: grid; gap: 15px;">
                @foreach($pages as $page)
                <a href="{{ route('public.pages.show', $page->slug) }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 20px; transition: transform 0.3s ease;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: #333;">{{ $page->title }}</h3>
                    <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">{{ Str::limit(strip_tags($page->content), 200) }}</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    @elseif($query && $totalResults === 0)
        <!-- No Results -->
        <div class="ios-card" style="padding: 60px 40px; text-align: center;">
            <div style="font-size: 4rem; margin-bottom: 20px;">🔍</div>
            <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 15px; color: #333;">Tidak Ada Hasil</h2>
            <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px; max-width: 500px; margin-left: auto; margin-right: auto;">
                Kami tidak dapat menemukan hasil untuk "<strong>{{ $query }}</strong>". Coba cari dengan kata kunci yang berbeda.
            </p>
            
            <div style="margin-top: 30px;">
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; color: #333;">Tips Pencarian:</h3>
                <ul style="list-style: none; padding: 0; color: #666; text-align: left; max-width: 400px; margin: 0 auto;">
                    <li style="padding: 8px 0;">✓ Periksa ejaan Anda</li>
                    <li style="padding: 8px 0;">✓ Gunakan kata kunci yang lebih umum</li>
                    <li style="padding: 8px 0;">✓ Coba kata kunci yang berbeda</li>
                    <li style="padding: 8px 0;">✓ Gunakan lebih sedikit kata kunci</li>
                </ul>
            </div>
        </div>
    @else
        <!-- Search Suggestions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <a href="{{ route('public.news.index') }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 30px; text-align: center; transition: transform 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 15px;">📰</div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px; color: #333;">Jelajahi Berita</h3>
                <p style="color: #666; font-size: 0.9rem;">Lihat berita dan pengumuman terbaru kami</p>
            </a>
            
            <a href="{{ route('public.competencies.index') }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 30px; text-align: center; transition: transform 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 15px;">🎓</div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px; color: #333;">View Programs</h3>
                <p style="color: #666; font-size: 0.9rem;">Temukan program keahlian kami</p>
            </a>
            
            <a href="{{ route('public.gallery.index') }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 30px; text-align: center; transition: transform 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 15px;">📸</div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px; color: #333;">Jelajahi Galeri</h3>
                <p style="color: #666; font-size: 0.9rem;">Lihat foto-foto kegiatan sekolah</p>
            </a>
            
            <a href="{{ route('info.contact') }}" class="ios-card" style="text-decoration: none; color: inherit; padding: 30px; text-align: center; transition: transform 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 15px;">📞</div>
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 10px; color: #333;">Contact Us</h3>
                <p style="color: #666; font-size: 0.9rem;">Get in touch with our team</p>
            </a>
        </div>
    @endif
</div>

<style>
.ios-card:hover {
    transform: translateY(-4px);
}

@media (max-width: 768px) {
    .ios-card h1 {
        font-size: 1.5rem !important;
    }
    
    .ios-card h2 {
        font-size: 1.3rem !important;
    }
    
    .ios-card[style*="display: flex"] {
        flex-direction: column !important;
    }
    
    .ios-card[style*="display: flex"] img {
        width: 100% !important;
        height: 150px !important;
    }
}
</style>
@endsection
