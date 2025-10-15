@extends('layouts.admin-modern')

@section('title', 'Create Gallery Album')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create Gallery Album</h2>
            <p class="text-sm text-gray-500 mt-1">Add a new album to organize photos and videos</p>
        </div>
        <a href="{{ route('admin.gallery-albums.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Albums
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.gallery-albums.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Album Name *</label>
                <input 
                    type="text" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('name') border-red-500 @enderror" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required
                    placeholder="e.g., School Events 2024"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('description') border-red-500 @enderror" 
                    id="description" 
                    name="description" 
                    rows="4"
                    placeholder="Describe what this album contains..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Optional description to help visitors understand the album content</p>
            </div>

            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">Cover Image</label>
                <input 
                    type="file" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('cover_image') border-red-500 @enderror" 
                    id="cover_image" 
                    name="cover_image"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    onchange="previewImage(event)"
                >
                <div id="imagePreview" class="mt-4" style="display: none;">
                    <div class="relative inline-block">
                        <img id="preview" src="" alt="Preview" class="max-w-sm rounded-lg border border-gray-200">
                        <button type="button" class="absolute top-2 right-2 bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors" onclick="removeImage()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Optional. Recommended size: 1200x800px. Max 2MB. Formats: JPG, PNG, GIF</p>
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                <input 
                    type="number" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('sort_order') border-red-500 @enderror" 
                    id="sort_order" 
                    name="sort_order" 
                    value="{{ old('sort_order', 0) }}"
                    min="0"
                >
                @error('sort_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Lower numbers appear first. Leave as 0 to add at the end.</p>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.gallery-albums.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Create Album
                </button>
            </div>
        </form>
    </div>
</div>



@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('cover_image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('preview').src = '';
}
</script>
@endpush
@endsection
