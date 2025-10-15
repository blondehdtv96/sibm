@extends('layouts.admin-modern')

@section('title', 'Edit Page')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Page</h2>
            <p class="text-sm text-gray-500 mt-1">Update page information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('public.pages.show', $page->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Page
            </a>
            <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Pages
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $page->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                <input 
                    type="text" 
                    name="slug" 
                    id="slug" 
                    value="{{ old('slug', $page->slug) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent font-mono text-sm @error('slug') border-red-500 @enderror"
                    required
                >
                <p class="mt-1 text-xs text-gray-500">URL-friendly version of the title</p>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="12"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('content') border-red-500 @enderror"
                    required
                >{{ old('content', $page->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Banner Image -->
            @if($page->banner_image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Banner Image</label>
                    <div class="relative inline-block">
                        <img src="{{ asset('storage/' . $page->banner_image) }}" alt="{{ $page->title }}" class="w-full max-w-md rounded-lg border border-gray-200">
                        <label class="absolute top-2 right-2">
                            <input type="checkbox" name="remove_banner" value="1" class="rounded border-gray-300 text-ios-blue focus:ring-ios-blue">
                            <span class="ml-2 text-sm text-white bg-red-600 px-2 py-1 rounded">Remove</span>
                        </label>
                    </div>
                </div>
            @endif

            <!-- Banner Image -->
            <div>
                <label for="banner_image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $page->banner_image ? 'Replace Banner Image' : 'Banner Image' }}
                </label>
                <input 
                    type="file" 
                    name="banner_image" 
                    id="banner_image" 
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('banner_image') border-red-500 @enderror"
                >
                <p class="mt-1 text-xs text-gray-500">Recommended size: 1200x400px (JPG, PNG, max 2MB)</p>
                @error('banner_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select 
                    name="status" 
                    id="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Information -->
            <div class="pt-6 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Page Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900 ml-2">{{ $page->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Last Updated:</span>
                        <span class="text-gray-900 ml-2">{{ $page->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                    Delete Page
                </button>
            </form>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.pages.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Update Page
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;
    
    titleInput.addEventListener('input', function() {
        if (slugInput.dataset.manualEdit !== 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });
    
    slugInput.addEventListener('input', function() {
        if (this.value !== originalSlug) {
            this.dataset.manualEdit = 'true';
        }
    });
});
</script>
@endpush
@endsection
