@extends('layouts.admin-modern')

@section('title', 'Profil Guru dan Karyawan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Profil Guru dan Karyawan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola nama, jabatan, foto, dan informasi tenaga sekolah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.staff-profiles.export') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Export CSV</a>
            <a href="{{ route('admin.staff-profiles.trash') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Tempat Sampah</a>
            <a href="{{ route('admin.staff-profiles.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">Tambah Profil</a>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.staff-profiles.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama atau jabatan..." class="md:col-span-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                <option value="">Semua Kelompok</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <select name="employment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                <option value="">Semua Status Kepegawaian</option>
                @foreach($employmentStatuses as $employmentStatus)
                    <option value="{{ $employmentStatus }}" {{ request('employment_status') === $employmentStatus ? 'selected' : '' }}>{{ $employmentStatus }}</option>
                @endforeach
            </select>
            <input type="search" name="jurusan" value="{{ request('jurusan') }}" placeholder="Jurusan / program..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Filter</button>
                @if(request()->hasAny(['search', 'category', 'status']))
                    <a href="{{ route('admin.staff-profiles.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($staffProfiles->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Profil</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kelompok</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Urutan</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($staffProfiles as $profile)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($profile->photo)
                                            <img src="{{ $profile->photo_url }}" alt="{{ $profile->name }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">{{ strtoupper(substr($profile->name, 0, 1)) }}</div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $profile->name }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($profile->bio ?? 'Belum ada deskripsi', 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $profile->position }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $profile->category }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $profile->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $profile->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $profile->sort_order }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin.staff-profiles.show', $profile) }}" class="p-2 text-gray-400 hover:text-ios-blue" title="Lihat">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7z"/></svg>
                                        </a>
                                        <a href="{{ route('admin.staff-profiles.edit', $profile) }}" class="p-2 text-gray-400 hover:text-ios-blue" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.staff-profiles.destroy', $profile) }}" onsubmit="return confirm('Hapus profil ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($staffProfiles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">{{ $staffProfiles->links() }}</div>
            @endif
        @else
            <div class="text-center py-16 px-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Belum ada profil</h3>
                <p class="text-gray-500 mt-1 mb-5">Tambahkan profil guru atau karyawan untuk ditampilkan di situs.</p>
                <a href="{{ route('admin.staff-profiles.create') }}" class="inline-flex px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600">Tambah Profil</a>
            </div>
        @endif
    </div>
</div>
@endsection
