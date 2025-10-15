@extends('layouts.public')

@section('title', 'Registration Closed')

@section('content')
<div class="ios-container" style="padding: 2rem 0;">
    <div class="ios-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
        <div style="margin-bottom: 1.5rem;">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" style="margin: 0 auto;">
                <circle cx="40" cy="40" r="40" fill="var(--ios-gray)" opacity="0.1"/>
                <path d="M30 30L50 50M50 30L30 50" stroke="var(--ios-gray)" stroke-width="4" stroke-linecap="round"/>
            </svg>
        </div>

        <h1 class="ios-title-1" style="margin-bottom: 0.5rem;">Registration Closed</h1>
        <p class="ios-body" style="margin-bottom: 2rem; color: var(--ios-gray);">
            PPDB registration is currently not available. Please check back later for the next registration period.
        </p>

        <div class="ios-alert ios-alert-info" style="text-align: left; margin-bottom: 1.5rem;">
            <strong>What you can do:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                <li>Check your existing registration status</li>
                <li>Contact the school for more information</li>
                <li>Kunjungi website kami untuk update periode pendaftaran selanjutnya</li>
            </ul>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('ppdb.check-status') }}" class="ios-button ios-button-primary">
                Check Registration Status
            </a>
            <a href="{{ route('home') }}" class="ios-button">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
