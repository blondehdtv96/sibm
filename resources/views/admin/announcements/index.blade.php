@extends('layouts.admin-modern')

@section('title', 'Pengumuman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengumuman</h1>
            <p class="text-gray-600 mt-1">Kelola pengumuman berupa gambar yang tampil di halaman utama</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengumuman
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Grid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($announcements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($announcements as $item)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="h-48 bg-gray-50 flex items-center justify-center p-3">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2 gap-2">
                            <h3 class="font-semibold text-gray-900 line-clamp-2">{{ $item->title }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        @if($item->link_url)
                        <a href="{{ $item->link_url }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Link
                        </a>
                        @endif
                        <div class="text-xs text-gray-500 mb-3">Urutan: {{ $item->order }}</div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.announcements.edit', $item) }}"
                               class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-center text-sm font-medium">Edit</a>
                            <form action="{{ route('admin.announcements.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($announcements->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">{{ $announcements->links() }}</div>
            @endif
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pengumuman</h3>
                <p class="text-gray-600 mb-4">Mulai tambahkan pengumuman berupa gambar untuk ditampilkan di halaman utama</p>
                <a href="{{ route('admin.announcements.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengumuman Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
