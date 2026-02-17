@extends('layouts.admin-modern')

@section('title', 'Partner Industri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Partner Industri</h1>
            <p class="text-gray-600 mt-1">Kelola logo kerjasama dengan dunia industri</p>
        </div>
        <a href="{{ route('admin.industry-partners.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Partner
        </a>
    </div>

    <!-- Partners Grid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($partners->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($partners as $partner)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Logo -->
                    <div class="h-40 bg-gray-50 flex items-center justify-center p-4">
                        <img src="{{ asset('storage/' . $partner->logo) }}" 
                             alt="{{ $partner->name }}"
                             class="max-w-full max-h-full object-contain">
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-semibold text-gray-900">{{ $partner->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full {{ $partner->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $partner->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        
                        @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Website
                        </a>
                        @endif
                        
                        @if($partner->description)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $partner->description }}</p>
                        @endif
                        
                        <div class="text-xs text-gray-500 mb-3">
                            Urutan: {{ $partner->order }}
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.industry-partners.edit', $partner) }}" 
                               class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-center text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.industry-partners.destroy', $partner) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus partner ini?')"
                                  class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($partners->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $partners->links() }}
            </div>
            @endif
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Partner</h3>
                <p class="text-gray-600 mb-4">Mulai tambahkan partner industri untuk ditampilkan di website</p>
                <a href="{{ route('admin.industry-partners.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Partner Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
