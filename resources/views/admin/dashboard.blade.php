@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <div class="dashboard-actions">
            <div class="auto-refresh-toggle">
                <label class="toggle-switch">
                    <input type="checkbox" id="autoRefresh">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-label">Auto-refresh</span>
            </div>
            <div class="dropdown">
                <button class="btn-export" id="exportBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Export
                </button>
                <div class="dropdown-menu" id="exportMenu">
                    <a href="{{ route('admin.dashboard.export', ['type' => 'summary']) }}" class="dropdown-item">Summary Report</a>
                    <a href="{{ route('admin.dashboard.export', ['type' => 'ppdb']) }}" class="dropdown-item">PPDB Statistics</a>
                    <a href="{{ route('admin.dashboard.export', ['type' => 'visitors']) }}" class="dropdown-item">Visitor Statistics</a>
                    <a href="{{ route('admin.dashboard.export', ['type' => 'users']) }}" class="dropdown-item">User Statistics</a>
                </div>
            </div>
            <button id="refreshDashboard" class="btn-refresh">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M17.5 10C17.5 14.1421 14.1421 17.5 10 17.5C5.85786 17.5 2.5 14.1421 2.5 10C2.5 5.85786 5.85786 2.5 10 2.5C12.0711 2.5 13.9461 3.35714 15.3033 4.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M17.5 2.5V6.5H13.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Users Stats -->
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Users</div>
                <div class="stat-value" id="totalUsers">{{ $stats['users']['total'] }}</div>
                <div class="stat-breakdown">
                    <span>Admins: {{ $stats['users']['admins'] }}</span>
                    <span>Teachers: {{ $stats['users']['teachers'] }}</span>
                    <span>Students: {{ $stats['users']['students'] }}</span>
                </div>
            </div>
        </div>

        <!-- Content Stats -->
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14 2V8H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Content Items</div>
                <div class="stat-value" id="totalContent">{{ $stats['content']['pages'] + $stats['content']['news'] + $stats['content']['competencies'] }}</div>
                <div class="stat-breakdown">
                    <span>Pages: {{ $stats['content']['pages'] }}</span>
                    <span>News: {{ $stats['content']['news'] }}</span>
                    <span>Programs: {{ $stats['content']['competencies'] }}</span>
                </div>
            </div>
        </div>

        <!-- PPDB Stats -->
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M16 21V19C16 17.9391 15.5786 16.9217 14.8284 16.1716C14.0783 15.4214 13.0609 15 12 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.5 11C10.7091 11 12.5 9.20914 12.5 7C12.5 4.79086 10.7091 3 8.5 3C6.29086 3 4.5 4.79086 4.5 7C4.5 9.20914 6.29086 11 8.5 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 8V14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M23 11H17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">PPDB Registrations</div>
                <div class="stat-value" id="totalPpdb">{{ $stats['ppdb']['total'] }}</div>
                <div class="stat-breakdown">
                    <span class="status-pending">Pending: {{ $stats['ppdb']['pending'] }}</span>
                    <span class="status-verified">Verified: {{ $stats['ppdb']['verified'] }}</span>
                    <span class="status-rejected">Rejected: {{ $stats['ppdb']['rejected'] }}</span>
                </div>
            </div>
        </div>

        <!-- Gallery Stats -->
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="8.5" cy="8.5" r="1.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 15L16 10L5 21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-label">Gallery</div>
                <div class="stat-value" id="totalGallery">{{ $stats['content']['gallery_items'] }}</div>
                <div class="stat-breakdown">
                    <span>Albums: {{ $stats['content']['gallery_albums'] }}</span>
                    <span>Items: {{ $stats['content']['gallery_items'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- PPDB Registrations Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>PPDB Registrations (Last 30 Days)</h3>
                @if($stats['ppdb']['is_active'])
                    <span class="badge badge-success">Active</span>
                @else
                    <span class="badge badge-secondary">Inactive</span>
                @endif
            </div>
            <div class="chart-container">
                <canvas id="ppdbChart"></canvas>
            </div>
        </div>

        <!-- Visitor Statistics Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Visitor Statistics (Last 30 Days)</h3>
                @if($stats['visitors']['enabled'])
                    <div class="visitor-stats-summary">
                        <span>Today: {{ $stats['visitors']['today'] }}</span>
                        <span>This Week: {{ $stats['visitors']['this_week'] }}</span>
                        <span>This Month: {{ $stats['visitors']['this_month'] }}</span>
                    </div>
                @else
                    <span class="badge badge-warning">Tracking Disabled</span>
                @endif
            </div>
            <div class="chart-container">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="activity-grid">
        <!-- Recent News -->
        <div class="activity-card">
            <div class="activity-header">
                <h3>Recent News</h3>
                <a href="{{ route('admin.news.index') }}" class="btn-link">View All</a>
            </div>
            <div class="activity-list">
                @forelse($recentNews as $news)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $news->title }}</div>
                            <div class="activity-meta">
                                <span>{{ $news->author->name }}</span>
                                <span>•</span>
                                <span>{{ $news->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="badge badge-{{ $news->status === 'published' ? 'success' : 'secondary' }}">
                            {{ ucfirst($news->status) }}
                        </span>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No recent news articles</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent PPDB Registrations -->
        <div class="activity-card">
            <div class="activity-header">
                <h3>Recent PPDB Registrations</h3>
                <a href="{{ route('admin.ppdb-registrations.index') }}" class="btn-link">View All</a>
            </div>
            <div class="activity-list">
                @forelse($recentRegistrations as $registration)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $registration->student_name }}</div>
                            <div class="activity-meta">
                                <span>{{ $registration->registration_number }}</span>
                                <span>•</span>
                                <span>{{ $registration->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="badge badge-{{ $registration->status === 'verified' ? 'success' : ($registration->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No recent registrations</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-container {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}

.dashboard-title {
    font-size: 34px;
    font-weight: 700;
    color: #1d1d1f;
    margin: 0;
}

.dashboard-subtitle {
    font-size: 17px;
    color: #86868b;
    margin: 4px 0 0 0;
}

.dashboard-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.auto-refresh-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 26px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.3s;
    border-radius: 26px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #34C759;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(18px);
}

.toggle-label {
    font-size: 14px;
    color: #1d1d1f;
    font-weight: 500;
}

.dropdown {
    position: relative;
}

.btn-export {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(52, 199, 89, 0.1);
    color: #34C759;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-export:hover {
    background: rgba(52, 199, 89, 0.2);
    transform: translateY(-1px);
}

.btn-export:active {
    transform: translateY(0);
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    min-width: 200px;
    padding: 8px;
    display: none;
    z-index: 1000;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    padding: 10px 16px;
    color: #1d1d1f;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    transition: background 0.2s ease;
}

.dropdown-item:hover {
    background: rgba(0, 0, 0, 0.05);
}

.btn-refresh {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(0, 122, 255, 0.1);
    color: #007AFF;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-refresh:hover {
    background: rgba(0, 122, 255, 0.2);
    transform: translateY(-1px);
}

.btn-refresh:active {
    transform: translateY(0);
}

.btn-refresh:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-refresh.refreshing svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    display: flex;
    gap: 16px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 13px;
    color: #86868b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1d1d1f;
    margin-bottom: 8px;
}

.stat-breakdown {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 13px;
    color: #86868b;
}

.stat-breakdown span {
    display: block;
}

.status-pending { color: #FF9500; }
.status-verified { color: #34C759; }
.status-rejected { color: #FF3B30; }

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.chart-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.chart-header h3 {
    font-size: 20px;
    font-weight: 600;
    color: #1d1d1f;
    margin: 0;
}

.visitor-stats-summary {
    display: flex;
    gap: 16px;
    font-size: 13px;
    color: #86868b;
}

.chart-container {
    position: relative;
    height: 300px;
}

.activity-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 20px;
}

.activity-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.activity-header h3 {
    font-size: 20px;
    font-weight: 600;
    color: #1d1d1f;
    margin: 0;
}

.btn-link {
    color: #007AFF;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
}

.btn-link:hover {
    text-decoration: underline;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 12px;
    transition: all 0.2s ease;
}

.activity-item:hover {
    background: rgba(0, 0, 0, 0.04);
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(0, 122, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007AFF;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-title {
    font-size: 15px;
    font-weight: 600;
    color: #1d1d1f;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-meta {
    font-size: 13px;
    color: #86868b;
    margin-top: 2px;
}

.activity-meta span {
    margin-right: 4px;
}

.badge {
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.badge-success {
    background: rgba(52, 199, 89, 0.1);
    color: #34C759;
}

.badge-warning {
    background: rgba(255, 149, 0, 0.1);
    color: #FF9500;
}

.badge-danger {
    background: rgba(255, 59, 48, 0.1);
    color: #FF3B30;
}

.badge-secondary {
    background: rgba(134, 134, 139, 0.1);
    color: #86868b;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #86868b;
}

.empty-state p {
    margin: 0;
    font-size: 15px;
}

@media (max-width: 768px) {
    .stats-grid,
    .charts-grid,
    .activity-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // PPDB Registrations Chart
    const ppdbData = @json($stats['ppdb']['daily_registrations']);
    const ppdbDates = Object.keys(ppdbData);
    const ppdbCounts = Object.values(ppdbData);
    
    // Fill in missing dates for the last 30 days
    const last30Days = [];
    const last30DaysCounts = [];
    for (let i = 29; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const dateStr = date.toISOString().split('T')[0];
        last30Days.push(dateStr);
        last30DaysCounts.push(ppdbData[dateStr] || 0);
    }
    
    const ppdbCtx = document.getElementById('ppdbChart');
    if (ppdbCtx) {
        new Chart(ppdbCtx, {
            type: 'line',
            data: {
                labels: last30Days.map(d => new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                datasets: [{
                    label: 'Registrations',
                    data: last30DaysCounts,
                    borderColor: '#007AFF',
                    backgroundColor: 'rgba(0, 122, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleFont: { size: 14, weight: '600' },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Visitor Statistics Chart
    const visitorData = @json($stats['visitors']['daily_visitors']);
    const visitorDates = Object.keys(visitorData);
    const visitorCounts = Object.values(visitorData);
    
    // Fill in missing dates for the last 30 days
    const visitorLast30Days = [];
    const visitorLast30DaysCounts = [];
    for (let i = 29; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const dateStr = date.toISOString().split('T')[0];
        visitorLast30Days.push(dateStr);
        visitorLast30DaysCounts.push(visitorData[dateStr] || 0);
    }
    
    const visitorCtx = document.getElementById('visitorChart');
    if (visitorCtx) {
        new Chart(visitorCtx, {
            type: 'bar',
            data: {
                labels: visitorLast30Days.map(d => new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                datasets: [{
                    label: 'Unique Visitors',
                    data: visitorLast30DaysCounts,
                    backgroundColor: 'rgba(88, 86, 214, 0.8)',
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleFont: { size: 14, weight: '600' },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 12 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12 },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Refresh Dashboard
    const refreshBtn = document.getElementById('refreshDashboard');
    refreshBtn.addEventListener('click', function() {
        refreshDashboard();
    });
    
    function refreshDashboard() {
        refreshBtn.disabled = true;
        refreshBtn.classList.add('refreshing');
        
        // Reload the page to refresh data
        setTimeout(() => {
            location.reload();
        }, 300);
    }
    
    // Auto-refresh functionality
    let autoRefreshInterval = null;
    const autoRefreshCheckbox = document.getElementById('autoRefresh');
    
    // Load auto-refresh preference from localStorage
    const autoRefreshEnabled = localStorage.getItem('dashboardAutoRefresh') === 'true';
    autoRefreshCheckbox.checked = autoRefreshEnabled;
    
    if (autoRefreshEnabled) {
        startAutoRefresh();
    }
    
    autoRefreshCheckbox.addEventListener('change', function() {
        if (this.checked) {
            localStorage.setItem('dashboardAutoRefresh', 'true');
            startAutoRefresh();
        } else {
            localStorage.setItem('dashboardAutoRefresh', 'false');
            stopAutoRefresh();
        }
    });
    
    function startAutoRefresh() {
        // Refresh every 5 minutes (300000 ms)
        autoRefreshInterval = setInterval(() => {
            console.log('Auto-refreshing dashboard...');
            refreshDashboard();
        }, 300000);
    }
    
    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
    }
    
    // Export dropdown functionality
    const exportBtn = document.getElementById('exportBtn');
    const exportMenu = document.getElementById('exportMenu');
    
    exportBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        exportMenu.classList.toggle('show');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!exportBtn.contains(e.target) && !exportMenu.contains(e.target)) {
            exportMenu.classList.remove('show');
        }
    });
    
    // Close dropdown when clicking on a menu item
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            exportMenu.classList.remove('show');
        });
    });
});
</script>
@endpush
@endsection
