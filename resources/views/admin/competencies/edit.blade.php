@extends('layouts.admin-modern')

@section('title', 'Edit Competency Program')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Competency Program</h2>
            <p class="text-sm text-gray-500 mt-1">Update competency program information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('public.competencies.show', $competency->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Program
            </a>
            <a href="{{ route('admin.competencies.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Competencies
            </a>
        </div>
    </div>

<form action="{{ route('admin.competencies.update', $competency) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="ios-card">
                <div class="form-group">
                    <label for="name" class="form-label required">Program Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-input @error('name') is-invalid @enderror" 
                        value="{{ old('name', $competency->name) }}"
                        required
                        autofocus
                    >
                    @error('name')
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
                        value="{{ old('slug', $competency->slug) }}"
                    >
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Leave empty to auto-generate from name</span>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label required">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="15" 
                        class="form-input @error('description') is-invalid @enderror"
                        required
                    >{{ old('description', $competency->description) }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="ios-card mb-6">
                <h3 class="card-title">Settings</h3>
                
                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="active" {{ old('status', $competency->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $competency->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input 
                        type="number" 
                        id="sort_order" 
                        name="sort_order" 
                        class="form-input @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $competency->sort_order) }}"
                        min="0"
                    >
                    @error('sort_order')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Program
                    </button>
                </div>
            </div>

            <div class="ios-card">
                <h3 class="card-title">Program Image</h3>
                
                @if($competency->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $competency->image) }}" 
                             alt="{{ $competency->name }}" 
                             class="w-full rounded-lg">
                        <p class="text-sm text-secondary mt-2">Current image</p>
                    </div>
                @endif

                <div class="form-group">
                    <label for="image" class="form-label">{{ $competency->image ? 'Replace Image' : 'Image' }}</label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        class="form-input @error('image') is-invalid @enderror"
                        accept="image/*"
                        onchange="previewImage(event)"
                    >
                    @error('image')
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
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function(e) {
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
</script>
@endpush
@endsection
