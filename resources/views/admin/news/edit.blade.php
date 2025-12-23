@extends('layouts.admin-modern')

@section('title', 'Edit News Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit News Article</h2>
            <p class="text-sm text-gray-500 mt-1">Update article information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('public.news.show', $news->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Article
            </a>
            <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to News
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $news->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                    required
                    autofocus
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    value="{{ old('slug', $news->slug) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                >
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select 
                    id="category_id" 
                    name="category_id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                    placeholder="Brief summary of the article..."
                >{{ old('excerpt', $news->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from content</p>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="15" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
                    required
                >{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                
                @if($news->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full max-w-md rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-500 mt-2">Current image</p>
                    </div>
                @endif

                <input 
                    type="file" 
                    id="featured_image" 
                    name="featured_image" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image') border-red-500 @enderror"
                    accept="image/*"
                    onchange="previewImage(event)"
                >
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Max 2MB (JPEG, PNG, JPG, GIF)</p>

                <div id="image-preview" class="mt-4" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="w-full max-w-md rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-500 mt-2">New image preview</p>
                </div>
            </div>

            <!-- Gallery Images -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery Images</h3>
                <p class="text-sm text-gray-600 mb-4">Upload multiple photos untuk galeri artikel</p>
                
                <div class="mb-4">
                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">Add Images</label>
                    <input 
                        type="file" 
                        id="gallery_images" 
                        name="images[]" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images') border-red-500 @enderror"
                        accept="image/*"
                        multiple
                        onchange="previewGalleryImages(event)"
                    >
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max 2MB per image (JPEG, PNG, JPG, GIF). Multiple selection allowed.</p>
                </div>

                <!-- New Gallery Preview -->
                <div id="gallery-preview" class="mb-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                </div>

                <!-- Existing Images -->
                @if($images && $images->count() > 0)
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Current Gallery</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($images as $image)
                                <div class="relative group">
                                    <div class="relative overflow-hidden rounded-lg bg-gray-100 h-32">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="Gallery image" 
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-50 transition-opacity"></div>
                                        <button type="button" 
                                                onclick="deleteImage({{ $news->id }}, {{ $image->id }}, this)"
                                                class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" 
                                           value="{{ $image->caption }}"
                                           disabled
                                           class="w-full mt-2 px-3 py-1 text-xs bg-gray-100 border border-gray-300 rounded">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Status & Publish Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                    <input 
                        type="datetime-local" 
                        id="published_at" 
                        name="published_at" 
                        value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror"
                    >
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Leave empty to publish immediately</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Update Article
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Auto-generate slug from title
    const originalSlug = '{{ $news->slug }}';
    document.getElementById('title').addEventListener('input', function(e) {
        const slugInput = document.getElementById('slug');
        if (slugInput.value === originalSlug || slugInput.dataset.autoGenerated) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        if (this.value !== originalSlug) {
            delete this.dataset.autoGenerated;
        }
    });

    // Image preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Gallery image preview
    function previewGalleryImages(event) {
        const files = event.target.files;
        const preview = document.getElementById('gallery-preview');
        preview.innerHTML = '';

        if (files.length === 0) return;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <div class="relative overflow-hidden rounded-lg bg-gray-100 h-32">
                        <img src="${e.target.result}" alt="Gallery preview" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-50 transition-opacity"></div>
                    </div>
                    <input type="text" 
                           name="images_caption[${index}]" 
                           placeholder="Caption" 
                           class="w-full mt-2 px-3 py-1 text-xs border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    // Delete image function
    async function deleteImage(newsId, imageId, button) {
        if (!confirm('Yakin ingin menghapus gambar ini?')) return;

        try {
            const response = await fetch(`/admin/news/${newsId}/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                button.closest('.relative.group').remove();
            } else {
                alert('Gagal menghapus gambar');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        }
    }
</script>
@endpush
@endsection
