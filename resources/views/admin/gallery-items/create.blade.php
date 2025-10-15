@extends('layouts.admin-modern')

@section('title', 'Add Gallery Items')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Add Gallery Items</h2>
            <p class="text-sm text-gray-500 mt-1">Upload multiple photos to {{ $album ? $album->name : 'an album' }}</p>
        </div>
        <a href="{{ $album ? route('admin.gallery-albums.show', $album) : route('admin.gallery-albums.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.gallery-items.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm" class="space-y-6">
            @csrf

            <!-- Album Selection -->
            <div>
                <label for="album_id" class="block text-sm font-medium text-gray-700 mb-2">Album *</label>
                <select 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('album_id') border-red-500 @enderror" 
                    id="album_id" 
                    name="album_id" 
                    required
                    {{ $album ? 'disabled' : '' }}
                >
                    <option value="">Select an album</option>
                    @foreach($albums as $albumOption)
                        <option value="{{ $albumOption->id }}" {{ ($album && $album->id === $albumOption->id) || old('album_id') == $albumOption->id ? 'selected' : '' }}>
                            {{ $albumOption->name }}
                        </option>
                    @endforeach
                </select>
                @if($album)
                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                @endif
                @error('album_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload Area -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Images *</label>
                <div class="upload-area border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-ios-blue hover:bg-blue-50 transition-colors cursor-pointer" id="uploadArea">
                    <input 
                        type="file" 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror" 
                        id="images" 
                        name="images[]"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        multiple
                        required
                        onchange="handleFileSelect(event)"
                    >
                    <div class="upload-prompt">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-600 mb-2"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-sm text-gray-500">PNG, JPG, GIF up to 5MB each</p>
                    </div>
                </div>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Previews -->
            <div id="previewContainer" class="preview-container" style="display: none;">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Selected Images (<span id="imageCount">0</span>)</h3>
                <div id="previewGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"></div>
            </div>

            <!-- Upload Progress -->
            <div id="uploadProgress" class="upload-progress bg-gray-50 rounded-lg p-6" style="display: none;">
                <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                    <div class="bg-ios-blue h-2 rounded-full transition-all duration-300" id="progressFill" style="width: 0%"></div>
                </div>
                <p class="text-center text-gray-600 text-sm">Uploading <span id="currentFile">0</span> of <span id="totalFiles">0</span> files...</p>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ $album ? route('admin.gallery-albums.show', $album) : route('admin.gallery-albums.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors" id="submitBtn">
                    Upload Images
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.upload-area.drag-over {
    border-color: #007AFF !important;
    background-color: rgba(0, 122, 255, 0.1) !important;
}

.preview-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1;
    background: #f5f5f7;
    border: 1px solid #e5e7eb;
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-item .remove-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(239, 68, 68, 0.9);
    backdrop-filter: blur(10px);
    color: white;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.preview-item .remove-btn:hover {
    background: rgba(239, 68, 68, 1);
    transform: scale(1.1);
}

.preview-item .title-input {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
    border: none;
    color: white;
    padding: 8px;
    font-size: 12px;
}

.preview-item .title-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
</style>
@endpush

@push('scripts')
<script>
let selectedFiles = [];
let fileInputElement = document.getElementById('images');

function handleFileSelect(event) {
    const files = Array.from(event.target.files);
    selectedFiles = files;
    displayPreviews();
}

function displayPreviews() {
    const container = document.getElementById('previewContainer');
    const grid = document.getElementById('previewGrid');
    const count = document.getElementById('imageCount');
    
    if (selectedFiles.length === 0) {
        container.style.display = 'none';
        return;
    }
    
    container.style.display = 'block';
    count.textContent = selectedFiles.length;
    grid.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-btn" onclick="removeFile(${index})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <input type="text" name="titles[${index}]" class="title-input" placeholder="Optional title...">
            `;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    displayPreviews();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInputElement.files = dt.files;
}

// Drag and drop functionality
const uploadArea = document.getElementById('uploadArea');

uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('drag-over');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    
    const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
    if (files.length > 0) {
        const dt = new DataTransfer();
        files.forEach(file => dt.items.add(file));
        fileInputElement.files = dt.files;
        selectedFiles = files;
        displayPreviews();
    }
});

// Form submission with progress
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    if (selectedFiles.length > 0) {
        document.getElementById('uploadProgress').style.display = 'block';
        document.getElementById('totalFiles').textContent = selectedFiles.length;
        document.getElementById('submitBtn').disabled = true;
    }
});
</script>
@endpush
@endsection
