@extends('layouts.admin-modern')

@section('title', 'Edit Gambar - ' . $competency->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.competencies.index') }}" class="hover:text-blue-600">Kompetensi Keahlian</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('admin.competencies.images.index', $competency) }}" class="hover:text-blue-600">{{ $competency->name }}</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-900 font-medium">Edit Gambar</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Gambar Slider</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi gambar slider</p>
        </div>
        <a href="{{ route('admin.competencies.images.index', $competency) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.competencies.images.update', [$competency, $image]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Current Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                <div class="relative inline-block">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="w-full max-w-md rounded-lg border border-gray-200">
                </div>
            </div>

            <!-- Replace Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Ganti Gambar (Opsional)
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('image') border-red-500 @enderror"
                    onchange="previewImage(event)"
                >
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar (JPG, PNG, max 5MB)</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <img id="previewImg" src="" alt="Preview" class="w-full max-w-md rounded-lg border border-gray-200">
                </div>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul (Opsional)
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $image->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Contoh: Ruang Praktik Komputer"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi singkat tentang gambar..."
                >{{ old('description', $image->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan *</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        value="{{ old('order', $image->order) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('order') border-red-500 @enderror"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">Urutan tampilan di slider (angka lebih kecil = lebih awal)</p>
                    @error('order')
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
                        <option value="active" {{ old('status', $image->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $image->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="deleteImage()" class="px-6 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                Hapus Gambar
            </button>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.competencies.images.index', $competency) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Update Gambar
                </button>
            </div>
        </div>
    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('admin.competencies.images.destroy', [$competency, $image]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function deleteImage() {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
