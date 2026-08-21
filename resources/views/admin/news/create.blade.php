@extends('layouts.admin-modern')

@section('title', 'Create News Article')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create News Article</h2>
            <p class="text-sm text-gray-500 mt-1">Add a new news article or announcement</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to News
        </a>
    </div>

<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror" 
                        value="{{ old('title') }}"
                        required
                        autofocus
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input 
                        type="text" 
                        id="slug" 
                        name="slug" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent font-mono text-sm @error('slug') border-red-500 @enderror" 
                        value="{{ old('slug') }}"
                    >
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from title</p>
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('excerpt') border-red-500 @enderror"
                        placeholder="Brief summary of the article..."
                    >{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from content</p>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        class="tinymce @error('content') border-red-500 @enderror"
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Publish Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select 
                            id="status" 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                            required
                        >
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('published_at') border-red-500 @enderror"
                            value="{{ old('published_at') }}"
                        >
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave empty to publish immediately</p>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Create Article
                    </button>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Category</h3>
                    <button type="button" 
                            onclick="openCategoryModal()" 
                            class="inline-flex items-center px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Category
                    </button>
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('category_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($categories->isEmpty())
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-800">No categories available. Click "New Category" button above to create one.</p>
                    </div>
                @endif
            </div>

            <!-- Featured Image -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h3>
                
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input 
                        type="file" 
                        id="featured_image" 
                        name="featured_image" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('featured_image') border-red-500 @enderror"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max 20MB (JPEG, PNG, JPG, GIF)</p>
                </div>

                <div id="image-preview" class="mt-4" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="w-full rounded-lg border border-gray-200">
                </div>
            </div>

            <!-- Gallery Images -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery Images</h3>
                <p class="text-sm text-gray-600 mb-4">Upload multiple photos untuk galeri artikel</p>
                
                <div>
                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">Images</label>
                    <input 
                        type="file" 
                        id="gallery_images" 
                        name="images[]" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('images') border-red-500 @enderror"
                        accept="image/*"
                        multiple
                        onchange="previewGalleryImages(event)"
                    >
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max 20MB per image (JPEG, PNG, JPG, GIF). Multiple selection allowed.</p>
                </div>

                <!-- Gallery Preview -->
                <div id="gallery-preview" class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4">
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@push('scripts')
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function(e) {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        delete this.dataset.autoGenerated;
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
                           class="w-full mt-2 px-3 py-1 text-xs border border-gray-300 rounded focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    // Category Modal Functions
    function openCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('new_category_name').focus();
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryError').classList.add('hidden');
        document.getElementById('categorySuccess').classList.add('hidden');
    }

    // Create Category via AJAX
    async function createCategory(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const errorDiv = document.getElementById('categoryError');
        const successDiv = document.getElementById('categorySuccess');
        const categoryName = document.getElementById('new_category_name').value;
        const categorySlug = document.getElementById('new_category_slug').value;
        
        // Hide previous messages
        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';
        
        try {
            const response = await fetch('{{ route("admin.news-categories.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: categoryName,
                    slug: categorySlug
                })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Show success message
                successDiv.textContent = 'Category created successfully!';
                successDiv.classList.remove('hidden');
                
                // Add new category to select dropdown
                const select = document.getElementById('category_id');
                const option = new Option(data.category.name, data.category.id, true, true);
                select.add(option);
                
                // Close modal after 1 second
                setTimeout(() => {
                    closeCategoryModal();
                }, 1000);
            } else {
                // Show error message
                errorDiv.textContent = data.message || 'Failed to create category';
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            errorDiv.textContent = 'An error occurred. Please try again.';
            errorDiv.classList.remove('hidden');
        } finally {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Create Category';
        }
    }

    // Auto-generate category slug
    document.getElementById('new_category_name').addEventListener('input', function(e) {
        const slugInput = document.getElementById('new_category_slug');
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    document.getElementById('new_category_slug').addEventListener('input', function() {
        delete this.dataset.autoGenerated;
    });
</script>
@endpush

<!-- Category Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">Create New Category</h3>
            <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="categoryForm" onsubmit="createCategory(event)" class="p-6 space-y-4">
            <!-- Success Message -->
            <div id="categorySuccess" class="hidden p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800"></div>
            
            <!-- Error Message -->
            <div id="categoryError" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800"></div>
            
            <div>
                <label for="new_category_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input 
                    type="text" 
                    id="new_category_name" 
                    name="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                    required
                    placeholder="e.g., School Events"
                >
            </div>
            
            <div>
                <label for="new_category_slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input 
                    type="text" 
                    id="new_category_slug" 
                    name="slug" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent font-mono text-sm"
                    placeholder="e.g., school-events"
                >
                <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from name</p>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeCategoryModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors inline-flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
