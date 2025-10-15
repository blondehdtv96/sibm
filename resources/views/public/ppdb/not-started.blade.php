@extends('layouts.public')

@section('title', 'Registration Not Started')

@section('content')
<div class="ios-container" style="padding: 2rem 0;">
    <div class="ios-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
        <div style="margin-bottom: 1.5rem;">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" style="margin: 0 auto;">
                <circle cx="40" cy="40" r="40" fill="var(--ios-blue)" opacity="0.1"/>
                <circle cx="40" cy="40" r="25" stroke="var(--ios-blue)" stroke-width="3" fill="none"/>
                <path d="M40 25V40L50 50" stroke="var(--ios-blue)" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>

        <h1 class="ios-title-1" style="margin-bottom: 0.5rem;">Registration Opens Soon</h1>
        <p class="ios-body" style="margin-bottom: 2rem; color: var(--ios-gray);">
            PPDB registration has not started yet. Please come back on the opening date.
        </p>

        <div class="ios-card" style="background: var(--ios-bg-tertiary); padding: 1.5rem; margin-bottom: 1.5rem;">
            <p class="ios-caption" style="margin-bottom: 0.5rem; color: var(--ios-gray);">Registration Opens</p>
            <h2 class="ios-title-2" style="color: var(--ios-blue);">
                {{ \Carbon\Carbon::parse($activeSetting->registration_start)->format('F d, Y') }}
            </h2>
            <p class="ios-caption" style="margin-top: 0.5rem; color: var(--ios-gray);">
                Closes on {{ \Carbon\Carbon::parse($activeSetting->registration_end)->format('F d, Y') }}
            </p>
        </div>

        <div class="ios-alert ios-alert-info" style="text-align: left; margin-bottom: 1.5rem;">
            <strong>Prepare your documents:</strong>
            @php
                $requirements = is_string($activeSetting->requirements) 
                    ? json_decode($activeSetting->requirements, true) 
                    : $activeSetting->requirements;
            @endphp
            @if(!empty($requirements))
                <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                    @foreach($requirements as $requirement)
                        <li>{{ $requirement }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a href="{{ route('ppdb.check-status') }}" class="ios-button ios-button-primary">
                Check Existing Registration
            </a>
            <a href="{{ route('home') }}" class="ios-button">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
