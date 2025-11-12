@extends('layouts.admin-modern')

@section('title', 'Galeri ' . $competency->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.competencies.index') }}" class="hover:text-blue-600">Kompetensi Keahlian</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ $competency->name }}</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Galeri Gambar Slider</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola gambar slider untuk {{ $competency->name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.competencies.edit', $competency) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Kompetensi
            </a>
            <a href="{{ route('admin.competencies.images.create', $competency) }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Gambar
            </a>
        </div>
    </div>

    <!-- Images Grid -->
    @if($images->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($images as $image)
                    <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Image -->
                        <div class="aspect-video bg-gray-100 relative overflow-hidden">
                            <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="w-full h-full object-cover">
                            
                            <!-- Order Badge -->
                            <div class="absolute top-2 left-2 bg-black/70 text-white px-2 py-1 rounded text-xs font-semibold">
                                #{{ $image->order }}
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $image->status === 'active' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                                    {{ ucfirst($image->status) }}
                                </span>
                            </div>

                            <!-- Overlay Actions -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <a href="{{ route('admin.competencies.images.edit', [$competency, $image]) }}" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="deleteImage({{ $image->id }})" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4">
                            @if($image->title)
                                <h3 class="font-semibold text-gray-900 mb-1 truncate">{{ $image->title }}</h3>
                            @endif
                            @if($image->description)
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $image->description }}</p>
                            @endif
                            @if(!$image->title && !$image->description)
                                <p class="text-sm text-gray-400 italic">Tidak ada deskripsi</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($images->hasPages())
                <div class="mt-6">
                    {{ $images->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada gambar</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan gambar slider pertama</p>
            <a href="{{ route('admin.competencies.images.create', $competency) }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Gambar
            </a>
        </div>
    @endif
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteImage(id) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/competencies/{{ $competency->slug }}/images/${id}`;
        form.submit();
    }
}
</script>
@endpush
