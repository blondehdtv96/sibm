@extends('layouts.admin-modern')

@section('title', 'Pendaftaran PPDB')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pendaftaran PPDB</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola aplikasi pendaftaran siswa</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.ppdb-registrations.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama, email, atau nomor registrasi..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                >
            </div>
            <div class="w-full md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Saring
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.ppdb-registrations.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Hapus
                </a>
            @endif
        </form>
    </div>
    </form>

    <!-- Statistics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        @php
            $totalCount = \App\Models\PpdbRegistration::count();
            $pendingCount = \App\Models\PpdbRegistration::where('status', 'pending')->count();
            $verifiedCount = \App\Models\PpdbRegistration::where('status', 'verified')->count();
            $rejectedCount = \App\Models\PpdbRegistration::where('status', 'rejected')->count();
        @endphp
        
        <div class="ios-card" style="background: var(--ios-bg-tertiary); padding: 1rem;">
            <p class="ios-caption" style="color: var(--ios-gray); margin-bottom: 0.25rem;">Total</p>
            <h3 class="ios-title-2">{{ $totalCount }}</h3>
        </div>
        
        <div class="ios-card" style="background: var(--ios-bg-tertiary); padding: 1rem;">
            <p class="ios-caption" style="color: var(--ios-gray); margin-bottom: 0.25rem;">Pending</p>
            <h3 class="ios-title-2" style="color: var(--ios-orange);">{{ $pendingCount }}</h3>
        </div>
        
        <div class="ios-card" style="background: var(--ios-bg-tertiary); padding: 1rem;">
            <p class="ios-caption" style="color: var(--ios-gray); margin-bottom: 0.25rem;">Verified</p>
            <h3 class="ios-title-2" style="color: var(--ios-green);">{{ $verifiedCount }}</h3>
        </div>
        
        <div class="ios-card" style="background: var(--ios-bg-tertiary); padding: 1rem;">
            <p class="ios-caption" style="color: var(--ios-gray); margin-bottom: 0.25rem;">Rejected</p>
            <h3 class="ios-title-2" style="color: var(--ios-red);">{{ $rejectedCount }}</h3>
        </div>
    </div>

    @if($registrations->isEmpty())
        <div class="ios-empty-state">
            <p>No registrations found.</p>
        </div>
    @else
        <div class="ios-table-container">
            <table class="ios-table">
                <thead>
                    <tr>
                        <th>Registration #</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                        <tr>
                            <td>
                                <span style="font-family: 'Courier New', monospace; font-weight: 600;">
                                    {{ $registration->registration_number }}
                                </span>
                            </td>
                            <td>{{ $registration->student_name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            <td>
                                @if($registration->status === 'pending')
                                    <span class="ios-badge ios-badge-warning">Pending</span>
                                @elseif($registration->status === 'verified')
                                    <span class="ios-badge ios-badge-success">Verified</span>
                                @elseif($registration->status === 'rejected')
                                    <span class="ios-badge ios-badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <span class="ios-caption">
                                    {{ $registration->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.ppdb-registrations.show', $registration) }}" class="ios-button ios-button-small">
                                        View
                                    </a>
                                    <form action="{{ route('admin.ppdb-registrations.destroy', $registration) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ios-button ios-button-small ios-button-danger" onclick="return confirm('Are you sure you want to delete this registration?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endsection
