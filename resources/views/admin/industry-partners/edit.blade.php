@extends('layouts.admin-modern')

@section('title', 'Edit Partner Industri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.industry-partners.index') }}" 
           class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Partner Industri</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi partner kerjasama</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.industry-partners.update', $industryPartner) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Partner <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $industryPartner->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Logo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Logo Saat Ini</label>
                <div class="w-48 h-48 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center p-4">
                    <img src="{{ asset('storage/' . $industryPartner->logo) }}" 
                         alt="{{ $industryPartner->name }}"
                         class="max-w-full max-h-full object-contain">
                </div>
            </div>

            <!-- Logo -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    Ganti Logo
                </label>
                <input type="file" 
                       name="logo" 
                       id="logo" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('logo') border-red-500 @enderror"
                       onchange="previewImage(event)">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF, SVG, WEBP. Maksimal 2MB. Kosongkan jika tidak ingin mengganti</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <!-- Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview Logo Baru:</p>
                    <div class="w-48 h-48 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center p-4">
                        <img id="preview" src="" alt="Preview" class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>

            <!-- Website -->
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    Website
                </label>
                <input type="url" 
                       name="website" 
                       id="website" 
                       value="{{ old('website', $industryPartner->website) }}"
                       placeholder="https://example.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('website') border-red-500 @enderror">
                @error('website')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $industryPartner->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order -->
            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan Tampil
                </label>
                <input type="number" 
                       name="order" 
                       id="order" 
                       value="{{ old('order', $industryPartner->order) }}"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Semakin kecil angka, semakin awal ditampilkan</p>
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active -->
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1"
                       {{ old('is_active', $industryPartner->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    Aktif (tampilkan di website)
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Perbarui
            </button>
            <a href="{{ route('admin.industry-partners.index') }}" 
               class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
