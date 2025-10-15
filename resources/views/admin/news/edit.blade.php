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

<form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="ios-card">
                <div class="form-group">
                    <label for="title" class="form-label required">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-input @error('title') is-invalid @enderror" 
                        value="{{ old('title', $news->title) }}"
                        required
                        autofocus
                    >
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">Slug</label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        class="form-input @error('slug') is-invalid @enderror" 
                        value="{{ old('slug', $news->slug) }}"
                    >
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Leave empty to auto-generate from title</span>
                </div>

                <div class="form-group">
                    <label for="excerpt" class="form-label">Excerpt</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3" 
                        class="form-input @error('excerpt') is-invalid @enderror"
                        placeholder="Brief summary of the article..."
                    >{{ old('excerpt', $news->excerpt) }}</textarea>
                    @error('excerpt')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Leave empty to auto-generate from content</span>
                </div>

                <div class="form-group">
                    <label for="content" class="form-label required">Content</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="15" 
                        class="form-input @error('content') is-invalid @enderror"
                        required
                    >{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="ios-card mb-6">
                <h3 class="card-title">Publish</h3>
                
                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="published_at" class="form-label">Publish Date</label>
                    <input 
                        type="datetime-local" 
                        id="published_at" 
                        name="published_at" 
                        class="form-input @error('published_at') is-invalid @enderror"
                        value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                    >
                    @error('published_at')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Leave empty to publish immediately</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Article
                    </button>
                </div>
            </div>

            <div class="ios-card mb-6">
                <h3 class="card-title">Category</h3>
                
                <div class="form-group">
                    <label for="category_id" class="form-label required">Category</label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        class="form-select @error('category_id') is-invalid @enderror"
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
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="ios-card">
                <h3 class="card-title">Featured Image</h3>
                
                @if($news->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" 
                             alt="{{ $news->title }}" 
                             class="w-full rounded-lg">
                        <p class="text-sm text-secondary mt-2">Current image</p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="featured_image" class="form-label">{{ $news->featured_image ? 'Replace Image' : 'Image' }}</label>
                    <input 
                        type="file" 
                        id="featured_image" 
                        name="featured_image" 
                        class="form-input @error('featured_image') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >
                    @error('featured_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Max 2MB (JPEG, PNG, JPG, GIF)</span>
                </div>

                <div id="image-preview" class="mt-4" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="w-full rounded-lg">
                    <p class="text-sm text-secondary mt-2">New image preview</p>
                </div>
            </div>
        </div>
    </div>
</form>

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
</script>
@endpush
@endsection
