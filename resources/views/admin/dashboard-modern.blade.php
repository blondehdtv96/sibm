@extends('layouts.admin-modern')

@section('title', 'Dasbor')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-ios-blue to-blue-600 rounded-2xl p-8 text-white">
        <h2 class="text-3xl font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h2>
        <p class="text-blue-100">Berikut adalah yang terjadi dengan sekolah Anda hari ini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</h3>
            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $stats['users']['total'] }}</p>
            <div class="flex items-center space-x-4 text-xs text-gray-500">
                <span>Admin: {{ $stats['users']['admins'] }}</span>
                <span>Guru: {{ $stats['users']['teachers'] }}</span>
                <span>Siswa: {{ $stats['users']['students'] }}</span>
            </div>
        </div>

        <!-- Content Items -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Item Konten</h3>
            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $stats['content']['pages'] + $stats['content']['news'] + $stats['content']['competencies'] }}</p>
            <div class="flex items-center space-x-4 text-xs text-gray-500">
                <span>Halaman: {{ $stats['content']['pages'] }}</span>
                <span>Berita: {{ $stats['content']['news'] }}</span>
                <span>Program: {{ $stats['content']['competencies'] }}</span>
            </div>
        </div>

        <!-- PPDB Registrations -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                @if($stats['ppdb']['is_active'])
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Aktif</span>
                @else
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">Tidak Aktif</span>
                @endif
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Pendaftaran PPDB</h3>
            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $stats['ppdb']['total'] }}</p>
            <div class="flex items-center space-x-4 text-xs">
                <span class="text-yellow-600">Menunggu: {{ $stats['ppdb']['pending'] }}</span>
                <span class="text-green-600">Terverifikasi: {{ $stats['ppdb']['verified'] }}</span>
                <span class="text-red-600">Ditolak: {{ $stats['ppdb']['rejected'] }}</span>
            </div>
        </div>

        <!-- Gallery -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Galeri</h3>
            <p class="text-3xl font-bold text-gray-900 mb-3">{{ $stats['content']['gallery_items'] }}</p>
            <div class="flex items-center space-x-4 text-xs text-gray-500">
                <span>Album: {{ $stats['content']['gallery_albums'] }}</span>
                <span>Item: {{ $stats['content']['gallery_items'] }}</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- PPDB Registrations Chart -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pendaftaran PPDB</h3>
                <span class="text-sm text-gray-500">30 Hari Terakhir</span>
            </div>
            <div class="h-64">
                <canvas id="ppdbChart"></canvas>
            </div>
        </div>

        <!-- Visitor Statistics Chart -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Statistik Pengunjung</h3>
                @if($stats['visitors']['enabled'])
                    <div class="flex items-center space-x-3 text-xs text-gray-500">
                        <span>Hari ini: {{ $stats['visitors']['today'] }}</span>
                        <span>Minggu: {{ $stats['visitors']['this_week'] }}</span>
                        <span>Bulan: {{ $stats['visitors']['this_month'] }}</span>
                    </div>
                @else
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">Pelacakan Dinonaktifkan</span>
                @endif
            </div>
            <div class="h-64">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent News -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Berita Terbaru</h3>
                <a href="{{ route('admin.news.index') }}" class="text-sm text-ios-blue hover:underline font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recentNews as $news)
                    <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $news->title }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $news->author->name }} • {{ $news->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $news->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $news->status === 'published' ? 'Diterbitkan' : ($news->status === 'draft' ? 'Draf' : ucfirst($news->status)) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Tidak ada artikel berita terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent PPDB Registrations -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pendaftaran PPDB Terbaru</h3>
                <a href="{{ route('admin.ppdb-registrations.index') }}" class="text-sm text-ios-blue hover:underline font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recentRegistrations as $registration)
                    <div class="flex items-start space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $registration->student_name }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $registration->registration_number }} • {{ $registration->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $registration->status === 'verified' ? 'bg-green-100 text-green-700' : ($registration->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $registration->status === 'verified' ? 'Terverifikasi' : ($registration->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p>Tidak ada pendaftaran terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // PPDB Registrations Chart
    const ppdbData = @json($stats['ppdb']['daily_registrations']);
    
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
                    label: 'Pendaftaran',
                    data: last30DaysCounts,
                    borderColor: '#007AFF',
                    backgroundColor: 'rgba(0, 122, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointHoverRadius: 5,
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
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11 },
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
                    label: 'Pengunjung Unik',
                    data: visitorLast30DaysCounts,
                    backgroundColor: 'rgba(88, 86, 214, 0.8)',
                    borderRadius: 6,
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
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11 },
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
});
</script>
@endpush
@endsection
