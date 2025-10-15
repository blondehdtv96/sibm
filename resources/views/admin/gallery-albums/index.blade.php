@extends('layouts.admin-modern')

@section('title', 'Gallery Albums')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Gallery Albums</h2>
            <p class="text-sm text-gray-500 mt-1">Manage photo and video albums</p>
        </div>
        <a href="{{ route('admin.gallery-albums.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Album
        </a>
    </div>

    <!-- Albums Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($albums->count() > 0)
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="albumsGrid">
                    @foreach($albums as $album)
                        <div class="gallery-album-card group relative bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 cursor-move" data-album-id="{{ $album->id }}" data-sort-order="{{ $album->sort_order }}">
                            <!-- Cover Image -->
                            <div class="relative aspect-video bg-gradient-to-br from-blue-500 to-purple-600">
                                @if($album->cover_image_url)
                                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Items Count Badge -->
                                <div class="absolute top-3 right-3 bg-black bg-opacity-60 text-white text-xs font-semibold px-2 py-1 rounded-full backdrop-blur-sm">
                                    {{ $album->items_count }} {{ Str::plural('item', $album->items_count) }}
                                </div>
                                
                                <!-- Drag Handle -->
                                <div class="drag-handle absolute top-3 left-3 bg-black bg-opacity-60 text-white w-8 h-8 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-move">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Album Info -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $album->name }}</h3>
                                @if($album->description)
                                    <p class="text-sm text-gray-500 mb-3">{{ Str::limit($album->description, 60) }}</p>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.gallery-albums.show', $album) }}" class="flex-1 px-3 py-1.5 bg-ios-blue text-white text-sm rounded-lg hover:bg-blue-600 transition-colors text-center">
                                        View Items
                                    </a>
                                    <a href="{{ route('admin.gallery-albums.edit', $album) }}" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.gallery-albums.destroy', $album) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this album? All items will be deleted.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-100 text-red-700 text-sm rounded-lg hover:bg-red-200 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if($albums->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $albums->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No albums yet</h3>
                <p class="text-gray-500 mb-6">Create your first gallery album to organize photos and videos</p>
                <a href="{{ route('admin.gallery-albums.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Album
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.sortable-ghost {
    opacity: 0.4;
    transform: rotate(5deg);
}

.gallery-album-card {
    transition: all 0.3s ease;
}

.gallery-album-card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('albumsGrid');
    
    if (grid) {
        const sortable = new Sortable(grid, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                updateAlbumOrder();
            }
        });
    }
    
    function updateAlbumOrder() {
        const cards = document.querySelectorAll('.gallery-album-card');
        const albums = [];
        
        cards.forEach((card, index) => {
            albums.push({
                id: parseInt(card.dataset.albumId),
                sort_order: index
            });
        });
        
        fetch('{{ route('admin.gallery-albums.update-order') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ albums: albums })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Album order updated');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
@endpush
@endsection
