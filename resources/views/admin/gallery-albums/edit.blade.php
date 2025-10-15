@extends('layouts.admin-modern')

@section('title', 'Edit Gallery Album')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Gallery Album</h2>
            <p class="text-sm text-gray-500 mt-1">Update album information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.gallery-albums.show', $galleryAlbum) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Album
            </a>
            <a href="{{ route('admin.gallery-albums.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Albums
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.gallery-albums.update', $galleryAlbum) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label required">Album Name</label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ old('name', $galleryAlbum->name) }}" 
                required
                placeholder="e.g., School Events 2024"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description" 
                rows="4"
                placeholder="Describe what this album contains..."
            >{{ old('description', $galleryAlbum->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">Optional description to help visitors understand the album content</small>
        </div>

        <div class="form-group">
            <label for="cover_image" class="form-label">Cover Image</label>
            
            @if($galleryAlbum->cover_image)
                <div class="current-image">
                    <img src="{{ $galleryAlbum->cover_image_url }}" alt="{{ $galleryAlbum->name }}">
                    <p class="text-secondary mt-2">Current cover image</p>
                </div>
            @endif
            
            <div class="image-upload-wrapper">
                <input 
                    type="file" 
                    class="form-control @error('cover_image') is-invalid @enderror" 
                    id="cover_image" 
                    name="cover_image"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    onchange="previewImage(event)"
                >
                <div id="imagePreview" class="image-preview" style="display: none;">
                    <img id="preview" src="" alt="Preview">
                    <button type="button" class="btn-remove-image" onclick="removeImage()">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            @error('cover_image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text">Upload a new image to replace the current one. Recommended size: 1200x800px. Max 2MB.</small>
        </div>

        <div class="form-group">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input 
                type="number" 
                class="form-control @error('sort_order') is-invalid @enderror" 
                id="sort_order" 
                name="sort_order" 
                value="{{ old('sort_order', $galleryAlbum->sort_order) }}"
                min="0"
            >
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text">Lower numbers appear first</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 10L12 6M16 10L12 14M16 10H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Update Album
            </button>
            <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.current-image {
    margin-bottom: 20px;
    max-width: 400px;
}

.current-image img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.image-upload-wrapper {
    position: relative;
}

.image-preview {
    margin-top: 16px;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    max-width: 400px;
}

.image-preview img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 12px;
}

.btn-remove-image {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255, 59, 48, 0.9);
    backdrop-filter: blur(10px);
    color: white;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-remove-image:hover {
    background: rgba(255, 59, 48, 1);
    transform: scale(1.1);
}
</style>
@endpush

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
