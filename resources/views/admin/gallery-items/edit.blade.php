@extends('layouts.admin-modern')

@section('title', 'Edit Gallery Item')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Gallery Item</h2>
            <p class="text-sm text-gray-500 mt-1">Update item information</p>
        </div>
        <a href="{{ route('admin.gallery-albums.show', $galleryItem->album) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Album
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <form action="{{ route('admin.gallery-items.update', $galleryItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="album_id" class="form-label required">Album</label>
            <select 
                class="form-control @error('album_id') is-invalid @enderror" 
                id="album_id" 
                name="album_id" 
                required
            >
                @foreach($albums as $album)
                    <option value="{{ $album->id }}" {{ old('album_id', $galleryItem->album_id) == $album->id ? 'selected' : '' }}>
                        {{ $album->name }}
                    </option>
                @endforeach
            </select>
            @error('album_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title', $galleryItem->title) }}"
                placeholder="Optional title for this image"
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Image</label>
            <div class="current-image">
                <img src="{{ $galleryItem->image_url }}" alt="{{ $galleryItem->title }}">
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="form-label">Replace Image</label>
            <div class="image-upload-wrapper">
                <input 
                    type="file" 
                    class="form-control @error('image') is-invalid @enderror" 
                    id="image" 
                    name="image"
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
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text">Upload a new image to replace the current one. Max 5MB.</small>
        </div>

        <div class="form-group">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input 
                type="number" 
                class="form-control @error('sort_order') is-invalid @enderror" 
                id="sort_order" 
                name="sort_order" 
                value="{{ old('sort_order', $galleryItem->sort_order) }}"
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
                    <path d="M4 12L8 16L16 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Update Item
            </button>
            <a href="{{ route('admin.gallery-albums.show', $galleryItem->album) }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('styles')
<style>
.current-image {
    max-width: 500px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.current-image img {
    width: 100%;
    height: auto;
    display: block;
}

.image-upload-wrapper {
    position: relative;
}

.image-preview {
    margin-top: 16px;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    max-width: 500px;
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
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('preview').src = '';
}
</script>
@endpush
@endsection
