@extends('layouts.admin')

@section('title', $user->name)

@php
    $pageTitle = $user->name;
    $pageDescription = ucfirst($user->role) . ' Account';
    $pageActions = '<a href="' . route('admin.users.edit', $user) . '" class="ios-button-primary">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
        </svg>
        Edit User
    </a>';
    $breadcrumbs = [
        ['title' => 'Users', 'url' => route('admin.users.index')],
        ['title' => $user->name, 'url' => '#']
    ];
@endphp

@section('content')
<div class="ios-grid ios-grid-cols-1 ios-gap-lg">
    <!-- User Profile Card -->
    <div class="ios-card">
        <div class="ios-card-body">
            <div class="ios-flex ios-items-start ios-gap-lg">
                <!-- Profile Image -->
                <div class="user-profile-image">
                    @if($user->profile_image)
                    <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}">
                    @else
                    <div class="user-profile-placeholder">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="ios-flex-1">
                    <div class="ios-flex ios-items-center ios-gap-sm ios-mb-sm">
                        <h2 class="ios-text-2xl ios-font-bold">{{ $user->name }}</h2>
                        <span class="ios-badge 
                            @if($user->role === 'admin') ios-badge-red
                            @elseif($user->role === 'teacher') ios-badge-blue
                            @else ios-badge-gray
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                        @if($user->id === auth()->id())
                        <span class="ios-badge ios-badge-blue">You</span>
                        @endif
                    </div>

                    <div class="ios-grid ios-grid-cols-1 md:ios-grid-cols-2 ios-gap-md ios-mt-md">
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <a href="mailto:{{ $user->email }}" class="ios-color-blue">{{ $user->email }}</a>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Phone</div>
                            <div class="info-value">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                {{ $user->phone ?? 'Not provided' }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Member Since</div>
                            <div class="info-value">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $user->created_at->format('F d, Y') }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $user->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Statistics -->
    <div class="ios-grid ios-grid-cols-1 md:ios-grid-cols-3 ios-gap-md">
        <!-- News Articles -->
        <div class="ios-card">
            <div class="ios-card-body">
                <div class="stat-card">
                    <div class="stat-icon ios-bg-blue-light">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $user->news->count() }}</div>
                        <div class="stat-label">News Articles</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PPDB Verifications -->
        <div class="ios-card">
            <div class="ios-card-body">
                <div class="stat-card">
                    <div class="stat-icon ios-bg-green-light">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $user->verifiedRegistrations->count() }}</div>
                        <div class="stat-label">PPDB Verified</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="ios-card">
            <div class="ios-card-body">
                <div class="stat-card">
                    <div class="stat-icon ios-bg-purple-light">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">Active</div>
                        <div class="stat-label">Account Status</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($user->news->count() > 0)
    <div class="ios-card">
        <div class="ios-card-header">
            <h3 class="ios-text-lg ios-font-semibold">Recent News Articles</h3>
        </div>
        <div class="ios-card-body ios-p-0">
            <div class="ios-table-responsive">
                <table class="ios-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->news->take(5) as $article)
                        <tr>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                <span class="ios-badge {{ $article->status === 'published' ? 'ios-badge-green' : 'ios-badge-gray' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td>{{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.news.edit', $article) }}" class="ios-button-ghost ios-button-sm">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.user-profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.user-profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-profile-placeholder {
    width: 100%;
    height: 100%;
    background: var(--ios-blue);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: 600;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-size: 12px;
    color: var(--ios-gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.info-value {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--ios-label);
    font-size: 15px;
}

.info-value svg {
    color: var(--ios-gray);
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--ios-label);
    line-height: 1;
}

.stat-label {
    font-size: 13px;
    color: var(--ios-gray);
    margin-top: 4px;
}

.ios-bg-blue-light {
    background: rgba(0, 122, 255, 0.1);
    color: var(--ios-blue);
}

.ios-bg-green-light {
    background: rgba(52, 199, 89, 0.1);
    color: var(--ios-green);
}

.ios-bg-purple-light {
    background: rgba(88, 86, 214, 0.1);
    color: var(--ios-purple);
}
</style>
@endsection
