@extends('layouts.public')

@section('title', $competency->name)

@section('content')
<!-- Competency Header -->
<article class="competency-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-6">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('public.competencies.index') }}">Program Keahlian</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ Str::limit($competency->name, 30) }}</span>
        </nav>

        <!-- Competency Content -->
        <div class="competency-wrapper">
            <div class="competency-main">
                <div class="ios-card">
                    <!-- Competency Title -->
                    <h1 class="competency-title">{{ $competency->name }}</h1>

                    <!-- Featured Image -->
                    @if($competency->image)
                        <div class="competency-image">
                            <img src="{{ asset('storage/' . $competency->image) }}" 
                                 alt="{{ $competency->name }}">
                        </div>
                    @endif

                    <!-- Competency Description -->
                    <div class="competency-content">
                        {!! nl2br(e($competency->description)) !!}
                    </div>

                    <!-- Competency Footer -->
                    <div class="competency-footer">
                        <a href="{{ route('public.competencies.index') }}" class="btn btn-secondary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Program
                        </a>
                        <a href="{{ route('ppdb.register') }}" class="btn btn-primary">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Register Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="competency-sidebar">
                @if($otherCompetencies->count() > 0)
                    <div class="ios-card">
                        <h3 class="sidebar-title">Program Lainnya</h3>
                        <div class="other-competencies-list">
                            @foreach($otherCompetencies as $other)
                                <a href="{{ route('public.competencies.show', $other) }}" class="other-competency-item">
                                    @if($other->image)
                                        <img src="{{ asset('storage/' . $other->image) }}" 
                                             alt="{{ $other->name }}"
                                             class="other-competency-image">
                                    @else
                                        <div class="other-competency-image-placeholder">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="other-competency-content">
                                        <h4 class="other-competency-title">{{ $other->name }}</h4>
                                        <p class="other-competency-excerpt">
                                            {{ Str::limit(strip_tags($other->description), 60) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('public.competencies.index') }}" class="view-all-link">
                            Lihat semua program
                            <svg class="link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif

                <div class="ios-card mt-6">
                    <h3 class="sidebar-title">Interested?</h3>
                    <p class="sidebar-text">
                        Bergabunglah dengan sekolah kami dan jelajahi program keahlian ini. Daftar sekarang untuk memulai perjalanan pendidikan Anda.
                    </p>
                    <a href="{{ route('ppdb.register') }}" class="btn btn-primary w-full">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Register Now
                    </a>
                </div>

                <div class="ios-card mt-6">
                    <h3 class="sidebar-title">Need More Info?</h3>
                    <p class="sidebar-text">
                        Have questions about this program? Contact our admissions office for more information.
                    </p>
                    <a href="{{ route('public.pages.show', 'contact') }}" class="btn btn-secondary w-full">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Us
                    </a>
                </div>
            </aside>
        </div>
    </div>
</article>

@push('styles')
<style>
    .competency-container {
        padding: 2rem 0 4rem;
    }

    .competency-wrapper {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
    }

    @media (max-width: 1024px) {
        .competency-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .competency-title {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 2rem;
        color: var(--text-primary);
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @media (max-width: 768px) {
        .competency-title {
            font-size: 2rem;
        }
    }

    .competency-image {
        margin-bottom: 2rem;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .competency-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .competency-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
        margin-bottom: 2rem;
    }

    .competency-content p {
        margin-bottom: 1.5rem;
    }

    .competency-footer {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
    }

    @media (max-width: 640px) {
        .competency-footer {
            flex-direction: column;
        }

        .competency-footer .btn {
            width: 100%;
        }
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .sidebar-text {
        font-size: 0.875rem;
        line-height: 1.6;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .other-competencies-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .other-competency-item {
        display: flex;
        gap: 1rem;
        padding: 0.75rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        background: rgba(0, 0, 0, 0.02);
    }

    .other-competency-item:hover {
        background: rgba(0, 122, 255, 0.1);
        transform: translateX(4px);
    }

    .other-competency-image,
    .other-competency-image-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .other-competency-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .other-competency-image-placeholder svg {
        width: 2rem;
        height: 2rem;
    }

    .other-competency-content {
        flex: 1;
        min-width: 0;
    }

    .other-competency-title {
        font-size: 0.9375rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .other-competency-excerpt {
        font-size: 0.8125rem;
        line-height: 1.5;
        color: var(--text-secondary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .view-all-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: rgba(0, 122, 255, 0.1);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .view-all-link:hover {
        background: var(--primary-color);
        color: white;
        gap: 0.75rem;
    }

    .link-icon {
        width: 1rem;
        height: 1rem;
    }
</style>
@endpush
@endsection
